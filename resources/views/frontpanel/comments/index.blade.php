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
<h2>All Comments</h2>
<table class="table table-hover table-bordered table-bordered table-striped">
    <tr>
        <th>Post Title</th>
        <th>Comment Content</th>
        <th>Comment Author Name</th>
        <th>Status</th>
        <th>Action</th>
    </tr>
        @forelse ($comments as $comment)
            <tr>
            <td>{{$comment->post->title}}</td>
            <td>{{$comment->comment}}</td>
            <td>{{$comment->user->name}}</td>
            <td>
                @if(!$comment->status)
                    <span class="text-danger fw-bold">Not Approved</span>
                @else
                    <span class="text-success fw-bold">Approved</span>
                @endif
            </td>
            <td>
                @can('Check-Comment')
                    <form action="{{route('approve-comment',$comment->id)}}" method="POST" class='d-inline'>
                        @csrf
                        @if(!$comment->status)
                            <button type="submit" class="btn btn-warning" >Approve</button>
                        @else
                            <button type="submit" class="btn btn-warning" >Disapprove</button>
                        @endif
                    </form>
                @endcan
                @can('Delete-Comment')
                    @if (auth()->user()->deleteCommentPermission($comment))
                        <form action="{{route('comment.destroy', $comment->id)}}" method="POST" class='d-inline'> 
                            @csrf
                            @method('delete')
                            <button type="submit" class='btn btn-danger'>Delete</button>
                        </form>
                    @endif
                @endcan
            </td>
            
            </tr>
        @empty
            <tr>
                <td colspan='4'><h3 class='text-center'>There Are No Comments On Any Post </h3></td>
            </tr>
        @endforelse
</table>
</div>
</div>
@endsection