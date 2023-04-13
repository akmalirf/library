<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\User;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\Book;
use App\Models\Publisher;
use App\Models\Author;
use App\Models\Catalog;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // $Members = Member::with('user')->get();
        // $books = Book::with('publisher','author','catalog')->get();
        // $publishers = Publisher::with('books')->get();
        // $catalogs = Catalog::with('books')->get();
        // $publishers = Publisher::with('books')->get();
        // $members = Member::with('transactions')->get();
        // $transactions = Transaction::with('member')->get();
        // $transactions = Transaction::with('transaction_details')->get();
        // $transaction_details = TransactionDetail::with('book')->get();

        // return $books;
        //No1
        $data = Member::select('*')
                    ->join('users','users.member_id','=','members.id')
                    ->get();

        //No2
        $data2 = Member::select('members.*')
                    ->leftjoin('users','members.id','=','users.member_id')
                    ->where('users.id',NULL)
                    ->get();

        //No3
        $data3 = Member::select('members.id as memberID','members.name','transactions.id as transactionID')
                    ->leftJoin('transactions','members.id','=','transactions.member_id')
                    ->where('transactions.id',NULL)
                    ->get();

        //No4
        $data4 = Member::select('members.id as memberID','members.name','transactions.id as transactionID')
                    ->leftJoin('transactions','members.id','=','transactions.member_id',)
                    ->where('transactions.id','is Not',NULL)
                    ->get();

        //No5
        $data5 = Transaction::select('members.name','members.id','members.phone_number',Transaction::raw('COUNT(members.name) as total'))
        ->join('members','transactions.member_id','=','members.id')
        ->groupBy('members.name','members.id','members.phone_number')
        ->having(Transaction::raw('COUNT(members.name)'),'>',1)->get();

        //No6
        $data6 = Transaction::select('members.id','members.name','members.phone_number','members.address','transactions.date_start','transactions.date_end')
                    ->leftJoin('members','transactions.member_id','=','members.id')
                    ->get();
                    
        //No7
        $data7 = Transaction::select('members.name','members.phone_number','members.address','transactions.date_start','transactions.date_end')
                    ->leftJoin('members','transactions.member_id','=','members.id')
                    ->whereMonth('transactions.date_end','=',02)
                    ->get();

        //No8
        $data8 = Transaction::select('members.name','members.phone_number','members.address','transactions.date_start','transactions.date_end')
                    ->leftJoin('members','transactions.member_id','=','members.id')
                    ->whereMonth('transactions.date_end','=','03')
                    ->get();

        //No9
        $data9 = Transaction::select('members.name','members.phone_number','members.address','transactions.date_start','transactions.date_end')
                    ->leftJoin('members','transactions.member_id','=','members.id')
                    ->whereMonth('transactions.date_start','=','02')
                    ->whereMonth('transactions.date_end','=','02')
                    ->get();

        //No10
        $data10 = Transaction::select('members.name','members.phone_number','members.address','transactions.date_start','transactions.date_end')
                    ->leftJoin('members','transactions.member_id','=','members.id')
                    ->where('members.address','like','%Abernathy%')
                    ->get();

        //No11
        $data11 = Transaction::select('members.name','members.gender','members.phone_number','members.address','transactions.date_start','transactions.date_end')
                    ->leftJoin('members','transactions.member_id','=','members.id')
                    ->where('members.address','like','%A%')
                    ->where('members.gender','=','P')
                    ->get();

        //No12
        $data12 = Transaction::select('members.name','members.phone_number','members.address','transactions.date_start','transactions.date_end','books.isbn','transaction_details.qty')
                    ->leftJoin('members','transactions.member_id','=','members.id')
                    ->leftJoin('transaction_details','transactions.id','=','transaction_details.transaction_id')
                    ->leftjoin('books','transaction_details.book_id','=','books.id')
                    ->where('transaction_details.qty','>',1)
                    ->get();

        //No13
        $data13 = Transaction::select('members.name','members.phone_number','members.address','transactions.date_start','transactions.date_end','books.isbn','books.price','books.title','transaction_details.qty',Transaction::raw('books.price * transaction_details.qty as total_harga'))
                    ->leftJoin('members','transactions.member_id','=','members.id')
                    ->leftJoin('transaction_details','transactions.id','=','transaction_details.transaction_id')
                    ->leftJoin('books','transaction_details.book_id','=','books.id')
                    ->get();

        //No14
        $data14 = Transaction::select('members.name','members.phone_number','members.address','transactions.date_start','transactions.date_end','books.isbn','books.price','transaction_details.qty','books.title','publishers.name as publisher','authors.name as author','catalogs.name as catalog')
                    ->leftJoin('members','transactions.member_id','=','members.id')
                    ->leftJoin('transaction_details','transactions.id','=','transaction_details.transaction_id')
                    ->leftJoin('books','transaction_details.book_id','=','books.id')
                    ->leftJoin('publishers','books.publisher_id','=','publishers.id')
                    ->leftJoin('authors','books.author_id','=','authors.id')
                    ->leftJoin('catalogs','books.catalog_id','=','catalogs.id')
                    ->get();

        //No15
        $data15 = Catalog::select('catalogs.id as id_catalog','catalogs.name as name_catalog','books.title')
                    ->leftJoin('books','books.catalog_id','=','catalogs.id')
                    ->get();

        //No16
        $data16 = Book::select('books.*','publishers.name as publisher_name')
                    ->rightJoin('publishers','books.publisher_id','=','publishers.id')
                    ->get();

        //No17
        $data17 = Book::select('authors.name','books.author_id',Book::raw('count(books.author_id) as total'))
                    ->leftJoin('authors','books.author_id','=','authors.id')
                    ->groupBy('authors.name','books.author_id')
                    ->get();

        //No18
        $data18 = Book::select('books.title','books.price')
                    ->where('books.price','>',10000)
                    ->get();
        //No19
        $data19 = Book::select('books.*')
                    ->rightJoin('publishers','books.publisher_id','=','publishers.id')
                    ->where('publishers.id','=',1)
                    ->where('books.qty','>',10)
                    ->get();

        //No20
        $data20 = Member::select('members.*')
                    ->whereMonth('created_at',02)
                    ->get();
        ;
        
        $data55 = Transaction::with('transaction_details')->get();
        //return $data55;

        return view('home');
    }
}
