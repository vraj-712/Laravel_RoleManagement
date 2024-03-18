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
<h2>All User</h2>
<div class="d-flex justify-content-between">
    @can('Create User')
    <a href="{{route('user.create')}}" class="btn btn-outline-success  btn">Create User</a>
    @endcan
</div>
<table class="table table-hover text-center table-bordered table-bordered table-striped">
    <thead class="table-dark">
        <tr >
            <th>Name</th>
            <th>Email</th>
            <th>Role</th>
            <th>Action</th>
        </tr>
    </thead>
    @forelse ($users as $user)

    <tr>
            <td>{{$user->name}}</td>
            <td>{{$user->email}}</td>
            <td>{{$user->roles[0]->name}}</td>
            <td>
                @can('Update User')
                @if ($user->checkAccessForUpdate($user))
                    <a href="{{ route('user.edit',$user->id) }}" class = "btn btn-warning  btn-md rounded">Edit</a>    
                @endif
                @endcan
                @can('Delete User')
                @if ($user->checkAccessForDelete($user))
                <form action="{{ route('user.destroy',$user->id) }}" class="d-inline" method="POST">
                    @csrf
                    @method('delete')
                    <button typr="submit" class = "btn btn-danger btn-md rounded">Delete</button>
                </form>
                @endif
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