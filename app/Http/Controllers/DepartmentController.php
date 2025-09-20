<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Menu;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
            'modified_by' => Auth::id(),
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
     public function newAdmin(Request $request){

        $request->validate([
            'adminName' => 'required|string|max:100',
            'adminEmail' => 'required|email|unique:users,email',
            'adminPhone' => 'required|numeric|unique:users,phone',
            'adminPassword' => 'required|min:6',
            'adminconformPassword' => 'required|min:6|same:adminPassword',
            'adminRole'=>'nullable'
        ]);

        $admin =  User::create([
            'name' => $request->adminName,
            'email' => $request->adminEmail,
            'phone' => $request->adminPhone,
            'password'=>bcrypt($request->adminPassword),
            'role_id'=> $request->adminRole,
            'modified_by' => Auth()->id(),
            'modified_at' => now()
        ]);

        $admin->load(['role', 'modifiedByUser']);
        
        return response()->json([
            'status' => true,
            'message' => 'Admin Created Successfully',
            'admin' => $admin
        ]);

    }

    public function getAdmin($id){

       $admin = User::findOrFail($id); 

        return response()->json([
        'status' => true,
        'message' => 'Admin Fetched Successfully',
        'admin' => $admin

        ]);

    }

    public function updateAdmin(Request $request,$id){

        $request->validate([
            'adminName' => 'required|string|max:100',
            'adminEmail' => 'required|email|unique:users,email,' .$id,
            'adminPhone' => 'required|numeric|unique:users,phone',
            'adminPassword' => 'min:6',
            'adminconformPassword' => 'min:6|same:adminPassword',
            'adminRole'=>'nullable'
        ]);

        $admin = User::findOrFail($id);

        $admin->update([
            'name' => $request->adminName,
            'email' => $request->adminEmail,
            'phone' => $request->adminPhone,
            'password'=>bcrypt($request->adminPassword),
            'role_id'=> $request->adminRole,
            'modified_by' => Auth::id(),
            'modified_at' => now()
        ]);

        $admin->load(['role', 'modifiedByUser']);

        return response()->json([
            'status' => true,
            'message' => 'Admin Updated Successfully',
            'admin' => $admin
        ]);

    }

    public function destroyAdmin($id){

        $admin = User::findOrFail($id);
        $admin->delete();

        return response()->json([
            'status' => true,
            'message' => 'Admin Row Deleted Successfully'
        ]);

    }

    public function adminalll(){

        $admin = User::with('role','modifiedByUser')->get();
        $department = Department::all();

        return response()->json([
            'status' => true,
            'message' => 'Admin All Data Fetch Successfully',
            'admin' => $admin,
            'department' => $department
        ]);

    }

}
