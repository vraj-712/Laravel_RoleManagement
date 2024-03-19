<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\PermissionCategory;
use Exception;
use Illuminate\Http\Request;

class PermissionCategoryController extends Controller
{
    // public function index(){
    //     return view('backpanel.categories.index')->with('categories',PermissionCategory::all());
    // }
    // public function create(){
    //     return view('backpanel.categories.create');
    // }
    public function store(Request $request){
        try{

            PermissionCategory::create([
                'permission_category_name' =>ucfirst ( $request->categoryName),
            ]);
            return true;
        }catch (Exception $e) {
            return $e->getMessage();
        }
        // return redirect()->route('category.index')->with('success','Category Created SuccessFully ');
    }

}
