@extends('backpanel.index')
@section('content')
<div class="m-5">
    @if (session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{session('success')}}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
@endif
@include('backpanel.layouts.errors')

<h2>All permissions</h2>
<div class="d-flex justify-content-between">
    <a href="{{route('category.create')}}" class="btn btn-outline-success  btn">Create Category For Permission</a>
</div>
<table class="table table-hover text-center  table-bordered table-bordered table-striped">
    <thead class="table-dark">
    <tr>
        <th>Category Name</th>
    </tr>
    </thead>
        @forelse ($categories as $category)
            <tr>
            <td>{{$category->permission_category_name}}</td>
            </tr>
        @empty
            <tr>
                <td colspan='4'><h3 class='text-center'>Data Not Found !!</h3></td>
            </tr>
        @endforelse
</table>

</div>
@endsection