@extends('backpanel.index')
@section('content')
    <div class="m-5">
        <div class="d-flex justify-content-between">
        </div>
        @include('backpanel.layouts.errors')
        @can('Create Permission')
            <div class="my-2 d-flex justify-content-between">
                <a href="{{route('category.create')}}" class="btn btn-outline-success  btn">Create Category For Permission</a>
            </div>
            <div class="form-group my-3">
                <label for="permission_categories">Categories</label>
                <select name="permission_category_id" id="permission_category_id" class='form-control' style="border:2px solid purple;padding:5px;">
                    <option value="" hidden >--Select Role--</option>
                    @foreach ($permission_categories as $permission_category)
                        <option data-name="{{$permission_category->permission_category_name}}" value="{{$permission_category->id}}">{{$permission_category->permission_category_name}}</option>
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
            
            <button class="btn btn-outline-success rounded create-btn" data-action="{{route('permission.store')}}">Save permission</button>
            <a href="{{ route('permission.index') }}" class="btn btn-outline-success btn">All permissions</a>
        @endcan
        @cannot('Create Permission')
        <h1 class="text-center text-danger">Sorry!! You cant Create permission</h1>
        @endcannot
    </div>
@endsection

@section('script')
<script>
        (function($){
            $(document).ready(function () {
                // Ajax start
                $.ajaxSetup({
            headers:{
                'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
            }});
            // Ajax End
            $('.create-btn').click(function (e) { 
                e.preventDefault();
                let permissionName = $('#name').val()
                let permissionCategoryId = $('#permission_category_id').val();
                let permissionCategoryName = $('option:selected').data('name');
                let url = $(this).data('action');
                console.log(url);
                let patternForPermissionName = new RegExp('^[a-zA-Z0-9]+$');
                if(patternForPermissionName.test(permissionCategoryName)){
                    $.ajax({
                        type: "POST",
                        url: url,
                        data: {permissionName, permissionCategoryId, permissionCategoryName},
                        success: function (response) {
                            location.reload();
                            
                        }
                    });
                }
                else{
                    alert('There Is Something Wrong With Permission Name !!');
                }
                
            });


            });
        })(jQuery);
</script>
@endsection