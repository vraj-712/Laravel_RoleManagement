<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ActionPermission;
use Illuminate\Http\Request;

class ActionPermissionController extends Controller
{
    public function store(Request $request){
        ActionPermission::create([
            'action_name' => ucfirst(strtolower($request->action_name)),
        ]);
        return true;

    }
}
