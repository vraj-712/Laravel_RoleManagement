<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\PremissionRequest;
use App\Models\ActionPermission;
use App\Models\PermissionCategory;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(){
        $categoryPermissions = PermissionCategory::all();
        $permissions = Permission::all();
        $permissionsAction = ActionPermission::all();

        return view('backpanel.permission.index',compact(['categoryPermissions', 'permissions', 'permissionsAction']));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(){
        return view('backpanel.permission.create')->with('permission_categories', PermissionCategory::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PremissionRequest $request){

        $permission = new Permission();
        $permission->name = $request->permissionName;
        $permission->category_id = $request->permissionCategoryId;
        $permission->action_id = $request->permissionActionId;
        $permission->save();

        
        $role = Role::findByName('Super_admin');
        $role->syncPermissions(Permission::all());
        
    }
    
    /**
     * Display the specified resource.
     */
    public function show(string $id){
        
    }
    
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Permission $permission){
        return view('backpanel.permission.edit')->with('permission',$permission);
    }
    
    /**
     * Update the specified resource in storage.
     */
    public function update(PremissionRequest $request, Permission $permission){
        $permission->update([
            'name' => $request->permissionName .' '. $request->newPermissionCategoryName,
            'category_id' => $request->newPermissionCategoryId
        ]);
       
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request){
        $permission = Permission::findByName($request->permissionName);
    //    return  $permission;
        $permission->delete();

    }
}
