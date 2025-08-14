@extends('layouts.admin')

@section('title')
    {{ __('Daily Attendance') }}
@endsection

@section('header')
  <div class="d-flex align-items-center justify-content-between mb-4">
    <h1 class="h3">{{ __('Attendance Management') }}</h1>
  </div>
@endsection

@section('content')
<section class="row">
  <div class="col-12">
    <div class="card flex-fill">
      <div class="card-header">              
        <h5 class="card-title mb-0">{{ __('Monthly Attendance Sheet - ') }} {{ now()->format('F Y') }}</h5>
      </div>
      <div class="table-responsive">
        <form action="{{ Auth::user()->role->slug === 'super-admin' ? route('check.store') : (Auth::user()->role->slug === 'administrator' ? route('admin.check.store') : route('moderator.check.store') ) }}" method="post">
          @csrf
          <button type="submit" class="btn btn-success m-3">
            <i class="fas fa-save"></i> Save Attendance
          </button>
          
          <table class="table table-hover table-bordered">
            <thead class="table-light">
              <tr>
                <th scope="col" class="align-middle">Employee Name</th>
                <th scope="col" class="align-middle">Position</th>
                <th scope="col" class="align-middle">ID</th>
                @php
                    $today = now();
                    $dates = [];
                    for ($i = 1; $i <= $today->daysInMonth; ++$i) {
                        $dates[] = $i;
                    }
                @endphp
                @foreach ($dates as $date)
                    @php
                        $currentDate = \Carbon\Carbon::createFromDate($today->year, $today->month, $date);
                        $dayName = $currentDate->format('D');
                        $isSunday = $currentDate->isSunday();
                    @endphp
                    <th scope="col" class="text-center align-middle {{ $isSunday ? 'bg-light' : '' }}" style="min-width: 80px;">
                        {{ $date }}
                        <div class="small {{ $isSunday ? 'text-danger' : 'text-muted' }}">{{ $dayName }}</div>
                    </th>
                @endforeach
              </tr>
            </thead>
            <tbody>
              @foreach ($employees as $employee)
                <input type="hidden" name="employee_id" value="{{ $employee->id }}">
                <tr>
                  <td class="align-middle">
                    <strong>{{ $employee->firstname }} {{ $employee->lastname }}</strong>
                  </td>
                  <td class="align-middle">{{ $employee->designation->title }}</td>
                  <td class="align-middle">{{ $employee->id }}</td>

                  @for ($i = 1; $i <= $today->daysInMonth; ++$i)
                    @php
                        $date_picker = \Carbon\Carbon::createFromDate($today->year, $today->month, $i)->format('Y-m-d');
                        $isSunday = \Carbon\Carbon::createFromDate($today->year, $today->month, $i)->isSunday();
                        
                        $check_attd = \App\Models\Attendance::query()
                            ->where('employee_id', $employee->id)
                            ->where('attendance_date', $date_picker)
                            ->first();
                        
                        $check_depart = \App\Models\Depart::query()
                            ->where('employee_id', $employee->id)
                            ->where('depart_date', $date_picker)
                            ->first();
                    @endphp
                    <td class="text-center @if ($isSunday) bg-light @endif">
                      <div class="attendance-checkboxes">
                        <div class="form-check">
                          <input class="form-check-input" 
                                type="checkbox" 
                                id="check_box_attd_{{ $employee->id }}_{{ $i }}"
                                name="attd[{{ $date_picker }}][{{ $employee->id }}]"
                                @if (isset($check_attd)) checked @endif
                                @if ($isSunday) disabled @endif>
                          <label class="form-check-label small" for="check_box_attd_{{ $employee->id }}_{{ $i }}">
                            Present
                          </label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" 
                                type="checkbox" 
                                id="check_box_depart_{{ $employee->id }}_{{ $i }}"
                                name="depart[{{ $date_picker }}][{{ $employee->id }}]"
                                @if (isset($check_depart)) checked @endif
                                @if ($isSunday) disabled @endif>
                          <label class="form-check-label small" for="check_box_depart_{{ $employee->id }}_{{ $i }}">
                            Absent
                          </label>
                        </div>
                      </div>
                    </td>
                  @endfor
                </tr>
              @endforeach
            </tbody>
          </table>
        </form>
      </div>
    </div>
  </div>
</section>
@endsection

@push('styles')
<style>
.attendance-checkboxes {
    display: flex;
    flex-direction: column;
    gap: 4px;
}
.form-check {
    margin: 0;
    padding: 0;
    min-height: auto;
}
.form-check-input {
    margin: 0 4px;
}
.form-check-label {
    color: #666;
}
th {
    white-space: nowrap;
}
.text-danger {
    color: #dc3545 !important;
}
</style>
@endpush