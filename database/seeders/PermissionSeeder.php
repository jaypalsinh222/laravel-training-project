<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            'discount-list',
            'discount-create',
            'discount-edit',
            'discount-delete',
            'user-list',
            'user-create',
            'user-edit',
            'user-delete',
        ];

        foreach ($permissions as $permission) {
            Permission::create(
                [
                    'name' => $permission,
                    'guard_name' => 'web',
                ]
            );
        }
    }
}
