<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\RoleRequest;
use Exception;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(){
        return view('backpanel.role.index')->with('roles', Role::where('name', '!=', 'Super_admin')->get());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request){
        return view('backpanel.role.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RoleRequest $request){
        try {
            $role = new Role();
            $role->name = ucfirst(strtolower($request->name));
            $role->save();
            return true;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id){
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role){
        return view('backpanel.role.edit')->with('role',$role);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RoleRequest $request, Role $role){
        try {
            $role->update($request->all());
            return redirect()->route('role.index')->with('success','Role Updated Successfullly');
        } catch (Exception $e) {
            return $e->getMessage();
        }
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role){
        try {
            $role->delete();
            return redirect()->route('role.index')->with('success','Role Deleted Successfullly');
        }  catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // public function assignPermissionView(Role $role){
    //     try {
    //         $permissions = auth()->user()->roles[0]->permissions;
    //     return view('backpanel.role.assignPermission',compact(['role', 'permissions']));
    //     } catch (Exception $e) {
    //         return $e->getMessage();
    //     }
        
    // }
    public function assignPermission(Role $role,Request $request){
        try {
            if($role->hasAnyPermission($request->permission)){
                $role->revokePermissionTo($request->permission);
            }
            else{

                $role->givePermissionTo($request->permission);
            }
            return true;
            
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
