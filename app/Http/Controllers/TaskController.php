<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use App\Notifications\TaskCompletedNotification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\TaskCompletionRecord;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $tasks = Task::with('assignedTo')
                     ->when($search, function ($query) use ($search) {
                         $query->where('title', 'LIKE', "%{$search}%")
                               ->orWhere('description', 'LIKE', "%{$search}%")
                               ->orWhereHas('assignedTo', function ($query) use ($search) {
                                   $query->where('name', 'LIKE', "%{$search}%");
                               });
                     })
                     ->orderBy('id', 'asc')
                     ->paginate(10);

        if($request->ajax()) {
            return view('tasks.table', compact('tasks'))->render();
        }

        return view('tasks.index', compact('tasks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::whereHas('role', function($query) {
            $query->whereIn('slug', ['administrator', 'moderator']);
        })->get();
        
        return view('tasks.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'assigned_to' => 'required|exists:users,id',
            'due_date' => 'required|date|after_or_equal:today',
        ]);

        Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'assigned_to' => $request->assigned_to,
            'due_date' => $request->due_date,
            'status' => 'pending',
        ]);

        return redirect()->route('tasks.index')
            ->with('success', 'Task created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        return view('tasks.show', compact('task'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        $users = User::whereHas('role', function($query) {
            $query->whereIn('slug', ['administrator', 'moderator']);
        })->get();
        
        return view('tasks.edit', compact('task', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'assigned_to' => 'required|exists:users,id',
            'due_date' => 'required|date',
            'status' => 'required|in:pending,in_progress,completed',
        ]);

        $task->update([
            'title' => $request->title,
            'description' => $request->description,
            'assigned_to' => $request->assigned_to,
            'due_date' => $request->due_date,
            'status' => $request->status,
        ]);

        return redirect()->route('tasks.index')
            ->with('success', 'Task updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $task->delete();

        return redirect()->route('tasks.index')
            ->with('success', 'Task deleted successfully.');
    }

    public function complete(Request $request, Task $task)
    {
        $request->validate([
            'completion_notes' => 'required|string'
        ]);

        try {
            // Update task status
            $task->update([
                'status' => 'completed',
                'completion_notes' => $request->completion_notes,
                'completed_at' => now()
            ]);

            // Create completion record
            TaskCompletionRecord::create([
                'task_id' => $task->id,
                'completed_by' => auth()->id(),
                'completion_notes' => $request->completion_notes,
                'completed_at' => now()
            ]);

            // Send notification to task creator and admin
            $superAdmin = User::whereHas('role', function($query) {
                $query->where('slug', 'super-admin');
            })->first();

            $notifiables = collect([$task->assignedBy, $superAdmin])->unique();
            
            foreach ($notifiables as $notifiable) {
                if ($notifiable) {
                    $notifiable->notify(new TaskCompletedNotification(
                        $task,
                        auth()->user(),
                        $request->completion_notes
                    ));
                }
            }

            return redirect()->route('tasks.index')
                ->with('success', 'Task marked as completed successfully.');
        } catch (\Exception $e) {
            return redirect()->route('tasks.index')
                ->with('error', 'Error completing task: ' . $e->getMessage());
        }
    }

    public function completionRecords()
    {
        $records = TaskCompletionRecord::with(['task', 'completedByUser'])
            ->latest('completed_at')
            ->get();

        return view('tasks.completion-records', compact('records'));
    }

    public function destroyCompletionRecord($id)
    {
        $record = TaskCompletionRecord::findOrFail($id);
        $record->delete();

        return redirect()->route('tasks.completion-records')
            ->with('success', 'Completion record deleted successfully.');
    }
} 