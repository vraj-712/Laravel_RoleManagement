@extends('backpanel.index')
@section('content')
    <div class="m-5">
        <div class="d-flex justify-content-between">
        </div>
        @include('backpanel.layouts.errors')
        @can('Update-Permission')
            
        <form action="{{ route('permission.update', $permission->id)}}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group my-4">
                <label for="name">Update permission</label>
                <input 
                style="border:2px solid purple;padding:5px 5px"
                id="name" 
                name="name" 
                type="text"
                class="form-control"
                placeholder="Enter permission Name"
                    value="{{$permission->name}}" 
                    />
                </div>
                
                
                <button class="btn btn-outline-success rounded btn" type="submit">Update permission</button>
                <a href="{{ route('permission.index') }}" class="btn btn-outline-success btn">All permissions</a>
            </form>
        @endcan
        @cannot('Update-Permission')
                <h1 class="text-center text-danger">Sorry!! You cant Update permission</h1>
        @endcannot
    </div>
@endsection