<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        Permission::create(['name' => 'create posts']);
        Permission::create(['name' => 'edit posts']);
        Permission::create(['name' => 'delete posts']);
        Permission::create(['name' => 'view posts']);
        Permission::create(['name' => 'view users']);
        Permission::create(['name' => 'create users']);

        Permission::create(['name' => 'edit users']);

        // Create roles and assign permissions
        $admin = Role::create(['name' => 'admin']);
        $admin->givePermissionTo(['create posts', 'edit posts', 'delete posts', 'view posts']);

        $editor = Role::create(['name' => 'editor']);
        $editor->givePermissionTo(['create posts', 'edit posts', 'view posts']);

        $viewer = Role::create(['name' => 'viewer']);
        $viewer->givePermissionTo(['view posts', 'view users']);
    
        $manager = Role::create(['name' => 'manager']);
        $manager->givePermissionTo(['create posts', 'edit posts', 'delete posts', 'view posts']);
    
    }
}
