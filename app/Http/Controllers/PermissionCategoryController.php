<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\PermissionCategory;
use Illuminate\Http\Request;

class PermissionCategoryController extends Controller
{
    public function index(){
        return view('backpanel.categories.index')->with('categories',PermissionCategory::all());
    }
    public function create(){
        return view('backpanel.categories.create');
    }
    public function store(Request $request){
        PermissionCategory::create([
            'permission_category_name' =>ucfirst ( $request->categoryName),
        ]);
        return redirect()->route('category.index')->with('success','Category Created SuccessFully ');
    }

}
