@extends('backpanel.index')

@section('content')
<div class="m-5">
    <div class="d-flex justify-content-between">
    </div>
    @include('backpanel.layouts.errors')
    @can('Update-Role')
        
    <form action="{{ route('role.update', $role->id)}}" method="POST">
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
            placeholder="Enter Role Name"
            value="{{$role->name}}"
            />
        </div>
            
        
        <button class="btn btn-outline-success rounded btn" type="submit">Update Role</button>
        <a href="{{ route('role.index') }}" class="btn btn-outline-success btn">All Roles</a>
    </form>
    @endcan

    @cannot('Update-Role')
    <h1 class="text-center text-danger">Sorry!! You cant Update Role</h1>
    @endcannot

</div>
@endsection