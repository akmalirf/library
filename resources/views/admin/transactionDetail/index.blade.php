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
    <!-- /.card-body -->
    <!-- <div class="card-footer clearfix">
      <ul class="pagination pagination-sm m-0 float-right">
        <li class="page-item"><a class="page-link" href="#">&laquo;</a></li>
        <li class="page-item"><a class="page-link" href="#">1</a></li>
        <li class="page-item"><a class="page-link" href="#">2</a></li>
        <li class="page-item"><a class="page-link" href="#">3</a></li>
        <li class="page-item"><a class="page-link" href="#">&raquo;</a></li>
      </ul>
    </div> -->
  </div>
</div>
@endsection