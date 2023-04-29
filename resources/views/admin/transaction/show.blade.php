@extends('layouts.admin')
@section('header','Transaction')

@section('css')
  <!-- Select2 -->
  <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css')}}">
  <link rel="stylesheet" href="{{ asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
@endsection

@section('content')
<div class="container-fluid">
  <div class="col-sm-8 mx-auto">
    <div class="card card-primary row">
      <div class="card-header col-ms">
        <h3 class="card-title">Detail Transaction</h3>
      </div>
      @if (session('error'))
        <div class="alert alert-danger">
          {{ session('error')}}
        </div>
      @endif
      <div class="card-body">
        <div class="form-group row">
          <div class="col-4"><label>Member name</label></div>
          <div class="col-8">
            <h5>{{$transactionDetails->member->name}}</h5>
          </div>
        </div>
        <div class="form-group row">
          <div class="col-4"><label>Date Start</label></div>
          <div class="col-8">
            <h5>{{$transactionDetails->date_start}}</h5>
          </div>
        </div>
        <div class="form-group row">
          <div class="col-4"><label>Book</label></div>
          <div class="card col-8">
            @foreach($books as $book)
            <li>{{$book->title}}</li>
            @endforeach
          </div>
        </div>
        <div class="form-group row">
          <div class="col-4"><label>Status</label></div>
          <div class="col-8">
            <h5>{{$transactionDetails->status}}</h5>
          </div>
        </div>
      </div>
      <div class="card-footer">
        <a href="{{url ('/transactions')}}" class="btn btn-primary">Back</a>
      </div>
    </div>
  </div>
</div>     
@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<!-- Select2 -->
<script src="{{ asset('assets/plugins/select2/js/select2.full.min.js')}}"></script>
<!-- jQuery -->
<script src="{{ asset('assets/plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- Select2 -->
<script src="{{ asset('assets/plugins/select2/js/select2.full.min.js')}}"></script>
<script>
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()

    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })
  })
  </script>
@endsection

