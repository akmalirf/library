@extends('layouts.admin')
@section('header','Publisher')

@section('content')
<div class="container-fluid">
  <div class="card table-responsive">
    <div class="card-header">
    <a href="{{ route('publishers.create')}}" class="btn btn-sm btn-primary pull-right">Create New Publisher</a>
    </div>

    <div class="card-body">
      <table class="table table-striped">
        <thead>
          <tr>
            <th style="width: 10px">#</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone number</th>
            <th>Address</th>
            <th>Total Books</th>
            <th>Created at</th>
            <th colspan="2">Action</th>
          </tr>
        </thead>
        <tbody>
          @foreach($publishers as $key=>$publisher)
          <tr>
            <td>{{$key+1}}</td>
            <td>{{$publisher->name}}</td>
            <td>{{$publisher->email}}</td>
            <td>{{$publisher->phone_number}}</td>
            <td>{{$publisher->address}}</td>
            <td>{{count($publisher->books)}}</td>
            <td>{{ convert_date($publisher->created_at)}}</td>
            <td>
              <a href="{{ route('publishers.edit',$publisher->id)}}" class="btn btn-warning btn-sm">Edit</a>
            </td>
            <td>
              <form action="{{ route('publishers.destroy',$publisher->id) }}" method="post">
                <button class="btn btn-danger btn-sm" type="sumbit" onclick="return confirm('Are you sure?')">Delete</button>
                @method('delete')
                @csrf
              </form>
            </td>
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