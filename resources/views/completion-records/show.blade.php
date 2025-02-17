@extends('layouts.admin')

@section('content')
<div class="container-fluid p-0">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3">{{ __('Completion Record Details') }}</h1>
        <a href="{{ url()->previous() }}" class="btn btn-secondary">
            <i class="align-middle" data-feather="arrow-left"></i> {{ __('Back') }}
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h5>{{ __('Task Information') }}</h5>
                    <hr>
                    <dl class="row">
                        <dt class="col-sm-4">{{ __('Title') }}</dt>
                        <dd class="col-sm-8">{{ $record->task->title }}</dd>

                        <dt class="col-sm-4">{{ __('Description') }}</dt>
                        <dd class="col-sm-8">{{ $record->task->description }}</dd>

                        <dt class="col-sm-4">{{ __('Assigned To') }}</dt>
                        <dd class="col-sm-8">{{ $record->task->assignedTo->name }}</dd>

                        <dt class="col-sm-4">{{ __('Assigned By') }}</dt>
                        <dd class="col-sm-8">{{ $record->task->assignedBy->name }}</dd>
                    </dl>
                </div>

                <div class="col-md-6">
                    <h5>{{ __('Completion Information') }}</h5>
                    <hr>
                    <dl class="row">
                        <dt class="col-sm-4">{{ __('Completed By') }}</dt>
                        <dd class="col-sm-8">{{ $record->completedBy->name }}</dd>

                        <dt class="col-sm-4">{{ __('Completion Date') }}</dt>
                        <dd class="col-sm-8">{{ $record->completed_at->format('d M Y H:i') }}</dd>

                        <dt class="col-sm-4">{{ __('Completion Notes') }}</dt>
                        <dd class="col-sm-8">{{ $record->completion_notes }}</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 