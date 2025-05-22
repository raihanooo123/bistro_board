<?php
namespace Database\Seeders;
use App\Models\Role;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;




class UserSeeder extends Seeder
{
    public function run()
    {
        $role = Role::where('name', 'Admin')->first();
        if ($role) {
            $user = User::create([
                'first_name' => 'Admin',   // Provide a value for first_name
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'password' => bcrypt('password'),
            ]);

            // Assign 'Admin' role to the user
            (new UserRole())->create([
                'user_id' => $user->id,
                'role_id' => $role->id
            ]);
        }
    }
}
