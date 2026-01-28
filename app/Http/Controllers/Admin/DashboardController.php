<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
        date_default_timezone_set('Asia/Jakarta');
    }
    
    public function dashboard()
    {
        return view('Admin.Dashboard.dashboard', [
            'title' => 'Dashboard',
        ]);
    }
}
