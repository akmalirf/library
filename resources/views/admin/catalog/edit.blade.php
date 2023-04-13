@extends('layouts.admin')
@section('header','catalog')

@section('content')
<div class="container-fluid">
  <div class="col-sm-11">
    <div class="card card-primary row">
      <div class="card-header col-ms">
        <h3 class="card-title">Edit Catalog</h3>
      </div>
      <form action="{{ url('catalogs/'.$catalog->id) }}" method="post">
        @csrf
        {{method_field('PUT')}}
        <div class="card-body">
          <div class="form-group">
            <label>Name</label>
            <input type="text" name="name" class="form-control" placeholder="Enter name" value="{{$catalog->name}}" required="">
          </div>
        <div class="card-footer">
          <button type="submit" class="btn btn-primary">Submit</button>
        </div>
      </form>
    </div>     
  </div>
</div>     
@endsection