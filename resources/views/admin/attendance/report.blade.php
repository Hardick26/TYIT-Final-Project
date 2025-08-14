@extends('layouts.admin')

@section('title')
    {{ __('Attendance Report') }}
@endsection

@section('header')
  <div class="d-flex align-items-center justify-content-between mb-4">
    <h1 class="h3">{{ __('Attendance Report') }}</h1>
  </div>
@endsection

@section('content')
<section class="row">
  <div class="col-12">
    <div class="card flex-fill">
      <div class="card-header">              
        <h5 class="card-title mb-0">{{ __('Monthly Attendance Report - ') }} {{ now()->format('F Y') }}</h5>
      </div>
      <div class="table-responsive">
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
              <th scope="col" class="align-middle text-center">Present Days</th>
              <th scope="col" class="align-middle text-center">Absent Days</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($employees as $employee)
              <tr>
                <td class="align-middle">
                  <strong>{{ $employee->firstname }} {{ $employee->lastname }}</strong>
                </td>
                <td class="align-middle">{{ $employee->designation->title }}</td>
                <td class="align-middle">{{ $employee->id }}</td>

                @php
                    $presentCount = 0;
                    $absentCount = 0;
                @endphp

                @for ($i = 1; $i <= $today->daysInMonth; ++$i)
                  @php
                      $date_picker = \Carbon\Carbon::createFromDate($today->year, $today->month, $i)->format('Y-m-d');
                      $isSunday = \Carbon\Carbon::createFromDate($today->year, $today->month, $i)->isSunday();
                      
                      $attendance = \App\Models\Attendance::query()
                          ->where('employee_id', $employee->id)
                          ->where('attendance_date', $date_picker)
                          ->first();
                      
                      $depart = \App\Models\Depart::query()
                          ->where('employee_id', $employee->id)
                          ->where('depart_date', $date_picker)
                          ->first();

                      if ($attendance && !$isSunday) $presentCount++;
                      if ($depart && !$isSunday) $absentCount++;
                  @endphp
                  <td class="text-center @if ($isSunday) bg-light @endif">
                    @if ($isSunday)
                      <span class="text-danger">Holiday</span>
                    @else
                      @if ($attendance)
                        <i class="fas fa-check text-success"></i>
                      @elseif ($depart)
                        <i class="fas fa-times text-danger"></i>
                      @else
                        -
                      @endif
                    @endif
                  </td>
                @endfor
                <td class="align-middle text-center">
                  <span class="badge bg-success">{{ $presentCount }}</span>
                </td>
                <td class="align-middle text-center">
                  <span class="badge bg-danger">{{ $absentCount }}</span>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</section>
@endsection

@push('styles')
<style>
th {
    white-space: nowrap;
}
.text-danger {
    color: #dc3545 !important;
}
.badge {
    font-size: 14px;
    padding: 5px 10px;
}
</style>
@endpush