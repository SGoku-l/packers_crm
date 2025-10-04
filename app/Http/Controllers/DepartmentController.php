<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Menu;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Role;

class DepartmentController extends Controller
{
   public function __construct() {
        // Departments
        $this->middleware('permission:dep.view')->only(['getDepartment','adminalll']);
        $this->middleware('permission:dep.create')->only(['newDepartment']);
        $this->middleware('permission:dep.edit')->only(['updateDepartmnet']);
        $this->middleware('permission:dep.delete')->only(['destroy']);

        // Admins
        $this->middleware('permission:admin.view')->only(['getAdmin']);
        $this->middleware('permission:admin.create')->only(['newAdmin']);
        $this->middleware('permission:admin.edit')->only(['updateAdmin']);
        $this->middleware('permission:admin.delete')->only(['destroyAdmin']);
    }

    public function newDepartment(Request $request){

        $request->validate([
            'depname' => 'required|string|max:100',
            'depremark' => 'nullable|string|max:200'
        ]);

        $role = Role::create([
            'name' => $request->depname,
        ]);

        $selectedPermissions = $request->accessmenu ?? [];
        $permission = Permission::whereIn('id',$selectedPermissions)->get();
        $role->syncPermissions($permission);

        $department =  Department::create([
            'department_name' => $request->depname,
            'remark' => $request->depremark,
            'view' => $request->has('depview')? 1 : 0,
            'edit' => $request->has('depedit')? 1 : 0,
            'delete' => $request->has('depdelete')? 1 : 0,
            'create' => $request->has('depcreate')? 1 : 0,
            'menu_access' => json_encode($selectedPermissions),
            'role_id' => $role->id,
            'modified_by' => Auth::id(),
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

       $department->canEdit = Auth::user()->can('edit');
       $department->canDelete = Auth::user()->can('delete');

        $rawMenuAccess = $department->menu_access;

       if (is_string($rawMenuAccess)) {
            $menuAccess = json_decode($rawMenuAccess, true) ?? [];
        } elseif (is_array($rawMenuAccess)) {
            $menuAccess = $rawMenuAccess;
        } else {
            $menuAccess = [];
        }

         // ensure it's an array of integers
        $menuAccess = array_map('intval', $menuAccess);
        $department->menu_access = $menuAccess;
        $department->canEdit   = Auth::user()->can('dep.edit');
        $department->canDelete = Auth::user()->can('dep.delete');
        $department->canView   = Auth::user()->can('dep.view');
        $department->canCreate = Auth::user()->can('dep.create');

        $menu = Permission::all()->groupBy(function ($perm) {
            return explode('.', $perm->name)[0];
        });

         //This ensures the response contains user info
        $department->load('user');

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

        $menuAccess = is_array($department->menu_access) 
            ? $department->menu_access 
            : json_decode($department->menu_access, true);

        $department->canView   = in_array(1, $menuAccess);
        $department->canEdit   = in_array(2, $menuAccess);
        $department->canDelete = in_array(3, $menuAccess);
        $department->canCreate = in_array(4, $menuAccess);

         //This ensures the response contains user info
        $department->load('user');

        if ($department->role_id) {
            $role = Role::find($department->role_id);
            if ($role) {
                $role->name = $request->depname;
                $role->save();
                $selectedPermissions = $request->accessmenu ?? [];
                $permissions = Permission::whereIn('id', $selectedPermissions)->get();

                $role->syncPermissions($permissions);
            }
        }

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

        $findrole = Department::find($request->adminRole);

        $admin =  User::create([
            'name' => $request->adminName,
            'email' => $request->adminEmail,
            'phone' => $request->adminPhone,
            'password'=> bcrypt($request->adminPassword),
            'role_id'=>  $findrole->role_id,
            'modified_by' => Auth::id(),
            'modified_at' => now()
        ]);

        $admin->load(['role', 'modifiedByUser']);

        

        if($findrole){
            $role = Role::find($findrole->role_id);
            if($role){
                $admin->syncRoles([$role->name]);
            }
        }

        return response()->json([
            'status' => true,
            'message' => 'Admin Created Successfully',
            'admin' => $admin
        ]);

    }

    public function getAdmin($id){

       $admin = User::findOrFail($id);
       $role = Department::all(); 

        return response()->json([
        'status' => true,
        'message' => 'Admin Fetched Successfully',
        'admin' => $admin,
        'role' => $role
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

        $findrole = Department::find($request->adminRole);

        $admin->update([
            'name' => $request->adminName,
            'email' => $request->adminEmail,
            'phone' => $request->adminPhone,
            'password'=>bcrypt($request->adminPassword),
            'role_id'=> $findrole->role_id,
            'modified_by' => Auth::id(),
            'modified_at' => now()
        ]);

        $admin->load(['role', 'modifiedByUser']);
                if ($findrole) {
                    $role = Role::find($findrole->role_id);
                    if ($role) {
                        $admin->syncRoles([$role->name]);
                    }
        }
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

        $canDelete = Auth::user()->can('admin.delete');
        $canEdit   = Auth::user()->can('admin.edit');
        $canCreate = Auth::user()->can('admin.create');
        $canView = Auth::user()->can('admin.view');

        return response()->json([
            'status' => true,
            'message' => 'Admin All Data Fetch Successfully',
            'admin' => $admin,
            'department' => $department,
            'permissions' => [
                'edit'   => $canEdit,
                'delete' => $canDelete,
                'create' => $canCreate,
                'view'   => $canView
            ]
        ]);

    }

}
