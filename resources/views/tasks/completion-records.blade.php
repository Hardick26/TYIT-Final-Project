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
      <table class="table data-table">
        <thead>
          <tr>
            <th scope="col">SL</th>
            <th scope="col">Task Title</th>
            <th scope="col">Completed By</th>
            <th scope="col">Completion Notes</th>
            <th scope="col">Completed At</th>
            <th scope="col">Status</th>
            <th scope="col">Action</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($records as $record)
            <tr>
              <th scope="row">{{ $loop->iteration }}</th>
              <td>{{ $record->task->title }}</td>
              <td>{{ $record->completedByUser->name }}</td>
              <td>{{ $record->completion_notes ?? 'No notes' }}</td>
              <td>{{ $record->completed_at->format('d M Y') }}</td>
              <td>
                <span class="badge bg-success">Completed</span>
              </td>
              <td class="d-flex justify-content-center">
                <a href="{{ route('tasks.show', $record->task_id) }}" class="btn btn-outline-success btn-sm mx-2">
                  <i class="fas fa-eye"></i>
                </a>
                <form action="{{ route('tasks.completion-records.destroy', $record->id) }}" method="post">
                  @csrf
                  @method('delete')
                  <button type="submit" class="btn btn-outline-danger btn-sm" onclick="del(event, this)">
                    <i class="fas fa-trash-alt"></i>
                  </button>
                </form>
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
</section>
@endsection

@section('script')
@endsection