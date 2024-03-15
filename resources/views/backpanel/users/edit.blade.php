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
        <form action="{{ route('user.update', $user->id)}}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group my-4">
                <label for="name">Update Name</label>
                <input 
                style="border:2px solid purple;padding:5px 5px"
                id="name" 
                name="name" 
                    type="text"
                    class="form-control"
                    placeholder="Enter User Name"
                    value="{{$user->name}}"
                    />
                </div>
            <div class="form-group my-4">
                <label for="email">Update Email</label>
                <input 
                style="border:2px solid purple;padding:5px 5px"
                id="email" 
                name="email" 
                type="email"
                class="form-control"
                placeholder="Enter User Email"
                value="{{ $user->email}}"
                disabled
                />
            </div>
            <div class="form-group my-3">
                <label for="roles">Roles</label>
                <select name="role_name" id="roles" class='form-control' style="border:2px solid purple;padding:5px;">
                    @foreach ($roles as $role)
                    @if (auth()->user()->checkRoles($role))
                    <option value="{{$role->name}}"@if($role->id === $user->roles[0]->id) selected @endif>{{strtoupper($role->name)}}</option>
                    @endif
                    @endforeach
                </select>
            </div>
            <button class="btn btn-outline-success rounded btn" type="submit">Update User</button>
            <a href="{{ route('user.index') }}" class="btn btn-outline-success btn">All Users</a>
        </form>
    </div>
    @endsection