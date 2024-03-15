<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\PremissionRequest;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('backpanel.permission.index')->with('permissions', Permission::all());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backpanel.permission.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PremissionRequest $request)
    {
        $permission = new Permission();
        $permission->name = $request->name;
        $permission->save();
        
        $role = Role::findByName('Super_admin');
        $role->syncPermissions(Permission::all());
        
        return redirect()->route('permission.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

    }
    
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Permission $permission)
    {
        return view('backpanel.permission.edit')->with('permission',$permission);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PremissionRequest $request, Permission $permission)
    {
        $permission->update($request->all());
        return redirect()->route('permission.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Permission $permission)
    {
        $permission->delete();
        return redirect()->route('permission.index');
    }
}
