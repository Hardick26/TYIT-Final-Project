<?php

namespace App\Http\Controllers;

use App\Models\TaskCompletionRecord;
use Illuminate\Http\Request;

class CompletionRecordController extends Controller
{
    public function index()
    {
        $records = TaskCompletionRecord::with(['task', 'completedBy'])
                    ->latest('completed_at')
                    ->paginate(10);

        return view('tasks.completion-records', compact('records'));
    }

    public function show(TaskCompletionRecord $record)
    {
        return view('tasks.completion-records-show', compact('record'));
    }

    public function destroy(TaskCompletionRecord $record)
    {
        try {
            $record->delete();
            return redirect()->route('completion-records.index')
                ->with('success', 'Record deleted successfully');
        } catch (\Exception $e) {
            return redirect()->route('completion-records.index')
                ->with('error', 'Error deleting record: ' . $e->getMessage());
        }
    }
} 