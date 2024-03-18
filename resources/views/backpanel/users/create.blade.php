@extends('backpanel.index')

@section('content')
    <div class="m-5">
        
        @include('backpanel.layouts.errors')
        @can('Create User')
        <form action="{{ route('user.store') }}" method="POST" class="" enctype="multipart/form-data">
            @csrf
            <div class="form-group my-4">
                <label for="name">Name</label>
                <input 
                style="border:2px solid purple;padding:5px 5px"
                    id="name" 
                    name="name" 
                    type="text"
                    class="form-control"
                    placeholder="Enter User Name"
                    value="{{old('name')}}"
                    />
            </div>
            <div class="form-group my-4">
                <label for="email">Email</label>
                <input 
                style="border:2px solid purple;padding:5px 5px"
                    id="email" 
                    name="email" 
                    type="email"
                    class="form-control"
                    placeholder="Enter User Email"
                    value="{{old('email')}}"
                    />
            </div>
            <div class="form-group my-4">
                <label for="password">Password</label>
                <input 
                style="border:2px solid purple;padding:5px 5px"
                    id="password" 
                    name="password" 
                    type="password"
                    class="form-control"
                    placeholder="Enter User Password"
                    />
            </div>
            <div class="form-group my-3">
                <label for="roles">Roles</label>
                <select name="role_name" id="roles" class='form-control' style="border:2px solid purple;padding:5px;">
                    <option value="" hidden >--Select Role--</option>
                    @foreach ($roles as $role)
                        @if (auth()->user()->checkRoles($role))
                        <option value="{{$role->name}}">{{strtoupper($role->name)}}</option>
                        @endif
                    @endforeach
                </select>
            </div>
                <button class="btn btn-outline-success rounded btn" type="submit">Save User</button>
                <a href="{{ route('user.index') }}" class="btn btn-outline-success btn">All Users</a>
            </form>
            @endcan
            @cannot('Create User')
            <h1 class="text-center text-danger">Sorry!! You cant Create User</h1>
            @endcannot
    </div>
@endsection