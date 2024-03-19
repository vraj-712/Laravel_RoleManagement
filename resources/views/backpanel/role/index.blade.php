@extends('backpanel.index')
@section('content')
<div class="m-2">
    @if (session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{session('success')}}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
@endif

@include('backpanel.layouts.errors')
<h2>All Roles</h2>
<div class="d-flex justify-content-between">
    
    @can('Create Role')
    <a href="{{route('role.create')}}" class="btn btn-outline-success  create-role-btn">Create Role</a>
    @endcan
</div>
<table class="table table-hover text-center  table-bordered table-bordered table-striped">
    <thead class="table-dark">
    <tr>
        <th rowspan="2">Role Name</th>
        <th colspan="{{count(auth()->user()->roles[0]->permissions->groupBy('category_id'))}}">Permission</th>
        <th rowspan="2">Action</th>
    </tr>
    <tr>
        @foreach (auth()->user()->roles[0]->permissions->groupBy('category_id') as $categorypermission)
        <th>{{$categorypermission[0]->permissionCategory->permission_category_name}}</th>
        @endforeach
    </tr>
</thead>
        @forelse ($roles as $role)
        {{-- && auth()->user()->hasPermissionTo(['Assign Permission'] --}}
        @if (auth()->user()->checkForAssignPermission($role) )
        <tr>
                <td>{{$role->name}}</td>
                @foreach (auth()->user()->roles[0]->permissions->groupBy('category_id') as $categorypermission)
                {{-- {{($categorypermission[0]->permissionCategory)}} --}}
                <td class="" id="role-{{$role->id}}" action='{{route('role.assign.permission',$role->id)}}'>
                    {{-- {{$categorypermission->category_permission_name}} --}}
                        @foreach ($categorypermission as $permission)            
                                                        
                            <div class="d-flex justify-content-between " >
                                <label for="{{$permission->id.'-'.$role->id}}">{{explode(' ', $permission->name)[0]}}</label>
                                {{-- <label for="{{$permission->id.'-'.$role->id}}">{{$permission->name}}</label> --}}
                                <input 
                                type="checkbox" 
                                name="permission[]" 
                                class="form-check-input border-black form-check-inline form"
                                id="{{$permission->id.'-'.$role->id}}" 
                                value="{{$permission->name}}" 
                                @if ($role->hasPermissionTo($permission->id))
                                checked
                                @endif
                                />
                            </div>
                        @endforeach
                </td>
                                
                @endforeach
                <td>
                    @can('Delete Role')
                    <form class="d-inline" action="{{route('role.destroy',$role->id)}}" method="POST">
                        @csrf
                        @method('delete')
                        <button typr="submit" class = "btn btn-danger btn-md rounded">Delete</button>
                    </form>
                    @endcan
                </td>
        </tr>
        @endif
        @empty
            <tr>
                <td colspan='4'><h3 class='text-center'>Data Not Found !!</h3></td>
            </tr>
        @endforelse
</table>
{{-- Modal For Role --}}
<div class="modal" id="myModal">
    <div class="modal-dialog">
    <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
        <h4 class="modal-title">Create Role</h4>
        
        </div>

        <!-- Modal body -->
        <div class="modal-body">
                <div class="form-group my-4">
                    <label for="name">Role Name</label>
                    <input 
                    style="border:2px solid purple;padding:5px 5px"
                    id="name" 
                    name="name" 
                    type="text"
                    class="form-control"
                    placeholder="Enter Role Name"
                    data-action = "{{ route('role.store') }}"
                    />
                </div>
                
                
                
            </div>   
                <!-- Modal footer -->
                <div class="modal-footer">
            <button class="btn btn-outline-success rounded add-btn" data-action = "{{ route('role.store') }}" >Add Role</button>
        <button type="button" class="btn btn-danger cls-btn">Close</button>
        </div>

    </div>
    </div>
</div>
{{-- Modal For Role --}}
</div>
@endsection
@section('script')
<script>
    (function($){
        $(document).ready(function () {
            $.ajaxSetup({
            headers:{
                'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
            }
        });

        $("input[type=checkbox]").change(function(){
                
                // console.log($('[name="permission[]"]:checked')) ---> Give All Checked Element Which Have name=permission[]
                console.log($(this)[0].value) //---> this give Check Box Id  
                console.log($(this).parent().parent().attr('id') + ' Parent Div Id')// --> this give parent id which have id like 'role-*'

                let parent_id = $(this).parent().parent().attr('id')
                

                // console.log($('#' + parent_id).children().children('input[name="permission[]"]:checked')) ---> All Checked Element Of that Parent in array form of html element

            //    let input_array = $('#' + parent_id).children().children('input[name="permission[]"]:checked')
               let permission = [];

            //    for(let i = 0; i < input_array.length; i++) {
            //         let a = input_array[i];
                    permission.push($(this)[0].value);
                    console.log(permission)
                // }
               let role_id = parent_id.replace('role-','')
               let url = $(this).parent().parent().attr('action')
                $.ajax({
                    type: "POST",
                    url: url,
                    data: {role_id,permission},
                    success: function (response) {
                        if(response == true){
                            console.log("Permission Assign SuccessFully")
                        }else{
                            alert("There Is Some Problem While Assigning Permission !!");
                        }
                    }
                });
                
            });
        });

        $('.create-role-btn').click(function (e) { 
            e.preventDefault();
            $('#myModal').show();
            
        });
        
        $('.cls-btn').click(function (e) { 
            e.preventDefault();
            $('#myModal').hide();
            
        });

        $('.add-btn').click(function (e) { 
            e.preventDefault();
            let roleName = $('#name').val()
            let url = $(this).data('action')
            console.log(roleName + '==' + url)
            $.ajax({
                type: "POST",
                url: url,
                data: {name:roleName},
                success: function (response) {
                    if(response == true){
                        location.reload();
                    }else{
                        alert("There Is Some Problem While Adding Role !!")
                    }
                }
            });
            
        });
    })(jQuery);
</script>
@endsection

