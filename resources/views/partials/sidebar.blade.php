<aside id="sidebar" class="sidebar js-sidebar">
  <div class="sidebar-content js-simplebar">
    <a class="sidebar-brand" href="{{ route('dashboard') }}">
      <span class="align-middle">EPTS</span>
    </a>

    <ul class="sidebar-nav">
      <li class="sidebar-item">
        <a class="sidebar-link" href="{{ 
          Auth::user()->role->slug === 'super-admin' 
            ? route('super.dashboard') 
            : (Auth::user()->role->slug === 'administrator' 
              ? route('admin.dashboard') 
              : (Auth::user()->role->slug === 'moderator' 
                ? route('moderator.dashboard') 
                : (Auth::user()->role->slug === 'hr' 
                  ? route('hr.dashboard') 
                  : route('payroll.dashboard')))) 
        }}">
          <span class="align-middle">{{ __('Dashboard') }}</span>
        </a>
      </li>
      @if (Auth::check() && (Auth::user()->role->slug === 'super-admin' || Auth::user()->role->slug === 'administrator'))
        <li class="sidebar-header">{{ __('Users Management') }}</li>
        <li class="sidebar-item">
          <a class="sidebar-link" href="{{ Auth::user()->role->slug === 'super-admin' ? route('user.index') : route('admin.users.index') }}">
            <span class="align-middle">{{ __('Manage Users') }}</span>
          </a>
        </li>
      @endif
      
      @if (Auth::check() && (Auth::user()->role->slug === 'super-admin'))
        <li class="sidebar-item">
          <a class="sidebar-link" href="{{ route('roles.index') }}">
            <span class="align-middle">{{ __('Manage Roles') }}</span>
          </a>
        </li>
      @endif
      
      @if(Auth::check() && (Auth::user()->role->slug === 'super-admin' || Auth::user()->role->slug === 'administrator' || Auth::user()->role->slug === 'moderator'))
        <li class="sidebar-header">{{ __('Task Management') }}</li>
        <li class="sidebar-item">
          <a class="sidebar-link" href="{{ Auth::user()->role->slug === 'super-admin' ? route('tasks.index') : (Auth::user()->role->slug === 'administrator' ? route('admin.tasks.index') : route('moderator.tasks.index') ) }}">
            <span class="align-middle">{{ __('Manage Tasks') }}</span>
          </a>
        </li>

        <li class="sidebar-item">
          <a class="sidebar-link" href="{{ Auth::user()->role->slug === 'super-admin' ? route('completion-records.index') : (Auth::user()->role->slug === 'administrator' ? route('admin.completion-records.index') : route('moderator.completion-records.index')) }}">
            <span class="align-middle">{{ __('Completion Records') }}</span>
          </a>
        </li>
      @endif

      @if (Auth::check() && (Auth::user()->role->slug === 'super-admin' || Auth::user()->role->slug === 'administrator' || Auth::user()->role->slug === 'hr-manager'))
        <li class="sidebar-header">{{ __('Employee Management') }}</li>
        <li class="sidebar-item">
          <a class="sidebar-link" href="{{ Auth::user()->role->slug === 'super-admin' ? route('employee.index') : (Auth::user()->role->slug === 'administrator' ? route('admin.employee.index') : route('hr.employee.index') ) }}">
            <span class="align-middle">{{ __('Manage Employees') }}</span>
          </a>
        </li>

        <li class="sidebar-item">
          <a class="sidebar-link" href="{{ Auth::user()->role->slug === 'super-admin' ? route('department.index') : (Auth::user()->role->slug === 'administrator' ? route('admin.department.index') : route('hr.department.index') ) }}">
            <span class="align-middle">{{ __('Manage Departments') }}</span>
          </a>
        </li>

        <li class="sidebar-item">
          <a class="sidebar-link" href="{{ Auth::user()->role->slug === 'super-admin' ? route('designation.index') : (Auth::user()->role->slug === 'administrator' ? route('admin.designation.index') : route('hr.designation.index') ) }}">
            <span class="align-middle">{{ __('Manage Designations') }}</span>
          </a>
        </li>
      @endif

      @if (Auth::check() && (Auth::user()->role->slug === 'super-admin' || Auth::user()->role->slug === 'administrator' || Auth::user()->role->slug === 'moderator'))
        <li class="sidebar-header">{{ __('Attendance') }}</li>
        <li class="sidebar-item">
          <a class="sidebar-link" href="{{ Auth::user()->role->slug === 'super-admin' ? route('schedule.index') : (Auth::user()->role->slug === 'administrator' ? route('admin.schedule.index') : route('moderator.schedule.index') ) }}">
            <span class="align-middle">{{ __('Schedule') }}</span>
          </a>
        </li>

        <li class="sidebar-item">
          <a class="sidebar-link" href="{{ Auth::user()->role->slug === 'super-admin' ? route('attendance.index') : (Auth::user()->role->slug === 'administrator' ? route('admin.attendance.index') : route('moderator.attendance.index') ) }}">
            <span class="align-middle">{{ __('Daily Attendance') }}</span>
          </a>
        </li>

        <li class="sidebar-item">
          <a class="sidebar-link" href="{{ Auth::user()->role->slug === 'super-admin' ? route('sheet.report') : (Auth::user()->role->slug === 'administrator' ? route('admin.sheet.report') : route('moderator.sheet.report') ) }}">
            <span class="align-middle">{{ __('Sheet Report') }}</span>
          </a>
        </li>
      @endif
      
      @if (Auth::check() && (Auth::user()->role->slug === 'super-admin' || Auth::user()->role->slug === 'administrator' || Auth::user()->role->slug === 'hr-manager'))
        <li class="sidebar-header">{{ __('Leave Management') }}</li>
        <li class="sidebar-item">
          <a class="sidebar-link" href="{{ Auth::user()->role->slug === 'super-admin' ? route('leaves.index') : (Auth::user()->role->slug === 'administrator' ? route('admin.leaves.index') : route('hr.leaves.index') ) }}">
            <span class="align-middle">{{ __('Manage Leaves') }}</span>
          </a>
        </li>

        <li class="sidebar-item">
          <a class="sidebar-link" href="{{ Auth::user()->role->slug === 'super-admin' ? route('leaves.create') : (Auth::user()->role->slug === 'administrator' ? route('admin.leaves.create') : route('hr.leaves.create') ) }}">
            <span class="align-middle">{{ __('Registration') }}</span>
          </a>
        </li>
      @endif
      
      @if (Auth::check() && (Auth::user()->role->slug === 'super-admin' || Auth::user()->role->slug === 'administrator' || Auth::user()->role->slug === 'payroll-manager'))
        <li class="sidebar-header">{{ __('Payroll System') }}</li>
        <li class="sidebar-item">
          <a class="sidebar-link" href="{{ Auth::user()->role->slug === 'super-admin' ? route('payroll.index') : (Auth::user()->role->slug === 'administrator' ? route('admin.payroll.index') : route('manager.payroll.index') ) }}">
            <span class="align-middle">{{ __('Manage Payroll') }}</span>
          </a>
        </li>
       
        <li class="sidebar-item">
          <a class="sidebar-link" href="{{ route('payroll.report') }}">
            <span class="align-middle">{{ __('Payroll Sheet') }}</span>
          </a>
        </li>
      @endif
    </ul>
  </div>
</aside>