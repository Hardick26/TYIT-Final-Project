@extends('layouts.admin')

@section('title')
  {{ __('Manage payroll') }}
@endsection

@section('header')
  <div class="d-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-3">Payroll</h1>
    <a href="{{ route('payroll.report') }}" class="btn btn-secondary">
      <i class="fas fa-arrow-left"></i>
      <span class="ps-1">{{ __('Back') }}</span>
    </a>
  </div>
@endsection

@section('content')
<div class="container-fluid p-0">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Payroll Sheet</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('payroll.report') }}" method="GET">
                        <div class="row g-3 mb-4">
                            <div class="col-md-3">
                                <select name="year" class="form-select" id="year">
                                    <option value="">{{ __('Choose Year') }}</option>
                                    @for($year = date('Y'); $year >= 2020; $year--)
                                        <option value="{{ $year }}" {{ (string)$selectedYear === (string)$year ? 'selected' : '' }}>
                                            {{ $year }}
                                        </option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select name="month" class="form-select" id="month">
                                    <option value="">{{ __('Choose Month') }}</option>
                                    @foreach(range(1, 12) as $month)
                                        <option value="{{ $month }}" {{ (string)$selectedMonth === (string)$month ? 'selected' : '' }}>
                                            {{ date('F', mktime(0, 0, 0, $month, 1)) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <input type="text" id="searchInput" class="form-control" placeholder="Search employee...">
                            </div>
                            <div class="col-md-2">
                                <button type="submit" name="view_report" value="1" class="btn btn-primary">View Report</button>
                            </div>
                        </div>
                    </form>

                    @if(isset($salaryData) && $salaryData->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Employee Name</th>
                                        <th>Designation</th>
                                        <th>Basic</th>
                                        <th>House Rent</th>
                                        <th>Medical</th>
                                        <th>Transport</th>
                                        <th>Phone Bill</th>
                                        <th>Internet Bill</th>
                                        <th>Special</th>
                                        <th>Bonus</th>
                                        <th>Present Days</th>
                                        <th>Absent Days</th>
                                        <th>Gross Salary</th>
                                        <th>Deductions</th>
                                        <th>Net Salary</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($salaryData as $payroll)
                                        <tr>
                                            <td>{{ $payroll->employee->firstname }} {{ $payroll->employee->lastname }}</td>
                                            <td>{{ $payroll->employee->designation->title }}</td>
                                            <td>{{ number_format($payroll->basic, 2) }}</td>
                                            <td>{{ number_format($payroll->house_rent, 2) }}</td>
                                            <td>{{ number_format($payroll->medical, 2) }}</td>
                                            <td>{{ number_format($payroll->transport, 2) }}</td>
                                            <td>{{ number_format($payroll->phone_bill, 2) }}</td>
                                            <td>{{ number_format($payroll->internet_bill, 2) }}</td>
                                            <td>{{ number_format($payroll->special, 2) }}</td>
                                            <td>{{ number_format($payroll->bonus, 2) }}</td>
                                            <td>{{ $payroll->days_present }}</td>
                                            <td>{{ $payroll->days_absent }}</td>
                                            <td>{{ number_format($payroll->gross_salary, 2) }}</td>
                                            <td>{{ number_format($payroll->deduction, 2) }}</td>
                                            <td>{{ number_format($payroll->net_salary, 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-info">
                            Please select a year and month to view the payroll report.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('#year, #month').on('change', function() {
        if($('#year').val() && $('#month').val()) {
            $(this).closest('form').submit();
        }
    });

    // Add search functionality
    $("#searchInput").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("table tbody tr").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });
});
</script>
@endpush