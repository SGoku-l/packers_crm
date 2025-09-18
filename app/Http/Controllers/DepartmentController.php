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
}
