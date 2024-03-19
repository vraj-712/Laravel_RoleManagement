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
    <a href="{{route('category.create')}}" class="btn btn-outline-success  create-btn">Create Category For Permission</a>
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
{{-- Modal --}}
<div class="modal" id="myModal">
    <div class="modal-dialog">
    <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
        <h4 class="modal-title">Update Permission</h4>
        
        </div>

        <!-- Modal body -->
        <div class="modal-body">
                <div class="form-group my-4">
                    <label for="name">Category Name</label>
                    <input 
                    style="border:2px solid purple;padding:5px 5px"
                    id="category_name" 
                    name="category_name" 
                    type="text"
                    class="form-control"
                    placeholder="Enter Category Name"
                    data-action = "{{ route('category.store') }}"
                    />
                </div>
                
                
                
            </div>   
                <!-- Modal footer -->
                <div class="modal-footer">
            <button class="btn btn-outline-success rounded add-btn" data-action = "{{ route('category.store') }}" >Add Category</button>
        <button type="button" class="btn btn-danger cls-btn">Close</button>
        </div>

    </div>
    </div>
</div>
{{-- Modal End --}}
</div>
@endsection
@section('script')
<script>
(function($){
    $(document).ready(function () {
        // Ajax Header
        $.ajaxSetup({
            headers:{
                'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
            }
        });
        // Ajax Header End

        $('.create-btn').click(function (e) { 
            e.preventDefault();
            $('#myModal').show();
            
        });
        
        $('.cls-btn').click(function (e) { 
            e.preventDefault();
            $('#myModal').hide();
            
        });

        $('.add-btn').click(function (e) { 
            e.preventDefault();
            let categoryName = $('#category_name').val()
            let url = $(this).data('action')
            $.ajax({
                type: "POST",
                url: url,
                data: {categoryName},
                success: function (response) {
                    location.reload();
                }
            });
            
        });
    });
})(jQuery);
</script>
@endsection