<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AllowanceController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\CheckController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DesignationController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\LateTimeController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\OverTimeController;
use App\Http\Controllers\PayrollController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TaskController;
use App\Models\Payroll;
use App\Http\Controllers\CompletionRecordController;
use App\Http\Controllers\AdminUserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/admin', function () {
//     return view('layouts.admin');
// });
// Route::middleware('auth')->prefix('admin')->group( function () {
Route::middleware('superadmin')->prefix('super')->group( function () {

    Route::get('/', [AdminController::class, 'index'])->name('super.dashboard');
    Route::get('/sample', [AdminController::class, 'sample'])->name('view.sample');
    Route::resource('employee', EmployeeController::class);
    Route::resource('department', DepartmentController::class);
    Route::resource('designation', DesignationController::class);
    // Route::resource('attendance', AttendanceController::class);
    Route::resource('leaves', LeaveController::class);
    // Route::resource('salary', SalaryController::class);
    Route::resource('allowance',AllowanceController::class);
    Route::resource('payroll',PayrollController::class);
    Route::resource('roles',RoleController::class );
    Route::resource('user',UserController::class );
    Route::resource('attendance',AttendanceController::class );
    Route::resource('schedule',ScheduleController::class );
    Route::post('/check',[CheckController::class,'CheckStore'])->name('check.store');
    Route::get('/report',[CheckController::class,'sheetReport'])->name('sheet.report');
    Route::get('/gross-salary', [PayrollController::class, 'grossSalary'])->name('gross.salary');
    Route::get('/latetime',[LateTimeController::class,'index'])->name('attendance.latetime');
    Route::post('/latetime',[LateTimeController::class,'lateTime'])->name('late.time');
    Route::get('/overtime',[OverTimeController::class,'index'])->name('attendance.overtime');
    Route::post('/overtime',[OverTimeController::class,'overTime'])->name('over.time');
    Route::get('/barcode', [AttendanceController::class, 'barcode'])->name('attd.barcode');
    // Route::get('/report', [AttendanceController::class, 'report'])->name('attendance.report');
    Route::resource('/leaves',LeaveController::class);
    // Route::post('/check/store', [PayrollController::class, ])->name('check.store');
    Route::post('/calculate', [PayrollController::class, 'calculatePayroll'])->name('calculate.payroll');
    Route::get('/sheet-report', [PayrollController::class, 'sheetReport'])->name('payroll.report');
    Route::post('/generate', [PayrollController::class, 'generateReport'])->name('generate.payroll');
    Route::resource('tasks', TaskController::class);

});
Route::middleware('admin')->prefix('admin')->name('admin.')->group( function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::prefix('department')->group(function() {
        Route::get('/', [DepartmentController::class, 'index'])->name('admin.department.index');
        Route::get('/create', [DepartmentController::class, 'create'])->name('admin.department.create');
        Route::post('/', [DepartmentController::class, 'create'])->name('admin.department.store');
        Route::get('/{id}/edit', [DepartmentController::class, 'edit'])->name('admin.department.edit');
        Route::put('/{id}', [DepartmentController::class, 'update'])->name('admin.department.update');
        Route::delete('/{id}', [DepartmentController::class, 'destroy'])->name('admin.department.destroy');
    });
    Route::prefix('designation')->group(function () {
        Route::get('/', [DesignationController::class, 'index'])->name('admin.designation.index');
        Route::get('/create', [DesignationController::class, 'create'])->name('admin.designation.create');
        Route::post('/', [DesignationController::class, 'store'])->name('admin.designation.store');
        Route::get('/{id}/edit', [DesignationController::class, 'edit'])->name('admin.designation.edit');
        Route::put('/{id}', [DesignationController::class, 'update'])->name('admin.designation.update');
        Route::delete('/{id}', [DesignationController::class, 'destroy'])->name('admin.designation.destroy');
    });    
    Route::prefix('employee')->group(function() {
        Route::get('/', [EmployeeController::class, 'index'])->name('admin.employee.index');
        Route::get('/create', [EmployeeController::class, 'create'])->name('admin.employee.create');
        Route::post('/store', [DesignationController::class, 'store'])->name('designation.store');
        Route::get('/{id}/edit', [EmployeeController::class, 'edit'])->name('admin.employee.edit');
        Route::put('/{id}', [EmployeeController::class, 'update'])->name('admin.employee.update');
        Route::delete('/{id}', [EmployeeController::class, 'destroy'])->name('admin.employee.destroy');
    });
    Route::prefix('schedule')->group(function() {
        Route::get('/', [ScheduleController::class, 'index'])->name('admin.schedule.index');
        Route::get('/create', [ScheduleController::class, 'create'])->name('admin.schedule.create');
        Route::post('/', [ScheduleController::class, 'create'])->name('admin.schedule.store');
        Route::get('/{id}/edit', [ScheduleController::class, 'edit'])->name('admin.schedule.edit');
        Route::put('/{id}', [ScheduleController::class, 'update'])->name('admin.schedule.update');
        Route::delete('/{id}', [ScheduleController::class, 'destroy'])->name('admin.schedule.destroy');
    });
    // Route::prefix('attendance')->group(function() {
        Route::get('/attendance', [AttendanceController::class, 'index'])->name('admin.attendance.index');
        Route::post('/check', [CheckController::class, 'CheckStore'])->name('admin.check.store');
        Route::get('/report', [CheckController::class, 'sheetReport'])->name('admin.sheet.report');
    // });
    Route::prefix('leaves')->group(function() {
        Route::get('/', [LeaveController::class, 'index'])->name('admin.leaves.index');
        Route::get('/create', [LeaveController::class, 'create'])->name('admin.leaves.create');
        Route::post('/', [LeaveController::class, 'create'])->name('admin.leaves.store');
        Route::get('/{id}/edit', [LeaveController::class, 'edit'])->name('admin.leaves.edit');
        Route::put('/{id}', [LeaveController::class, 'update'])->name('admin.leaves.update');
        Route::delete('/{id}', [LeaveController::class, 'destroy'])->name('admin.leaves.destroy');
    });
    // Route::resource('users',UserController::class );
    Route::prefix('users')->group(function() {
        Route::get('/', [UserController::class, 'index'])->name('admin.users.index');
        Route::get('/create', [UserController::class, 'create'])->name('admin.users.create');
        Route::post('/', [UserController::class, 'store'])->name('admin.users.store');
        Route::get('/{id}/edit', [UserController::class, 'edit'])->name('admin.users.edit');
        Route::put('/{id}', [UserController::class, 'update'])->name('admin.users.update');
        Route::delete('/{id}', [UserController::class, 'destroy'])->name('admin.users.destroy');
    });
    Route::prefix('payroll')->group(function() {
        
        Route::get('/', [PayrollController::class, 'index'])->name('admin.payroll.index');
        Route::get('/create', [PayrollController::class, 'create'])->name('admin.payroll.create');
        

    });
    Route::post('/calculate', [PayrollController::class, 'calculatePayroll'])->name('admin.calculate.payroll');
    Route::resource('roles', RoleController::class);
    // Users routes
    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [AdminUserController::class, 'create'])->name('users.create');
    Route::post('/users', [AdminUserController::class, 'store'])->name('users.store');
    Route::get('/users/{user}/edit', [AdminUserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [AdminUserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [AdminUserController::class, 'destroy'])->name('users.destroy');
});

Route::middleware('moderator')->prefix('moderator')->group( function () {
    Route::get('/', [AdminController::class, 'index'])->name('moderator.dashboard');
    Route::prefix('schedule')->group(function() {
        Route::get('/', [ScheduleController::class, 'index'])->name('moderator.schedule.index');
        Route::get('/create', [ScheduleController::class, 'create'])->name('moderator.schedule.create');
        Route::post('/', [ScheduleController::class, 'create'])->name('moderator.schedule.store');
        Route::get('/{id}/edit', [ScheduleController::class, 'edit'])->name('moderator.schedule.edit');
        Route::put('/{id}', [ScheduleController::class, 'update'])->name('moderator.schedule.update');
        Route::delete('/{id}', [ScheduleController::class, 'destroy'])->name('moderator.schedule.destroy');
    });
    // Route::prefix('attendance')->group(function() {
        Route::get('/attendance', [AttendanceController::class, 'index'])->name('moderator.attendance.index');
        Route::post('/check', [CheckController::class, 'CheckStore'])->name('moderator.check.store');
        Route::get('/report', [CheckController::class, 'sheetReport'])->name('moderator.sheet.report');
    // });
});

Route::middleware('hr')->prefix('hr-manager')->group( function () {
    Route::get('/', [AdminController::class, 'index'])->name('hr.dashboard');
    Route::prefix('department')->group(function() {
        Route::get('/', [DepartmentController::class, 'index'])->name('hr.department.index');
        Route::get('/create', [DepartmentController::class, 'create'])->name('hr.department.create');
        Route::post('/', [DepartmentController::class, 'create'])->name('hr.department.store');
        Route::get('/{id}/edit', [DepartmentController::class, 'edit'])->name('hr.department.edit');
        Route::put('/{id}', [DepartmentController::class, 'update'])->name('hr.department.update');
        Route::delete('/{id}', [DepartmentController::class, 'destroy'])->name('hr.department.destroy');
    });
    Route::prefix('designation')->group(function() {
        Route::get('/', [DesignationController::class, 'index'])->name('hr.designation.index');
        Route::get('/create', [DesignationController::class, 'create'])->name('hr.designation.create');
        Route::post('/', [DesignationController::class, 'create'])->name('hr.designation.store');
        Route::get('/{id}/edit', [DesignationController::class, 'edit'])->name('hr.designation.edit');
        Route::put('/{id}', [DesignationController::class, 'update'])->name('hr.designation.update');
        Route::delete('/{id}', [DesignationController::class, 'destroy'])->name('hr.designation.destroy');
    });
    Route::prefix('employee')->group(function() {
        Route::get('/', [EmployeeController::class, 'index'])->name('hr.employee.index');
        Route::get('/create', [EmployeeController::class, 'create'])->name('hr.employee.create');
        Route::get('/{id}/show', [EmployeeController::class, 'show'])->name('hr.employee.show');
        Route::post('/', [EmployeeController::class, 'create'])->name('hr.employee.store');
        Route::get('/{id}/edit', [EmployeeController::class, 'edit'])->name('hr.employee.edit');
        Route::put('/{id}', [EmployeeController::class, 'update'])->name('hr.employee.update');
        Route::delete('/{id}', [EmployeeController::class, 'destroy'])->name('hr.employee.destroy');
    });
    Route::prefix('leaves')->group(function() {
        Route::get('/', [LeaveController::class, 'index'])->name('hr.leaves.index');
        Route::get('/create', [LeaveController::class, 'create'])->name('hr.leaves.create');
        Route::post('/', [LeaveController::class, 'create'])->name('hr.leaves.store');
        Route::get('/{id}/edit', [LeaveController::class, 'edit'])->name('hr.leaves.edit');
        Route::put('/{id}', [LeaveController::class, 'update'])->name('hr.leaves.update');
        Route::delete('/{id}', [LeaveController::class, 'destroy'])->name('hr.leaves.destroy');
    });
});

Route::middleware('payroll')->prefix('manager')->group( function () {
    Route::get('/', [AdminController::class, 'index'])->name('payroll.dashboard');
    Route::prefix('payroll')->group(function() {
        
        Route::get('/', [PayrollController::class, 'index'])->name('manager.payroll.index');
        Route::get('/create', [PayrollController::class, 'create'])->name('manager.payroll.create');
        

    });
    Route::post('/calculate', [PayrollController::class, 'calculatePayroll'])->name('manager.calculate.payroll');
});

// Dashboard Routes
Route::middleware(['auth'])->group(function () {
    // Default redirect after login
    Route::get('/dashboard', function () {
        $user = Auth::user();
        switch ($user->role->slug) {
            case 'super-admin':
                return redirect()->route('super.dashboard');
            case 'administrator':
                return redirect()->route('admin.dashboard');
            case 'moderator':
                return redirect()->route('moderator.dashboard');
            case 'hr':
                return redirect()->route('hr.dashboard');
            case 'payroll':
                return redirect()->route('payroll.dashboard');
            default:
                return redirect()->route('login');
        }
    })->name('dashboard');

    // Role-specific dashboard routes
    Route::middleware(['role:super-admin'])->group(function () {
        Route::get('/super/dashboard', [DashboardController::class, 'superAdmin'])->name('super.dashboard');
    });

    Route::middleware(['role:administrator'])->group(function () {
        Route::get('/admin/dashboard', [DashboardController::class, 'admin'])->name('admin.dashboard');
    });

    Route::middleware(['role:moderator'])->group(function () {
        Route::get('/moderator/dashboard', [DashboardController::class, 'moderator'])->name('moderator.dashboard');
    });

    Route::middleware(['role:hr'])->group(function () {
        Route::get('/hr/dashboard', [DashboardController::class, 'hr'])->name('hr.dashboard');
    });

    Route::middleware(['role:payroll'])->group(function () {
        Route::get('/payroll/dashboard', [DashboardController::class, 'payroll'])->name('payroll.dashboard');
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('tasks', TaskController::class);
});

// Roles routes without additional restrictions
Route::middleware(['auth'])->group(function () {
    Route::resource('admin/roles', RoleController::class)->names('admin.roles');
});

// Routes for Super Admin
Route::middleware(['auth', 'role:super-admin'])->group(function () {
    Route::get('/completion-records', [CompletionRecordController::class, 'index'])->name('completion-records.index');
    Route::get('/completion-records/{record}', [CompletionRecordController::class, 'show'])->name('completion-records.show');
    Route::delete('/completion-records/{record}', [CompletionRecordController::class, 'destroy'])->name('completion-records.destroy');
    Route::post('/calculate-payroll', [PayrollController::class, 'calculatePayroll'])->name('calculate.payroll');
    Route::get('/payroll/report', [PayrollController::class, 'report'])->name('payroll.report');
});

// Routes for Administrator
Route::middleware(['auth', 'role:administrator'])->prefix('admin')->group(function () {
    Route::get('/completion-records', [CompletionRecordController::class, 'index'])->name('admin.completion-records.index');
    Route::get('/completion-records/{record}', [CompletionRecordController::class, 'show'])->name('admin.completion-records.show');
    Route::delete('/completion-records/{record}', [CompletionRecordController::class, 'destroy'])->name('admin.completion-records.destroy');
});

// Routes for Moderator
Route::middleware(['auth', 'role:moderator'])->prefix('moderator')->group(function () {
    Route::get('/completion-records', [CompletionRecordController::class, 'index'])->name('moderator.completion-records.index');
    Route::get('/completion-records/{record}', [CompletionRecordController::class, 'show'])->name('moderator.completion-records.show');
    Route::delete('/completion-records/{record}', [CompletionRecordController::class, 'destroy'])->name('moderator.completion-records.destroy');
});

Route::post('/notifications/mark-as-read', function() {
    auth()->user()->unreadNotifications->markAsRead();
    return back()->with('success', 'All notifications marked as read');
})->name('notifications.markAsRead');

Route::post('/notifications/mark-all-as-read', function() {
    auth()->user()->unreadNotifications->markAsRead();
    return back()->with('success', 'All notifications marked as read');
})->name('notifications.markAllAsRead');

// Task Management Routes
Route::middleware(['auth'])->group(function () {
    // Basic CRUD routes for tasks
    Route::resource('tasks', TaskController::class);
    
    // Task completion route
    Route::post('/tasks/{task}/complete', [TaskController::class, 'complete'])->name('tasks.complete');
    Route::get('/tasks/completion-records', [TaskController::class, 'completionRecords'])->name('tasks.completion-records');
    Route::delete('/tasks/completion-records/{record}', [TaskController::class, 'destroyCompletionRecord'])->name('tasks.completion-records.destroy');
});

require __DIR__.'/auth.php';
