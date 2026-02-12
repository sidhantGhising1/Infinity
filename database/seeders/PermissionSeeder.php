<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
{
    public function run()
    {
        // Clear cached permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // ============================
        // MODULES
        // ============================

        $modules = [
            'users',
            'students',
            'universities',
            'consultancies',
            'courses',
            'counselors',
            'fee-structures',
            'admin-profile',
            'roles'
        ];

        $actions = ['view', 'create', 'update', 'delete'];

        // ============================
        // CREATE PERMISSIONS
        // ============================

        foreach ($modules as $module) {
            foreach ($actions as $action) {

                $name = $action . ' ' . $module;

                Permission::firstOrCreate([
                    'name' => $name,
                    'guard_name' => 'web'
                ]);
            }
        }

        // ============================
        // CREATE ROLES
        // ============================

        $superAdmin = Role::firstOrCreate([
            'name' => 'Super Admin',
            'guard_name' => 'web'
        ]);

        $admin = Role::firstOrCreate([
            'name' => 'Admin',
            'guard_name' => 'web'
        ]);

        // ============================
        // ASSIGN PERMISSIONS
        // ============================

        $superAdmin->syncPermissions(Permission::all());

        $admin->syncPermissions([
            'view users',
            'create users',
            'update users',

            'view students',
            'create students',
            'update students',

            'view universities',
            'create universities',
            'update universities',

            'view consultancies',
            'create consultancies',
            'update consultancies',

            'view courses',
            'create courses',
            'update courses',

            'view counselors',
            'create counselors',
            'update counselors',

            'view fee-structures',
            'create fee-structures',
            'update fee-structures',

            'view admin-profile',
            'update admin-profile'
        ]);
    }
}
