@extends('backpanel.index')

@section('content')
<div class="m-5">
    
@includ
@can('Create-Role')
    
<form action="{{ route('role.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group my-4">
            <label for="name">Role</label>
            <input 
            style="border:2px solid purple;padding:5px 5px"
            id="name" 
            name="name" 
            type="text"
            class="form-control"
            placeholder="Enter Role Name"
            />
        </div>
        
        <button class="btn btn-outline-success rounded btn" type="submit">Save Role</button>
        <a href="{{ route('role.index') }}" class="btn btn-outline-success btn">All Roles</a>
    </form>
@endcan('backpanel.layouts.errors')
@cannot('Create-Role')
    <h1 class="text-center text-danger">Sorry!! You cant create Role</h1>
@endcannot
</div>
@endsection