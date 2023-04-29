@extends('layouts.admin')
@section('header','catalog')

@section('content')
<div class="container-fluid">
  <div class="card table-responsive">
    <div class="card-header">
      <a href="{{ url('catalogs/create')}}" class="btn btn-sm btn-primary pull-right">Create New Catalog</a>
    </div>

    <div class="card-body">
      <table class="table table-bordered">
        <thead class="text-center">
          <tr>
            <th style="width: 10px">#</th>
            <th>Name</th>
            <th>Total Books</th>
            <th>Created at</th>
            <th colspan="2">Action</th>
          </tr>
        </thead>
        <tbody>
          @foreach($catalogs as $key=>$catalog)
          <tr>
            <td>{{$key+1}}</td>
            <td>{{$catalog->name}}</td>
            <td>{{count($catalog->books)}}</td>
            <td>{{ convert_date($catalog->created_at)}}</td>
            <td>
              <a href="{{ url('catalogs/'.$catalog->id.'/edit')}}" class="btn btn-warning btn-sm">Edit</a>
            </td>
            <td>
              <form action="{{ url('catalogs', ['id' => $catalog->id]) }}" method="post">
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
  </div>
</div>
@endsection