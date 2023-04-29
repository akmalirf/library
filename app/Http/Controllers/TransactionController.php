<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\Member;
use App\Models\book;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $transactions = Transaction::with('member')->get();

        // return $transactions;
        return view('admin.transaction.index', compact('transactions'));
    }

    public function api(Request $request)
    {
        if ($request->status) {
            $transactions = Transaction::where('status', '=', $request->status)
                ->select(
                    'transaction_id',
                    'members.name',
                    'date_start',
                    'date_end',
                    'status',
                    TransactionDetail::raw('count(transaction_details.transaction_id) as total_book'),
                    Book::raw('sum(books.price) as total_price')
                )
                ->leftJoin('members', 'transactions.member_id', '=', 'members.id')
                ->leftJoin('transaction_details', 'transactions.id', '=', 'transaction_details.transaction_id')
                ->leftJoin('books', 'transaction_details.book_id', '=', 'books.id')
                ->groupBy('transaction_details.transaction_id', 'members.name', 'date_start', 'date_end', 'status')
                ->get();
        } else{
            $transactions = Transaction::select(
                'transaction_id',
                'members.name',
                'date_start',
                'date_end',
                'status',
                TransactionDetail::raw('count(transaction_details.transaction_id) as total_book'),
                Book::raw('sum(books.price) as total_price')
            )
                ->leftJoin('members', 'transactions.member_id', '=', 'members.id')
                ->leftJoin('transaction_details', 'transactions.id', '=', 'transaction_details.transaction_id')
                ->leftJoin('books', 'transaction_details.book_id', '=', 'books.id')
                ->groupBy('transaction_details.transaction_id', 'members.name', 'date_start', 'date_end', 'status')
                ->get();
        }

        $datatables = datatables()->of($transactions)
            ->addColumn('period', function ($transaction) {
                $startTimeStamp = strtotime($transaction->date_start);
                $endTimeStamp = strtotime($transaction->date_end);

                $timeDiff = abs($endTimeStamp - $startTimeStamp);

                $numberDays = $timeDiff / 86400;  // 86400 seconds in one day

                // and you might want to convert to integer
                $numberDays = intval($numberDays);

                return $numberDays;
            })
            ->addColumn('status_transaction', function ($transaction) {
                $status_transaction = $transaction->status;;
                return $status_transaction;
            })
            ->addColumn('rupiah', function ($transaction) {
                $rupiah = rupiah($transaction->total_price);

                return $rupiah;
            })


            ->addIndexColumn();

        return $datatables->make(true);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $members = Member::all();
        $books = Book::where('qty', '>', '0')->get();
        return view('admin.transaction.create', compact('members', 'books'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        //dd($data);

        try {

            \DB::beginTransaction();

            $transaction = new Transaction;
            $transaction->member_id = $data['member_id'];
            $transaction->date_start = $data['date_start'];
            $transaction->date_end = $data['date_end'];
            $transaction->status = 'unfinished';
            $transaction->save();

            $total_book = count($data['book_id']);

            //dd($status1);
            if ($total_book > 0) {
                foreach ($data['book_id'] as $item => $value) {
                    $data2 = array(
                        'transaction_id' => $transaction->id,
                        'book_id' => $data['book_id'][$item],
                    );
                    Book::where('id', '=', $data['book_id'][$item])->decrement('qty', 1);
                    TransactionDetail::create($data2);
                }
            }

            \DB::commit();
        } catch (\Throwable $th) {

            \DB::rollback();
            return redirect('transactions/create')->with('error', $th->getMessage());
        }
        return redirect('transactions')->with('status', 'Transaction created success!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function show(Transaction $transaction)
    {

        $transactionDetails = Transaction::with('member', 'transaction_details')->where('id', $transaction->id)->first();
        $books = TransactionDetail::select('books.title')
            ->leftJoin('books', 'transaction_details.book_id', '=', 'books.id')
            ->where('transaction_id', $transaction->id)->get();

        //return $books;
        return view('admin.transaction.show', compact('transactionDetails', 'transaction', 'books'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function edit(Transaction $transaction)
    {

        $members = Member::all();
        $books = Book::where('qty', '>', '0')->get();

        $transaction_id = $transaction->id;

        $select = TransactionDetail::select('*')->where('transaction_id', '=', $transaction_id)->pluck('book_id');
        $select_books = json_decode(json_encode($select), true);

        return view('admin.transaction.edit', compact('transaction', 'members', 'books', 'select_books'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Transaction $transaction)
    {
        $data = $request->all();

        $updated = validate_checkThings($data['status'], $transaction->status);

        TransactionDetail::where('transaction_id', $transaction->id)->delete();

        try {

            \DB::beginTransaction();


            $transaction->update([
                'member_id' => $data['member_id'],
                'date_start' => $data['date_start'],
                'date_end' => $data['date_end'],
                'status' => $data['status'],
            ]);

            $status = $transaction->status;
            $newStatus = $data['status'];
            $status1 = $status;
            $total_book = count($data['book_id']);

            //dd($status1);
            if ($total_book > 0) {
                foreach ($data['book_id'] as $item => $value) {
                    $data2 = array(
                        'transaction_id' => $transaction->id,
                        'book_id' => $data['book_id'][$item],
                    );

                    if ($updated == false) {
                        if ($status == 'finished') {
                            Book::where('id', '=', $data['book_id'][$item])->increment('qty', 1);
                        } else {
                            Book::where('id', '=', $data['book_id'][$item])->decrement('qty', 1);
                        }
                    }
                    TransactionDetail::create($data2);
                }
            }
            \DB::commit();
        } catch (\Throwable $th) {

            \DB::rollback();
            return redirect('transactions')->with('error', $th->getMessage());
        }
        return redirect('transactions')->with('status', 'Transaction created success!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transaction $transaction)
    {
        $transaction->delete();

        return redirect('transactions');
    }
}
