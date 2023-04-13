@extends('layouts.admin')
@section('header','User')

@section('content')
<div class="container-fluid">
  <div class="card table-responsive">
    <div class="card-header">{{ __('Member') }}</div>

    <div class="card-body">
      <table class="table table-bordered">
        <thead>
          <tr>
            <th style="width: 10px">#</th>
            <th>Name</th>
            <th>Gender</th>
            <th>Email</th>
            <th>Phone number</th>
            <th>Address</th>
            <th>Created at</th>
          </tr>
        </thead>
        <tbody>
          @foreach($members as $key=>$member)
          <tr>
            <td>{{$key+1}}</td>
            <td>{{$member->name}}</td>
            <td>{{$member->gender}}</td>
            <td>{{$member->email}}</td>
            <td>{{$member->phone_number}}</td>
            <td>{{$member->address}}</td>
            <td>{{ convert_date($member->created_at)}}</td>
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