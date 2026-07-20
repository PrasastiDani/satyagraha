<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $adminRole = Role::updateOrCreate(
            ['slug' => 'admin'],
            ['name' => 'Administrator']
        );

        $userRole = Role::updateOrCreate(
            ['slug' => 'user'],
            ['name' => 'User']
        );

        User::query()
            ->whereNull('role_id')
            ->update([
                'role_id' => $userRole->id,
            ]);
    }
}
