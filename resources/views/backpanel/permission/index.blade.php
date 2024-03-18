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
<div class="justify-content-between d-inline-block my-3">
    @can('Create Permission')
    <a href="{{route('permission.create')}}" class="btn btn-outline-success  btn">Create Permission</a>
    @endcan
</div>
<div class="d-inline-block my-3 justify-content-between">
    <button  class="btn btn-outline-success  create-action-btn">Create Action</button>
</div>
<table class="table table-hover text-center  table-bordered table-bordered table-striped  ">
    <thead class="table-dark">
    <tr>
        {{-- colspan="{{count(auth()->user()->roles[0]->permissions->groupBy('category_id'))}}" --}}
        <th  >Permissions</th>
        <th>Action</th>
    </tr>
    {{-- <tr>

        @foreach ($permissions->groupBy('category_id') as $categoryPermission)
            @foreach ($categoryPermission as $permission)
                {{($permission->name)}}
            @endforeach
        @endforeach
    </tr> --}}
</thead>

    @foreach ($permissions->groupBy('category_id') as $categoryPermission)
    
    
    <tbody  data-category={{$categoryPermission[0]->permissionCategory->id}}>
        <tr style="font-size:20px;"><td style="background:#5a5e61; color:white;"colspan="2">{{$categoryPermission[0]->permissionCategory->permission_category_name}}</td></tr>
            @forelse ($categoryPermission as $permission)
            <tr >
                <td>
                    {{explode(' ' ,$permission->name)[0]}}
                </td>
                <td>
                            @can('Update Permission')
                            {{-- href="{{ route('permission.edit',$permission->id) }}" --}}
                        <button  
                        class = "btn btn-warning btn-md rounded edit-btn"
                                id="{{$permission->id}}"
                                data-name="{{$permission->name}}"
                                data-action = "{{ route('permission.update', $permission->id)}}"
                                >Edit</button>
                                @endcan
                                {{-- @can('Delete Permission')
                                
                                <form class="d-inline" action="{{ route('permission.destroy',$permission->id) }}" method="POST">
                                    @csrf
                                    @method('delete')
                                    <button   button typr="submit" class = "btn btn-danger btn-md rounded">Delete</button>
                                </form>
                                @endcan --}}
                        </td>
                        
            </tr>
            @empty
            <tr>
                <td colspan='4'><h3 class='text-center'>Data Not Found !!</h3></td>
            </tr>
            @endforelse
        </tbody>
        @endforeach
</table>



{{-- Modal For Edit --}}
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
                            <input type="hidden" id='permissionid'>
                        </div>

                        <div class="form-group my-3">
                            <label for="permission_categories">Categories</label>
                            <select name="permission_category_id" id="permission_category_id" class='form-control' style="border:2px solid purple;padding:5px;">
                                <option value="AAA" hidden >--Select Role--</option>
                                @foreach ($permissions->groupBy('category_id') as $categoryPermission)
                                    <option data-name="{{$categoryPermission[0]->permissionCategory->permission_category_name}}" value="{{$categoryPermission[0]->permissionCategory->id}}">{{$categoryPermission[0]->permissionCategory->permission_category_name}}</option>
                                @endforeach
                            </select>
                        </div>

                            <div class="form-group my-4">
                                <input 
                                style="border:2px solid purple;padding:5px 5px"
                                id="permissionname" 
                                name="name" 
                                type="text"
                                class="form-control"
                                placeholder="Enter permission Name"
                                    />
                                </div>
                                
                                
                            </div>
                            
                            <!-- Modal footer -->
                            <div class="modal-footer">
                        <button class="btn btn-outline-success rounded update-btn" >Update permission</button>
                    <button type="button" class="btn btn-danger cls-btn">Close</button>
                    </div>
            
                </div>
                </div>
            </div>
{{-- Modal End --}}

{{-- Modal For Create Action --}}
<div class="modal" id="myModal2">
    <div class="modal-dialog">
    <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
        <h4 class="modal-title">Update Permission</h4>
        
        </div>

        <!-- Modal body -->
        <div class="modal-body">

                <div class="form-group my-4">
                    <label for="action_name">Action Name</label>
                    <input 
                    style="border:2px solid purple;padding:5px 5px"
                    id="action_name" 
                    name="action_name" 
                    type="text"
                    class="form-control"
                    placeholder="Enter Action Name"
                        />
                    </div>
                    
                    
                </div>
                
                <!-- Modal footer -->
                <div class="modal-footer">
            <button class="btn btn-outline-success rounded add-action-btn" data-action="{{route('action.store')}}">Add Action</button>
        <button type="button" class="btn btn-danger cls-btn">Close</button>
        </div>

    </div>
    </div>
</div>
{{-- Modal End For Create Action --}}
</div>
@endsection
@section('script')
<script>
(function($){
    $(document).ready(function(){
        // Ajax- Header
        $.ajaxSetup({
            headers:{
                'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
            }
        });
        let permissionId, permissionName, permissionAction
        $('.edit-btn').click(function(e){
            $('#myModal').show()
            categoryId = $(this).parent().parent().parent().data('category');
            permissionAction = $(this).data('action');
            permissionId = $(this).attr('id');
            permissionName = ($(this).data('name')).split(' ')[0];
            $('#permissionname').val(permissionName);
            $('#permission_category_id').val(categoryId);
            console.log($('#permission_category_id').val(categoryId));

            
        });
        $('.update-btn').click(function(e){
            let newPermissionName = $('#permissionname').val();
            let newPermissionCategoryId = $('#permission_category_id').val();
            let newPermissionCategoryName = $('option:selected').data('name');
            let patternForPermissionName = new RegExp('^[a-zA-Z0-9]+$');
            if(patternForPermissionName.test(newPermissionName)){

                $.ajax({
                    type: "PUT",
                    url: permissionAction,
                    data: {permissionName:newPermissionName, permissionId, newPermissionCategoryId, newPermissionCategoryName},
                    success: function (response) {
                        $('#permissionname').val('');
                        $('#myModal').hide()
                        location.reload();
                    }
                });
            }
            else{
                alert('There is something Wrong With Permission Name !!');
            }

            
        });
        $('.cls-btn').click(function(e){
            $('#permissionname').val('');
            $('#myModal').hide()
            $('#myModal2').hide()
        });
        $('.create-action-btn').click(function(e){
            $('#myModal2').show();
        });
        $('.add-action-btn').click(function(e){
            let actionName = $('#action_name').val();
            let url = $(this).data('action')
            console.log(url);
            let patternForAction= new RegExp('^[a-zA-Z0-9]+$');
            if(patternForAction.test(actionName)){
                $.ajax({
                    type: "POST",
                    url: url,
                    data: {action_name:actionName},
                    success: function (response) {
                        location.reload();
                    }
                });
            }
            
        })
    });
})(jQuery);
</script>
@endsection