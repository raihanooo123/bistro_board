<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Support\Str;

class RolePermissionSeeder extends Seeder
{
   
    public function run()
{
    // Check if 'Admin' role exists
    $adminRole = Role::where('slug', 'admin')->first();
    if (!$adminRole) {
        $this->command->error('Admin role does not exist, aborting RolePermissionSeeder.');
        return;
    }

    // Confirm permissions exist
    $permissions = Permission::all();
    if ($permissions->isEmpty()) {
        $this->command->error('No permissions found, aborting RolePermissionSeeder.');
        return;
    }

    // Debugging output to confirm correct IDs
    $this->command->info('Admin Role ID: ' . $adminRole->id);
    foreach ($permissions as $permission) {
        $this->command->info('Assigning Permission ID: ' . $permission->id . ' to Role ID: ' . $adminRole->id);
        
        // Insert role-permission records
        DB::table('role_permissions')->insert([
            'id' => Str::uuid()->toString(),
            'role_id' => $adminRole->id,
            'permission_id' => $permission->id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}

}
