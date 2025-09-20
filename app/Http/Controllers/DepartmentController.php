<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Menu;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function newDepartment(Request $request){

        $request->validate([
            'depname' => 'required|string|max:100',
            'depremark' => 'nullable|string|max:200'
        ]);

        $department =  Department::create([
            'department_name' => $request->depname,
            'remark' => $request->depremark,
            'view' => $request->has('depview')? 1 : 0,
            'edit' => $request->has('depedit')? 1 : 0,
            'delete' => $request->has('depdelete')? 1 : 0,
            'create' => $request->has('depcreate')? 1 : 0,
            'menu_access' => json_encode($request->accessmenu ?? []),
            'modified_by' => Auth()->id(),
            'modified_at' => now()
        ]);

         //This ensures the response contains user info
        $department->load('user');

        return response()->json([
            'status' => true,
            'message' => 'Department Created Successfully',
            'department' => $department
        ]);

    }

    public function getDepartment($id){

        $department = Department::with('user')->findOrFail($id);
        
       $menuAccess = is_string($department->menu_access) 
        ? json_decode($department->menu_access, true) 
        : ($department->menu_access ?? []);

         // ensure it's an array of integers
        $menuAccess = array_map('intval', $menuAccess);
        $department->menu_access = $menuAccess;

        $menu = Menu::select('id','menu','submenu')->get()->groupBy('menu');

        return response()->json([
        'status' => true,
        'message' => 'Department Fetched Successfully',
        'department' => $department,
        'menu' => $menu,
        'menuAccess' => $menuAccess

        ]);

    }

    public function updateDepartmnet(Request $request,$id){

        $request->validate([
            'depname' => 'required|string|max:100',
            'depremark' => 'nullable|string|max:200'
        ]);

        $department = Department::findOrFail($id);

        $department->update([
            'department_name' => $request->depname,
            'remark' => $request->depremark,
            'view' => $request->has('depview')? 1 : 0,
            'edit' => $request->has('depedit')? 1 : 0,
            'delete' => $request->has('depdelete')? 1 : 0,
            'create' => $request->has('depcreate')? 1 : 0,
            'menu_access' => json_encode($request->accessmenu ?? []),
            'modified_by' => Auth()->id(),
            'modified_at' => now()
        ]);

         //This ensures the response contains user info
        $department->load('user');

        return response()->json([
            'status' => true,
            'message' => 'Department Updated Successfully',
            'department' => $department
        ]);

    }

    public function destroy($id){

        $department = Department::findOrFail($id);
        $department->delete();

        return response()->json([
            'status' => true,
            'message' => 'Department Row Deleted Successfully'
        ]);

    }

}
