<?php

namespace App\Http\Controllers\Moderator;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::paginate(10);
        return view('moderator.tasks.index', compact('tasks'));
    }

    public function create()
    {
        return view('moderator.tasks.create');
    }

    public function store(Request $request)
    {
        // Add validation and store logic here
    }

    public function edit(Task $task)
    {
        return view('moderator.tasks.edit', compact('task'));
    }

    public function update(Request $request, Task $task)
    {
        // Add validation and update logic here
    }

    public function destroy(Task $task)
    {
        // Add delete logic here
    }

    // Other resource methods will go here...
} 