<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\RolePermission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;


class RoleSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
{
    // Role: Admin
    $check_role = Role::where('slug', 'admin')->first();
    if (!$check_role) {
        $role = Role::create([
            'name' => 'Admin',
            'slug' => 'admin',
        ]);

        foreach (Permission::all() as $key => $value) {
            $role->permissions()->attach($value, ['id' => Str::uuid()->toString()]);
        }

        // Add a debugging line to confirm creation
        // dd("Admin Role Created", $role->id);
    } else {
        // dd("Admin Role Exists", $check_role->id);
    }
}

}