@extends('backpanel.index')
@section('content')
    <div class="m-5">
        <div class="d-flex justify-content-between">
        </div>
        @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{session('success')}}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
        @include('backpanel.layouts.errors')
        <h1 class="text-center">Assing Pemission To Role: {{$role->name}}</h1>
        @can('Assign-Permission')
        <form action="{{route('role.store.permission',$role->id)}}" method="POST">
            @csrf
            <div class="form-group">
                <table class="table table-hover text-center ">
                    <thead class="table-dark">
                        <tr>
                            <td>Permission Name</td>
                            <td>Add/Remove</td>
                        </tr>
                    </thead>
                    @forelse ($permissions as $permission)
                    <tr>
                        <td class="text-center"><label for="{{$permission->id}}">{{$permission->name}}</label>
                        </td>
                        <td>
                            <input 
                            type="checkbox" 
                            name="permission[]" 
                            id="{{$permission->id}}" 
                            value="{{$permission->name}}" 
                            @if ($role->hasPermissionTo($permission->id))
                            checked
                            @endif/>
                                </td>
                            </tr>
                            @empty
                            <p>No Permission Are Created</p>
                            @endforelse    
                        </table>
                </div>
                <button type="submit"
                class="btn btn-outline-success"
                >Save Permission</button>
                <a href="{{ route('role.index') }}" class="btn btn-outline-success">All Roles</a>
            </form>
            @endcan
            @cannot('Assign-Permission')
                <h1 class="text-center text-danger">Sorry!! You cant assign permission</h1>
            @endcannot
                    

    </div>
    @endsection