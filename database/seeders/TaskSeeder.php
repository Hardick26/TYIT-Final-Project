<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    public function run()
    {
        // Get users with specific roles
        $admin = User::whereHas('role', function($query) {
            $query->where('slug', 'administrator');
        })->first();

        $moderator = User::whereHas('role', function($query) {
            $query->where('slug', 'moderator');
        })->first();

        // Create tasks
        Task::create([
            'title' => 'Update Employee Database',
            'description' => 'Review and update employee information in the database',
            'assigned_to' => $admin->id,
            'due_date' => now()->addDays(7),
            'status' => 'in_progress'
        ]);

        Task::create([
            'title' => 'Conduct Training Session',
            'description' => 'Organize and conduct training session for new employees',
            'assigned_to' => $moderator->id,
            'due_date' => now()->addDays(14),
            'status' => 'pending'
        ]);

        Task::create([
            'title' => 'Review Budget Proposals',
            'description' => 'Review and analyze department budget proposals',
            'assigned_to' => $admin->id,
            'due_date' => now()->addDays(5),
            'status' => 'pending'
        ]);

        Task::create([
            'title' => 'Implement Security Updates',
            'description' => 'Update system security protocols and implement new measures',
            'assigned_to' => $moderator->id,
            'due_date' => now()->addDays(10),
            'status' => 'in_progress'
        ]);

        Task::create([
            'title' => 'Prepare Monthly Report',
            'description' => 'Compile and prepare monthly performance report',
            'assigned_to' => $admin->id,
            'due_date' => now()->addDays(3),
            'status' => 'pending'
        ]);
    }
} 