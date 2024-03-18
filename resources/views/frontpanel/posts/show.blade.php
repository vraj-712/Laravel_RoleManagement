<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Backpanel</title>
    <!-- Latest compiled and minified CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Latest compiled JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <h3 class="bg-dark text-white p-3 d-flex justify-content-between align-items-center ">Blog Page 
        <div class="d-flex justify-content-end fs-5 align-items-end">
            <p > {{auth()->user()->roles[0]->name ?? 'Guest'}} : </p>
            <p class="text-secondary">&nbsp;{{(auth()->user()->name) ?? 'Guest'}}</p>
            {{-- <p><a class="btn btn-outline-success btn-sm mx-3" href="{{route('backpanel.index')}}">Dash Board</a></p> --}}
        </div>
    </h3>
    <div class="m-3">
        <a class="btn btn-outline-success btn-lg"href="/">All Posts</a>
    </div>
    <br>
<div class="m-3">
    <div class="container my-3">
        <div class="card">
            <div class="card-header">
                <h1>{{$post->title}}</h1>
            </div>
            <div class="card-body">
                <div class="card-img">
                    <img class="rounded mb-3"src="{{asset('images').'/'.$post->image}}"  style="object-fit:cover;box-shadow:0px 0px 10px 5px;" width="100%" height="550" alt="">
                </div>
                <p>{{$post->content}}</p>
            </div>
                
    </div>

    
    
    @can('Can-Comment')
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show m-5" role="alert">
            {{session('success')}}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
     <form action="{{route('comment.store')}}" method="POST" id='comment-form'>
        @csrf
        <input type="hidden" name="post_id" value="{{$post->id}}">
        <input type="hidden" name='parent_id' id='parent_id'>
        <input type="hidden" name="user_id" value="{{auth()->user()->id}}">
        <div class="form-group my-4">
            <label for="comment">Comment</label>
            <textarea 
            style="border:2px solid purple;padding:5px 5px"
                id="comment" 
                name="comment" 
                type="text"
                class="form-control"
                ></textarea>
        </div>
        <input type="submit" value="Comment" class="btn btn-primary">
    </form>
    @endcan
    <div class="container w-75 my-3">
        @foreach ($post->comments as $mainComment)
            @if (!$mainComment->parent_id)
                <div style="border:2px solid black;" class=" rounded p-3 my-2">
                    <p class="fs-5"> @ {{$mainComment->user->name}}&nbsp;<span style="font-size:12px;" class="text-secondary">{{$mainComment->created_at->diffForHumans()}}</span></p>
                    <p class="ms-5">{{$mainComment->comment}}</p>
                    @can('Can-Comment')
                    <a href='#comment-form' class='btn btn-info'onclick="document.getElementById('parent_id').value = {{$mainComment->id}}">Reply</a>
                    @endcan
                    
                    @foreach ($mainComment->subComments as $subComment)
                        <div style="border:2px solid black;" class="rounded my-1 w-75 ms-auto p-3">
                            <p class="fs-5"> @ {{$subComment->user->name}}&nbsp;<span style="font-size:12px;" class="text-secondary">{{$subComment->created_at->diffForHumans()}}</span></p>
                            <p class="ms-5">{{$subComment->comment}}</p>
                            
                        </div>
                    @endforeach
                </div>
            @endif
        @endforeach
    </div>
    
</div>
</div>
</body>
</html>