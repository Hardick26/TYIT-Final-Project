<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    public function run()
    {
        // Get super admin for assigning tasks
        $superAdmin = User::whereHas('role', function($query) {
            $query->where('slug', 'super-admin');
        })->first();

        // Get users for task assignment
        $admin = User::whereHas('role', function($query) {
            $query->where('slug', 'administrator');
        })->first();

        $moderator = User::whereHas('role', function($query) {
            $query->where('slug', 'moderator');
        })->first();

        if (!$admin || !$moderator || !$superAdmin) {
            echo "\nRequired users not found. Make sure UserSeeder has run first.\n";
            return;
        }

        // Create tasks directly using DB statements to avoid parameter binding issues
        $tasks = [
            [
                'title' => 'Update Employee Database',
                'description' => 'Review and update employee information in the database',
                'assigned_to' => $admin->id,
                'assigned_by' => $superAdmin->id,
                'due_date' => now()->addDays(7)->format('Y-m-d'),
                'status' => 'in_progress',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'title' => 'Conduct Training Session',
                'description' => 'Organize and conduct training session for new employees',
                'assigned_to' => $moderator->id,
                'assigned_by' => $superAdmin->id,
                'due_date' => now()->addDays(14)->format('Y-m-d'),
                'status' => 'pending',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'title' => 'Review Budget Proposals',
                'description' => 'Review and analyze department budget proposals',
                'assigned_to' => $admin->id,
                'assigned_by' => $superAdmin->id,
                'due_date' => now()->addDays(5)->format('Y-m-d'),
                'status' => 'pending',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'title' => 'Implement Security Updates',
                'description' => 'Update system security protocols and implement new measures',
                'assigned_to' => $moderator->id,
                'assigned_by' => $superAdmin->id,
                'due_date' => now()->addDays(10)->format('Y-m-d'),
                'status' => 'in_progress',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'title' => 'Prepare Monthly Report',
                'description' => 'Compile and prepare monthly performance report',
                'assigned_to' => $admin->id,
                'assigned_by' => $superAdmin->id,
                'due_date' => now()->addDays(3)->format('Y-m-d'),
                'status' => 'pending',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];

        foreach ($tasks as $taskData) {
            \DB::table('tasks')->insert($taskData);
        }
    }
}