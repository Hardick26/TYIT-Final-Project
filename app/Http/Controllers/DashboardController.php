<?php

namespace App\Http\Controllers;

class DashboardController extends Controller
{
    public function superAdmin()
    {
        return view('dashboard.super-admin');
    }

    public function admin()
    {
        return view('dashboard.admin');
    }

    public function moderator()
    {
        return view('dashboard.moderator');
    }

    public function hr()
    {
        return view('dashboard.hr');
    }

    public function payroll()
    {
        return view('dashboard.payroll');
    }
} 