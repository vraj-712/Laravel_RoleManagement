@extends('backpanel.index')
@section('content')
    <div class="m-5">
        <div class="d-flex justify-content-between">
        </div>
        @include('backpanel.layouts.errors')
        @can('Create-Permission')
            
        <form action="{{ route('permission.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group my-4">
                <label for="name">Permission Name</label>
                <input 
                style="border:2px solid purple;padding:5px 5px"
                id="name" 
                name="name" 
                type="text"
                class="form-control"
                placeholder="Enter Permission Name"
                />
            </div>
            
            <button class="btn btn-outline-success rounded btn" type="submit">Save permission</button>
            <a href="{{ route('permission.index') }}" class="btn btn-outline-success btn">All permissions</a>
        </form>
        @endcan
        @cannot('Create-Permission')
        <h1 class="text-center text-danger">Sorry!! You cant Create permission</h1>
        @endcannot
    </div>
@endsection