@extends('layouts.admin')

@section('content')
<div class="container-fluid p-0">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3">{{ __('Completion Records') }}</h1>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>{{ __('SL') }}</th>
                            <th>{{ __('Task Title') }}</th>
                            <th>{{ __('Completed By') }}</th>
                            <th>{{ __('Completion Date') }}</th>
                            <th>{{ __('Notes') }}</th>
                            <th>{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($records as $index => $record)
                            <tr>
                                <td>{{ ($records->currentPage() - 1) * $records->perPage() + $index + 1 }}</td>
                                <td>{{ $record->task->title }}</td>
                                <td>{{ $record->completedBy->name }}</td>
                                <td>{{ $record->completed_at->format('d M Y H:i') }}</td>
                                <td>{{ Str::limit($record->completion_notes, 50) }}</td>
                                <td>
                                    <a href="{{ route('completion-records.show', $record->id) }}" 
                                       class="btn btn-sm" 
                                       style="background-color: #28a745; color: white;">
                                        <i class="align-middle" data-feather="eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">{{ __('No completion records found') }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-between align-items-center mt-3">
                <div>
                    Showing {{ $records->firstItem() ?? 0 }} to {{ $records->lastItem() ?? 0 }} of {{ $records->total() }} entries
                </div>
                <div>
                    {{ $records->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 