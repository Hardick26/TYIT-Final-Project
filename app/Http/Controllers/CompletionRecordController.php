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

        return view('completion-records.index', compact('records'));
    }

    public function show(TaskCompletionRecord $record)
    {
        return view('completion-records.show', compact('record'));
    }
} 