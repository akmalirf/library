<?php

namespace App\Http\Controllers;

use App\Models\Publisher;
use App\Models\Book;
use Illuminate\Http\Request;

class PublisherController extends Controller
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
    public function index()
    {   
        $publishers = Publisher::with('books')->get();

        return view('admin.publisher.index');
    }

    public function api()
    {
        $publishers = Publisher::all();

        $datatables = datatables()->of($publishers)
                            ->addColumn('date', function($publisher){
                                return convert_date($publisher->created_at);
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
        return view('admin.publisher.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'name'=> 'required|min:5|max:30',
            'email' => 'required|email',
            'phone_number' => 'required',
            'address' => 'required']
        );
    
        Publisher::create($request->all());

        // return $request;
        return redirect('publishers');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Publisher  $publisher
     * @return \Illuminate\Http\Response
     */
    public function show(Publisher $publisher)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Publisher  $publisher
     * @return \Illuminate\Http\Response
     */
    public function edit(Publisher $publisher)
    {
        //
        return view('admin.publisher.edit',compact('publisher'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Publisher  $publisher
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Publisher $publisher)
    {
        $this->validate($request,[
            'name'=> 'required|min:5|max:30|alpha_num:ascii',
            'email' => 'required|email',
            'phone_number' => 'required',
            'address' => 'required']);
    

        $publisher->update($request->all());
        
        return redirect('publishers');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Publisher  $publisher
     * @return \Illuminate\Http\Response
     */
    public function destroy(Publisher $publisher)
    {
        $publisher->delete();

        return redirect('publishers');
    }
}
