<?php

namespace App\Http\Controllers;

use App\Models\Payroll;
use App\Models\Employee;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Attendance;
use Illuminate\Support\Collection;

class PayrollController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $employees = Employee::all();
       // Calculate salary for each employee based on attendance and formulas
       return view('admin.payroll.index', ['employees' => $employees]);
       
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    
         // Fetch employees and dates from your data source
    $employees = Employee::all(); // Replace 'Employee' with your actual model class
    $today =today();
    $dates = [];

    for ($i = 1; $i <= $today->daysInMonth; ++$i) {
        $dates[] = $i;
    }
    
    return view('admin.payroll.create', compact('employees','dates'));
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // foreach ($request->employee_id as $index => $employeeId) {
        //     $data = [
        //         'employee_id' => $employeeId,
        //         'basic' => $request->basic[$index],
        //         'house_rent' => $request->house_rent[$index],
        //         'medical' => $request->medical[$index],
        //         'transport' => $request->transport[$index],
        //         'special' => $request->special[$index],
        //         'bonus' => $request->bonus[$index],
        //         'present' => $request->present[$index],
        //         'absent' => $request->absent[$index],
        //         'gross_salary' => $request->gross_salary[$index],
        //         'provident_fund' => $request->provident_fund[$index],
        //         'advanced' => $request->advanced[$index],
        //         'tax' => $request->tax[$index],
        //         'life_insurance' => $request->life_insurance[$index],
        //         'health_insurance' => $request->health_insurance[$index],
        //         'deduction' => $request->deduction[$index],
        //         'net_salary' => $request->net_salary[$index],
        //     ];
    
        //     // Create a new payroll entry
        //     Payroll::create($employees);
        // }
    
        // return redirect()->back()->with('success', 'Payroll data has been saved successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Payroll $payroll)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Payroll $payroll)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Payroll $payroll)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payroll $payroll)
    {
        //
    }

    public function grossSalary() {
        $employees = Employee::all();
        return view('admin.payroll.gross', compact('employees'));
    }

    public function calculatePayroll(Request $request)
    {
        try {
            $payrollData = $request->input('payroll');
            
            foreach ($payrollData as $employeeId => $data) {
                Payroll::updateOrCreate(
                    [
                        'employee_id' => $employeeId,
                        'year' => date('Y'),
                        'month' => date('m')
                    ],
                    [
                        'basic' => $data['basic'] ?? 0,
                        'house_rent' => $data['house_rent'] ?? 0,
                        'medical' => $data['medical'] ?? 0,
                        'transport' => $data['transport'] ?? 0,
                        'phone_bill' => $data['phone_bill'] ?? 0,
                        'internet_bill' => $data['internet_bill'] ?? 0,
                        'special' => $data['special'] ?? 0,
                        'bonus' => $data['bonus'] ?? 0,
                        'days_present' => $data['days_present'] ?? 0,
                        'days_absent' => $data['days_absent'] ?? 0,
                        'gross_salary' => $data['gross_salary'] ?? 0,
                        'provident_fund' => $data['provident_fund'] ?? 0,
                        'income_tax' => $data['income_tax'] ?? 0,
                        'health_insurance' => $data['health_insurance'] ?? 0,
                        'life_insurance' => $data['life_insurance'] ?? 0,
                        'deduction' => $data['deduction'] ?? 0,
                        'net_salary' => $data['net_salary'] ?? 0
                    ]
                );
            }

            return redirect()
                ->back()
                ->with('success', 'Payroll data saved successfully');
            
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Error saving payroll data: ' . $e->getMessage());
        }
    }

    public function report()
    {
        // Initialize variables
        $selectedYear = request('year');
        $selectedMonth = request('month');
        $salaryData = new Collection();

        // Only fetch data if form was submitted
        if (request()->has('view_report')) {
            $salaryData = Payroll::with(['employee' => function($query) {
                $query->with('designation');
            }])
            ->when($selectedYear, function($query) use ($selectedYear) {
                return $query->where('year', $selectedYear);
            })
            ->when($selectedMonth, function($query) use ($selectedMonth) {
                return $query->where('month', $selectedMonth);
            })
            ->get();
        }

        return view('admin.payroll.report', compact(
            'salaryData',
            'selectedYear',
            'selectedMonth'
        ));
    }

    public function sheetReport()
    {
        $employees = Employee::all();
        $months = [
            1 => 'January',
            2 => 'February',
            // ... Define months for all 12 months
        ];

        return view('admin.payroll.report', compact('employees', 'months'));
    }

    public function generateReport(Request $request)
    {
        $selectedYear = $request->input('year');
        $selectedMonth = $request->input('month');
        $employees = Employee::all();
        $salaryData = [];

        if ($selectedYear && $selectedMonth) {
            $salaryData = Payroll::whereIn('employee_id', $employees->pluck('id'))
                ->whereYear('year', $selectedYear)
                ->whereMonth('month', $selectedMonth)
                ->get();
        }

        // if ($selectedYear && $selectedMonth) {
        //     $salaryData = Payroll::whereYear('year', $selectedYear)
        //         ->whereMonth('month', $selectedMonth)
        //         ->with('employee') // Load the employee relationship
        //         ->get();
    
        //     return view('admin.payroll.report', compact('salaryData', 'selectedYear', 'selectedMonth'));
        // }
    
        // return view('admin.payroll.report');

        return view('admin.payroll.report', compact('employees', 'selectedYear', 'selectedMonth', 'salaryData'));
    }

    public function generatePayroll(Request $request)
    {
        try {
            $year = $request->input('year');
            $month = $request->input('month');
            
            if (!$year || !$month) {
                return redirect()->back()->with('error', 'Please select both year and month');
            }

            $salaryData = Employee::with(['salary', 'designation'])
                ->whereHas('salary')
                ->get()
                ->map(function ($employee) use ($year, $month) {
                    // Get attendance
                    $daysInMonth = Carbon::create($year, $month)->daysInMonth;
                    $present = Attendance::where('employee_id', $employee->id)
                        ->whereYear('date', $year)
                        ->whereMonth('date', $month)
                        ->where('status', 1)
                        ->count();
                    
                    $absent = $daysInMonth - $present;
                    
                    // Calculate salary components
                    $basic = $employee->salary->basic ?? 0;
                    $houseRent = $employee->salary->house_rent ?? 0;
                    $medical = $employee->salary->medical ?? 0;
                    $transport = $employee->salary->transport ?? 0;
                    $phoneBill = $employee->salary->phone_bill ?? 0;
                    $internetBill = $employee->salary->internet_bill ?? 0;
                    $special = $employee->salary->special ?? 0;
                    $overtimePay = $employee->salary->overtime_pay ?? 0;
                    
                    // Deductions
                    $pf = $employee->salary->provident_fund ?? 0;
                    $tax = $employee->salary->income_tax ?? 0;
                    $healthInsurance = $employee->salary->health_insurance ?? 0;
                    $lifeInsurance = $employee->salary->life_insurance ?? 0;
                    
                    // Calculate totals
                    $grossSalary = $basic + $houseRent + $medical + $transport + 
                                  $phoneBill + $internetBill + $special + $overtimePay;
                    $totalDeductions = $pf + $tax + $healthInsurance + $lifeInsurance;
                    
                    // Deduct for absences
                    if ($absent > 0) {
                        $perDaySalary = $basic / $daysInMonth;
                        $absenceDeduction = $perDaySalary * $absent;
                        $totalDeductions += $absenceDeduction;
                    }
                    
                    $netSalary = $grossSalary - $totalDeductions;
                    
                    // Create or update payroll record
                    Payroll::updateOrCreate(
                        [
                            'employee_id' => $employee->id,
                            'year' => $year,
                            'month' => $month
                        ],
                        [
                            'basic' => $basic,
                            'house_rent' => $houseRent,
                            'medical' => $medical,
                            'transport' => $transport,
                            'phone_bill' => $phoneBill,
                            'internet_bill' => $internetBill,
                            'special' => $special,
                            'overtime_pay' => $overtimePay,
                            'provident_fund' => $pf,
                            'income_tax' => $tax,
                            'health_insurance' => $healthInsurance,
                            'life_insurance' => $lifeInsurance,
                            'days_present' => $present,
                            'days_absent' => $absent,
                            'gross_salary' => $grossSalary,
                            'deduction' => $totalDeductions,
                            'net_salary' => $netSalary
                        ]
                    );

                    return [
                        'employee' => $employee,
                        'salary_details' => [
                            'basic' => $basic,
                            'house_rent' => $houseRent,
                            'medical' => $medical,
                            'transport' => $transport,
                            'phone_bill' => $phoneBill,
                            'internet_bill' => $internetBill,
                            'special' => $special,
                            'overtime_pay' => $overtimePay,
                            'present' => $present,
                            'absent' => $absent,
                            'gross_salary' => $grossSalary,
                            'deduction' => $totalDeductions,
                            'net_salary' => $netSalary
                        ]
                    ];
                });

            return redirect()
                ->route('payroll.report')
                ->with([
                    'success' => 'Payroll generated successfully',
                    'salaryData' => $salaryData,
                    'selectedYear' => $year,
                    'selectedMonth' => $month
                ]);

        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Error generating payroll: ' . $e->getMessage());
        }
    }
}
