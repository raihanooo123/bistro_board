<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PermissionGroup; // Adjust the model import if necessary
use Illuminate\Support\Str; // Add this line

class PermissionGroupSeeder extends Seeder
{
    public function run()
    {
        PermissionGroup::create(['id' => (string) Str::uuid(), 'name' => 'Post Management']);
    }
}
