<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            [
                'name' => 'client',
                'is_admin' => false
            ],
            [
                'name' => 'staff',
                'is_admin' => false
            ],
            [
                'name' => 'admin',
                'is_admin' => true
            ]
        ];

        Role::insert($roles);
    }
}
