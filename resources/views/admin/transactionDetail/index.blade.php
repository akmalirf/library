@extends('layouts.admin')
@section('header','Transaction Detail')

@section('content')
<div class="container-fluid">
  <div class="card table-responsive">
    <div class="card-header">{{ __('Transaction Detail') }}</div>

    <div class="card-body">
      <table class="table table-bordered">
        <thead>
          <tr>
            <th style="width: 10px">#</th>
            <th>Transaction id</th>
            <th>Title Book[id]</th>
            <th>Qty</th>
            <th>Created at</th>
          </tr>
        </thead>
        <tbody>
          @foreach($transaction_details as $key=>$transaction_detail)
          <tr>
            <td>{{$key+1}}</td>
            <td>{{$transaction_detail->transaction_id}}</td>
            <td>{{$transaction_detail->book->title}}[{{$transaction_detail->book_id}}]</td>
            <td>{{$transaction_detail->qty}}</td>
            <td>{{convert_date($transaction_detail->created_at)}}</td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection