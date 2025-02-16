<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    public function run()
    {
        $roles = [
            [
                'title' => 'Super Admin',
                'description' => 'Super Administrator with full access',
                'slug' => 'super-admin',
                'status' => 1
            ],
            [
                'title' => 'Administrator',
                'description' => 'Administrator with management access',
                'slug' => 'administrator',
                'status' => 1
            ],
            [
                'title' => 'Moderator',
                'description' => 'Moderator with limited access',
                'slug' => 'moderator',
                'status' => 1
            ],
            [
                'title' => 'HR Manager',
                'description' => 'Human Resource Manager',
                'slug' => 'hr-manager',
                'status' => 1
            ],
            [
                'title' => 'Payroll Manager',
                'description' => 'Payroll Management access',
                'slug' => 'payroll-manager',
                'status' => 1
            ],
            [
                'title' => 'Data Analyst',
                'description' => 'Data Analysis access',
                'slug' => 'data-analyst',
                'status' => 1
            ],
            [
                'title' => 'Department Head',
                'description' => 'Department Management access',
                'slug' => 'department-head',
                'status' => 1
            ],
            [
                'title' => 'Employee',
                'description' => 'Basic employee access',
                'slug' => 'employee',
                'status' => 1
            ]
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}
