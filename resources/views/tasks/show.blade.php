@extends('layouts.admin')

@section('title')
    {{ __('View Task Details') }}
@endsection

@section('header')
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-3">Task Details</h1>
        <a href="{{ url()->previous() }}" class="btn btn-outline-primary">
            <i class="fas fa-arrow-left"></i>
            <span class="ps-1">{{ __('Back') }}</span>
        </a>
    </div>
@endsection

@section('content')
<section class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <h5>Task Title</h5>
                        <p>{{ $task->title }}</p>
                    </div>
                    <div class="col-md-6">
                        <h5>Status</h5>
                        <span class="badge {{ $task->status === 'completed' ? 'bg-success' : ($task->status === 'in_progress' ? 'bg-primary' : 'bg-warning') }}">
                            {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                        </span>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-12">
                        <h5>Description</h5>
                        <p>{{ $task->description }}</p>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <h5>Assigned To</h5>
                        <p>{{ $task->assignedTo->name }}</p>
                    </div>
                    <div class="col-md-6">
                        <h5>Assigned By</h5>
                        <p>{{ $task->assignedBy->name }}</p>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <h5>Due Date</h5>
                        <p>{{ $task->due_date->format('d M Y') }}</p>
                    </div>
                    <div class="col-md-6">
                        <h5>Created At</h5>
                        <p>{{ $task->created_at->format('d M Y H:i') }}</p>
                    </div>
                </div>

                @if($task->completionRecord)
                <div class="row mb-3">
                    <div class="col-12">
                        <h5 class="text-success">Completion Details</h5>
                        <div class="card bg-light">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h6>Completed By</h6>
                                        <p>{{ $task->completionRecord->completedByUser->name }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <h6>Completed At</h6>
                                        <p>{{ $task->completionRecord->completed_at->format('d M Y H:i') }}</p>
                                    </div>
                                </div>
                                @if($task->completionRecord->completion_notes)
                                <div class="row mt-2">
                                    <div class="col-12">
                                        <h6>Completion Notes</h6>
                                        <p>{{ $task->completionRecord->completion_notes }}</p>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <form action="{{ route('tasks.complete', $task->id) }}" method="POST" class="mt-3">
                    @csrf
                    <div class="form-group">
                        <label for="completion_notes">Completion Notes</label>
                        <textarea name="completion_notes" id="completion_notes" class="form-control" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-success mt-2">Mark as Completed</button>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection 