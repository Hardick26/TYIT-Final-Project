<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    public function run()
    {
        // Get some users
        $superAdmin = User::where('email', 'superadmin@gmail.com')->first();
        $users = User::where('id', '!=', $superAdmin->id)->take(3)->get();

        // Create tasks
        $tasks = [
            [
                'title' => 'Complete Monthly Report',
                'description' => 'Prepare and submit the monthly performance report for all departments',
                'assigned_to' => $users[0]->id,
                'assigned_by' => $superAdmin->id,
                'status' => 'pending',
                'due_date' => now()->addDays(7),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Update Employee Database',
                'description' => 'Update employee information and verify all records are current',
                'assigned_to' => $users[1]->id,
                'assigned_by' => $superAdmin->id,
                'status' => 'in_progress',
                'due_date' => now()->addDays(5),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Conduct Training Session',
                'description' => 'Organize and conduct training session for new software implementation',
                'assigned_to' => $users[2]->id,
                'assigned_by' => $superAdmin->id,
                'status' => 'pending',
                'due_date' => now()->addDays(14),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Review Budget Proposals',
                'description' => 'Review and approve department budget proposals for next quarter',
                'assigned_to' => $users[0]->id,
                'assigned_by' => $superAdmin->id,
                'status' => 'pending',
                'due_date' => now()->addDays(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Implement Security Updates',
                'description' => 'Apply latest security patches and update system configurations',
                'assigned_to' => $users[1]->id,
                'assigned_by' => $superAdmin->id,
                'status' => 'in_progress',
                'due_date' => now()->addDays(3),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        foreach ($tasks as $task) {
            Task::create($task);
        }
    }
} 