<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ActionPermission;
use Exception;
use Illuminate\Http\Request;

class ActionPermissionController extends Controller
{
    public function store(Request $request){
        try{

            ActionPermission::create([
                'action_name' => ucfirst(strtolower($request->action_name)),
            ]);
            return true;
        }catch (Exception $e) {
            return $e->getMessage();
        }

    }
}
