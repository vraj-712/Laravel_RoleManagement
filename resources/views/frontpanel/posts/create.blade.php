@extends('frontpanel.index')

@section('content')
<div class="m-3">
<div class="d-flex justify-content-between">
    <a href="{{ route('post.index') }}" class="btn btn-primary btn-lg">All Posts</a>
</div>
@include('backpanel.layouts.errors')
@can('Create Post')
<form action="{{ route('post.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="form-group my-4">
        <label for="title">Title</label>
        <input 
        style="border:2px solid purple;padding:5px 5px"
            id="title" 
            name="title" 
            type="text"
            class="form-control"
            placeholder="Enter title Name"
            />
    </div>
    <div class="form-group my-4">
        <label for="content">Content</label>
        <textarea name="content" id="content" cols="300" rows="10"   style="border:2px solid purple;padding:5px 5px" placeholder="Enter content Here" class="form-control"></textarea>
    </div>
    <div class="form-group my-4">
        <label for="image">Thumbnail</label>
        <input 
        style="border:2px solid purple;padding:5px 5px"
            id="image" 
            name="image" 
            type="file"
            class="form-control"
            />
        </div>
        <button class="btn btn-success rounded btn-lg" type="submit">Save Post</button>
    </form>
@endcan
    @cannot('Create Post')
    <h1 class="text-center text-danger">Sorry!! You cant Create Post</h1>
@endcannot
</div>
@endsection

