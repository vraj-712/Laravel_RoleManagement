<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(){
        
        return view('backpanel.users.index')->with('users',User::all());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(){
        try {
            $roles = Role::all();
            return view('backpanel.users.create',compact('roles'));
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request){
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
    
            ]);
            $user->assignRole($request->role_name);
            return redirect()->route('user.index')->with('success','User Created Successfullly');
        }catch (Exception $e) {
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
    public function edit(User $user){
        $roles = Role::all();
        return view('backpanel.users.edit',compact('user'))->with('roles',$roles);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, User $user){
        try {
            $user->update([
                'name' => $request->name,
            ]);
            $user->save();
            $user->syncRoles([$request->role_name]);
            return redirect()->route('user.index')->with('success','User Updated Successfullly');
        } catch (Exception $e) {
            return $e->getMessage();
        }
        
    }
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user){
        try {
            $user->delete();
            return redirect()->route('user.index')->with('success','User Deleted Successfullly');
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
