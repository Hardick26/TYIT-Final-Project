@extends('layouts.admin')

@section('title')
  {{ __('Task Completion Records') }}
@endsection

@section('header')
  <div class="d-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-3">Task Completion Records</h1>
  </div>
@endsection

@section('content')
<section class="row">
  <div class="col-12">
    <div class="card flex-fill">
      <div class="card-body">
        @if(session('success'))
          <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        @endif

        <div class="table-responsive">
          <table class="table table-hover my-0" id="completionRecordsTable">
            <thead>
              <tr>
                <th>{{ __('SL') }}</th>
                <th>{{ __('Task Title') }}</th>
                <th>{{ __('Completed By') }}</th>
                <th>{{ __('Completion Notes') }}</th>
                <th>{{ __('Completed At') }}</th>
                <th>{{ __('Status') }}</th>
                <th>{{ __('Action') }}</th>
              </tr>
            </thead>
            <tbody>
              @forelse($records as $key => $record)
                <tr>
                  <td>{{ $key + 1 }}</td>
                  <td>{{ $record->task->title }}</td>
                  <td>{{ $record->completedBy->name }}</td>
                  <td>{{ $record->completion_notes ?? 'No notes' }}</td>
                  <td>{{ $record->completed_at->format('d M Y') }}</td>
                  <td>
                    <span class="badge bg-success">Completed</span>
                  </td>
                  <td>
                    <div class="d-flex gap-2">
                      <a href="{{ route('tasks.show', $record->task_id) }}" 
                         class="btn btn-sm btn-outline-success">
                        <i class="fas fa-eye"></i>
                      </a>
                      <form action="{{ route('completion-records.destroy', $record->id) }}" 
                            method="POST" 
                            class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="btn btn-sm btn-outline-danger"
                                onclick="return confirm('Are you sure you want to delete this record?')">
                          <i class="fas fa-trash-alt"></i>
                        </button>
                      </form>
                    </div>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="7" class="text-center">{{ __('No Data Found') }}</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('#completionRecordsTable').DataTable({
        "dom": '<"top"fl>rt<"bottom"ip><"clear">',
        "ordering": true,
        "info": true,
        "searching": true,
        "responsive": true,
        "pageLength": 10,
        "language": {
            "lengthMenu": "Show _MENU_ entries",
            "info": "Showing _START_ to _END_ of _TOTAL_ entries",
            "search": "Search:",
            "paginate": {
                "first": "First",
                "last": "Last",
                "next": "Next",
                "previous": "Previous"
            }
        },
        "columnDefs": [
            { "orderable": false, "targets": [6] }
        ]
    });
});
</script>
@endpush