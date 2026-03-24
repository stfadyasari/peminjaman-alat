<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;

class ActivityLogController extends Controller
{
    public function index()
    {
        $logs = ActivityLog::with('user')->orderBy('created_at','desc')->paginate(50);
        return view('admin.activity_logs.index', compact('logs'));
    }
}
