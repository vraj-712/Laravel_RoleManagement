@extends('backpanel.index')
@section('content')
<div class="m-5">
    @if (session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{session('success')}}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
@endif
@include('backpanel.layouts.errors')

<h2>All permissions</h2>
<div class="d-flex justify-content-between">
    @can('Create-Permission')
    <a href="{{route('permission.create')}}" class="btn btn-outline-success  btn">Create Permission</a>
    @endcan
</div>
<table class="table table-hover text-center  table-bordered table-bordered table-striped">
    <thead class="table-dark">
    <tr>
        <th>Permissions</th>
        <th>Action</th>
    </tr>
    </thead>
        @forelse ($permissions as $permission)
            <tr>
            <td>{{$permission->name}}</td>
            <td>
                @can('Update-Permission')
                <a href="{{ route('permission.edit',$permission->id) }}" class = "btn btn-warning btn-md rounded">Edit</a>
                @endcan
                @can('Delete-Permission')
                    
                <form class="d-inline" action="{{ route('permission.destroy',$permission->id) }}" method="POST">
                    @csrf
                    @method('delete')
                    <button typr="submit" class = "btn btn-danger btn-md rounded">Delete</button>
                </form>
                @endcan
            </td>
            </tr>
        @empty
            <tr>
                <td colspan='4'><h3 class='text-center'>Data Not Found !!</h3></td>
            </tr>
        @endforelse
</table>

</div>
@endsection