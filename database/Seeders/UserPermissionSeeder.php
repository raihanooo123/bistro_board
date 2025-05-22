<?php
namespace Database\Seeders;


use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Permission;
use App\Models\UserPermission;

class UserPermissionSeeder extends Seeder
{
    public function run()
    {
        $users = User::all();
        $permissions = Permission::all();

        foreach ($users as $user) {
            foreach ($permissions as $permission) {
                UserPermission::create([
                    'id' => (string) \Str::uuid(),
                    'user_id' => $user->id,
                    'permission_id' => $permission->id,
                ]);
            }
        }
    }
}
