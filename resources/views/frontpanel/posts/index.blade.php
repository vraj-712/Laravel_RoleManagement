@extends('frontpanel.index')

@section('content')
<div class="m-5">
@if (session('success'))
<div class="m-3">
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{session('success')}}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
@endif
<div class="d-flex justify-content-between">
    <a href="{{route('post.create')}}" class="btn btn-primary btn-lg">Create post</a>
</div>
<h2>All post</h2>
<table class="table table-hover table-bordered table-bordered table-striped">
    <tr>
        <th>Title</th>
        <th>Excerpt</th>
        <th>Action</th>
    </tr>
        @forelse ($posts as $post)
            <tr>
            <td>{{$post->title}}</td>
            <td>{{substr($post->content,0 , 30)}}....</td>
            <td>
                @can('Update Post')
                @if (auth()->user()->UpdateAndDeletePost($post))
                <a href="{{ route('post.edit',$post->id) }}" class = "btn btn-info btn-md rounded">Edit</a> 
                @endif
                @endcan
                @can('Delete Post')
                @if (auth()->user()->UpdateAndDeletePost($post))
                <form action="{{ route('post.destroy',$post->id) }}" method="POST" class="d-inline">
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
                <td colspan='4'><h3 class='text-center'>Posts Not Found !!</h3></td>
            </tr>
        @endforelse
</table>
</div>
</div>
@endsection