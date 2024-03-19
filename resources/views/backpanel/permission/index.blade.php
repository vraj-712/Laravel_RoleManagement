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
<table class="table table-group-divider table-bordered  table-striped  " style="border: 2px solid black;">
    <thead>
      <tr style="border-bottom: 2px solid black">
        
        <th class="text-dark" style="background: linear-gradient(to right top, #fff 0%, #fff 49.9%, #212529 50%, #212529 51%, #fff 51.1%, #fff 100%);" rowspan="2">
            <p class="m-0 p-0 text-end">Category</p>
            <p class="m-0 p-0 text-start">Action</p>
        </th>
        @foreach ($categoryPermissions as $categoryPermission)
        <th class="text-center text-bg-white" style="vertical-align:baseline;">{{$categoryPermission->permission_category_name}}</th>
        @endforeach
      </tr>
    </thead>
    <tbody>
        
      @foreach ($permissionsAction as $action)
          <tr data-action_id="{{$action->id}}">
            <td class="text-bg-white">{{$action->action_name  }}</td>
            @foreach ($categoryPermissions as $categoryPermission)
            <td data-category_id="{{$categoryPermission->id}}">
                
                <div class="d-flex justify-content-center" >
                    {{-- <label for="">{{$action->action_name.' '.$categoryPermission->permission_category_name}}</label> --}}
                    {{-- <label for="{{$permission->id.'-'.$role->id}}">{{$permission->name}}</label> --}}
                    <input 
                    type="checkbox" 
                    name="permission[]" 
                    id=""
                    class="form-check-input border-black "
                    value="{{$action->action_name.' '.$categoryPermission->permission_category_name}}" 
                    @foreach ($permissions as $singlePermission)
                        @if ($singlePermission->category_id === $categoryPermission->id && $singlePermission->action_id === $action->id)
                            checked
                            data-permissionid={{$singlePermission->id}}
                        @endif
                    @endforeach
                    />
                </div>
            </td>
            @endforeach
          </tr>
      @endforeach
    </tbody>
  </table>
{{-- td {
    border: 1pt solid black;
}

td.diagonalRising {
    background: linear-gradient(to right bottom, #ffffff 0%, #ffffff 49.9%, #000000 50%, #000000 51%, #ffffff 51.1%, #ffffff 100%);
}

td.diagonalFalling {
    background: linear-gradient(to right top, #ffffff 0%, #ffffff 49.9%, #000000 50%, #000000 51%, #ffffff 51.1%, #ffffff 100%);
}

td.diagonalCross {
    position: relative;
    background: linear-gradient(to right bottom, rgba(0, 0, 0, 0) 0%, rgba(0, 0, 0, 0) 49.9%, rgba(0, 0, 0, 1) 50%, rgba(0, 0, 0, 1) 51%, rgba(0, 0, 0, 0) 51.1%, rgba(0, 0, 0, 0) 100%);
}

td.diagonalCross:after {
    content: "";
    display: block;
    position: absolute;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    z-index: -1;
    background: linear-gradient(to right top, #ffffff 0%, #ffffff 49.9%, #000000 50%, #000000 51%, #ffffff 51.1%, #ffffff 100%);
}
 --}}

{{-- Modal For Edit --}}
            {{-- <div class="modal" id="myModal">
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
            </div> --}}
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
                ajaxRequest("PUT", permissionAction, {permissionName:newPermissionName, permissionId, newPermissionCategoryId, newPermissionCategoryName});
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
                ajaxRequest("POST", url, {action_name:actionName});
            }
            
        })

        function ajaxRequest(type, url, data){
            $.ajax({
                    type: type,
                    url: url,
                    data: data,
                    success: function (response) {
                        console.log(response)
                    }
                });
        }

        $('input[type=checkbox]').change(function(e){
                let isChecked = $(this).is(':checked');
                console.log(isChecked);
                let categoryId = $(this).parent().parent().data('category_id');
                let actionId = $(this).parent().parent().parent().data('action_id');
                let permissionName = $(this).val();
                let permissionId = $(this).data('permissionid') ?? null;
                let route = "{{ route('permission.destroy', ':id')}}";
                let url = route.replace(':id', permissionName);

                console.log('Delete Url '+url);
                console.log('PermissionId '+permissionId);
                console.log('PermissionName '+permissionName)
                console.log('ActionId '+actionId)
                console.log('CategoryId'+categoryId)
                console.log('Store Url '+"{{route('permission.store')}}")
                if(isChecked){
                    ajaxRequest("POST", "{{route('permission.store')}}", {permissionName, permissionCategoryId:categoryId, permissionActionId:actionId})
                }else{
                    console.log("In Delete")
                    ajaxRequest("DELETE", url, {permissionName});
                }
        })
    });
})(jQuery);
</script>
@endsection