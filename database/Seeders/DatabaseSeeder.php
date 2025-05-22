<?php
namespace Database\Seeders;
use Carbon\Carbon;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            // required for production
        // CategoriesTableSeeder::class,
        // HangarTableSeeder::class,

        // ItemStatusesTableSeeder::class,
        // ItemTypesTableSeeder::class,
        // UnitOfMeasuresTableSeeder::class,
  

        RoleSeeder::class,
        PermissionSeeder::class,
        RolePermissionSeeder::class,
        UserSeeder::class,

        ]
    );
  

    }
}
