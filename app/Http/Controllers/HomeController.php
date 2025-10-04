<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Menu;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function otp(){
        return view('admin.otp');
    }

    public function register(){
        return view('admin.register');
    }

    public function showLogin()  {
        return view('admin.login');
    }

    public function dashboard(){
        return view('admin.pages-starter'); 
    }

    public function adminall(){
        return view('admin.admin-all');
    }

    public function adddepartment(){

        return view('admin.department');

    }
    public function viewdep(){
        
        $permissions = Permission::all()->groupBy(function ($perm) {
            return explode('.', $perm->name)[0];
        });
        $department = Department::with('user')->get()->map(function($dept) {
            $dept->menu_access = is_string($dept->menu_access)
                ? json_decode($dept->menu_access, true) ?? []
                : (is_array($dept->menu_access) ? $dept->menu_access : []);

            // Attach current logged-in user’s permissions
            $dept->canEdit   = Auth::check() && Auth::user()->can('dep.edit');
            $dept->canDelete = Auth::check() && Auth::user()->can('dep.delete');
            $dept->canView   = Auth::check() && Auth::user()->can('dep.view');
            $dept->canCreate = Auth::check() && Auth::user()->can('dep.create');

            return $dept;
        });

        if (!auth::user()->can('dep.view')) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized: You do not have permission to view departments'
            ], 403);
        }

        return response()->json([
            'status' => true,
            'message' => 'Department Fetch Successfully',
            'department' => $department,
            'menu' => [
            'dep' => Permission::where('name', 'like', 'dep.%')->get(),
            'admin' => Permission::where('name', 'like', 'admin.%')->get(),
        ]
        ]); 

    }

}