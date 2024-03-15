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
    
    @can('Create-Role')
    <a href="{{route('role.create')}}" class="btn btn-outline-success  btn">Create Role</a>
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
        @if (auth()->user()->checkForAssignPermission($role) && auth()->user()->hasPermissionTo('Assign-Permission'))
        <tr>
                <td>{{$role->name}}</td>
                @foreach (auth()->user()->roles[0]->permissions->groupBy('category_id') as $categorypermission)
                {{-- {{($categorypermission[0]->permissionCategory)}} --}}
                <td class="" id="role-{{$role->id}}" action='{{route('role.assign.permission',$role->id)}}'>
                    {{-- {{$categorypermission->category_permission_name}} --}}
                        @foreach ($categorypermission as $permission)            
                                                        
                            <div class="d-flex justify-content-between" >
                                <label for="{{$permission->id.'-'.$role->id}}">{{$permission->name}}</label>
                                <input 
                                type="checkbox" 
                                name="permission[]" 
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
                    @can('Delete-Role')
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
            $("input").change(function(){
                
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
                        if(response != 1){
                            console.log('Permission Can Not Updated');
                        }
                        else{
                            console.log('Permission Updated Succesfully');
                        }
                    }
                });
                
            });
        });
    })(jQuery);
</script>





































































@endsection

