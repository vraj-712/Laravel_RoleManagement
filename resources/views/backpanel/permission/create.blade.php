@extends('backpanel.index')
@section('content')
    <div class="m-5">
        <div class="d-flex justify-content-between">
        </div>
        @include('backpanel.layouts.errors')
        @can('Create-Permission')
            <div class="my-2 d-flex justify-content-between">
                <a href="{{route('category.create')}}" class="btn btn-outline-success  btn">Create Category For Permission</a>
            </div>
        <form action="{{ route('permission.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group my-3">
                <label for="permission_categories">Categories</label>
                <select name="permission_category_id" id="permission_category_id" class='form-control' style="border:2px solid purple;padding:5px;">
                    <option value="" hidden >--Select Role--</option>
                    @foreach ($permission_categories as $permission_category)
                        <option value="{{$permission_category->id}}">{{strtoupper($permission_category->permission_category_name)}}</option>
                    @endforeach
                </select>
            </div>
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