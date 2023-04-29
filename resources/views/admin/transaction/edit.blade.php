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
        <h3 class="card-title">Edit Transaction</h3>
      </div>
      @if (session('error'))
        <div class="alert alert-danger">
          {{ session('error')}}
        </div>
      @endif
      <form action="{{ route('transactions.update',$transaction->id) }}" method="post">
        @csrf
        {{method_field('PUT')}}
        <div class="col-4"></div>
        <div class="card-body">
          <div class="form-group row">
            <div class="col-4"><label>Member name</label></div>
            <div class="col-8">
              <select name="member_id" class="form-control">
              @foreach ($members as $member)
              <option {{ $member->id == $transaction->member_id ? 'selected' : '' }} value="{{$member->id}}">{{$member->name}}</option>
              @endforeach
            </select>
            </div>
          </div>
          <div class="form-group row"> 
            <div class="col-4"><label>Date</label></div>
            <div class="col-8 row align-items-center">
              <div class="input-group col-5 date">
                  <input name="date_start" type="date" value="{{$transaction->date_start}}" class="form-control">
              </div>
              <span class="col-auto"><i class="fa fa-minus"></i></span>
              <div class="input-group col-5 date">
                  <input name="date_end" type="date"  value="{{$transaction->date_end}}" class="form-control">
              </div>
            </div>
          </div>
          <div class="form-group row">
            <div class="col-4"><label>Books</label></div>
            <div class="col-8 select2-purple">
              <select name="book_id[]" class="form-control select2" multiple="multiple" data-placeholder="Select a State" style="width: 100%;">
              @foreach ($books as $book)
                <option {{ validate_valueIn($book->id,$select_books) == 1 ? 'selected' : '' }} value="{{$book->id}}">{{$book->title}}[{{$book->qty}}]</option>
              @endforeach
              </select>
            </div>
          </div>
          <div class="form-group row">
            <div class="col-4"><label>Status</label></div>
            <div class="col-8">
                        <div class="form-check">
                          <input class="form-check-input" value="finished" type="radio" name="status" {{ $transaction->status == "finished" ? 'checked' : '' }}>
                          <label class="form-check-label">Finished</label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" value="unfinished" type="radio" name="status" {{ $transaction->status == "unfinished" ? 'checked' : '' }}>
                          <label class="form-check-label">Unfinished</label>
                        </div>
            </div>
          </div>
        </div>
        <div class="card-footer">
          <button type="submit" class="btn btn-primary">Submit</button>
        </div>
      </form>
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

