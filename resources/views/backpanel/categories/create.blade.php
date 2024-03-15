@extends('backpanel.index')
@section('content')
    <div class="m-5">
        <div class="d-flex justify-content-between">
        </div>
        @include('backpanel.layouts.errors')
            
        <form action="{{ route('category.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group my-4">
                <label for="name">Category Name</label>
                <input 
                style="border:2px solid purple;padding:5px 5px"
                id="category_name" 
                name="category_name" 
                type="text"
                class="form-control"
                placeholder="Enter Category Name"
                />
            </div>
            
            <button class="btn btn-outline-success rounded btn" type="submit">Save Category</button>
            <a href="{{ route('category.index') }}" class="btn btn-outline-success btn">All Category</a>
        </form>
    </div>
@endsection