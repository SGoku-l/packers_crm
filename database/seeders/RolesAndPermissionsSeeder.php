<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $permissions = [
        //     "dep.view",
        //     "dep.edit",
        //     "dep.delete",
        //     "dep.create",
        //     "admin.view",
        //     "admin.create",
        //     "admin.delete",
        //     "admin.edit"
        // ];

        $permissions = [
            "lead.view",
            "lead.edit",
            "lead.create",
            "lead.delete"
        ];

        // Create permissions
        foreach ($permissions as $value) {
            Permission::firstOrCreate(['name' => $value]);
        }

        // Create Admin role (only once, avoids duplicates)
        $admin = Role::firstOrCreate(['name' => 'Admin']);

        // Give all permissions to Admin
        $admin->syncPermissions(Permission::all());
    }
}
