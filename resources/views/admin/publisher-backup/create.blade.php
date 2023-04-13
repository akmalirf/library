@extends('layouts.admin')
@section('header','publisher')

@section('content')
<div class="container-fluid">
  <div class="col-sm-11">
    <div class="card card-primary row">
      <div class="card-header col-ms">
        <h3 class="card-title">Create New Publisher</h3>
      </div>
      <form action="{{ route('publishers.store') }}" method="post">
        @csrf
        <div class="card-body">
          <div class="form-group">
            <label>Name</label>
            <input type="text" name="name" class="form-control" placeholder="Enter name" min="5" max="30" required="">
            <label>Email</label>
            <input type="email" name="email" class="form-control" placeholder="Enter email" required="email">
            <label>Phone Number</label>
            <input type="tel" name="phone_number" class="form-control" placeholder="Enter number" required="tel">
            <label>Address</label>
            <input type="text" name="address" class="form-control" placeholder="Enter address" required="">
          </div>
        <div class="card-footer">
          <button type="submit" class="btn btn-primary">Submit</button>
        </div>
      </form>
    </div>     
  </div>
</div>     
@endsection