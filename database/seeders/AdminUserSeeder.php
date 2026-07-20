<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $adminRole = Role::query()
            ->where('slug', 'admin')
            ->firstOrFail();

        $admin = User::query()->updateOrCreate(
            [
                'email' => 'admin@example.com',
            ],
            [
                'name' => 'Administrator',
                'username' => 'admin',
                'password' => Hash::make('12345678'),
            ]
        );

        /*
         * role_id tidak dimasukkan ke fillable,
         * jadi ditetapkan secara eksplisit.
         */
        $admin->role()->associate($adminRole);
        $admin->save();
    }
}
