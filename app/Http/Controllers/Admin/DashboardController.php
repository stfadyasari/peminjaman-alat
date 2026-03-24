<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Device;
use App\Models\Loan;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $totalDevices = Device::count();
        $totalLoans = Loan::count();
        $pendingLoans = Loan::where('status','pending')->count();

        return view('admin.dashboard', compact('totalUsers','totalDevices','totalLoans','pendingLoans'));
    }
}
