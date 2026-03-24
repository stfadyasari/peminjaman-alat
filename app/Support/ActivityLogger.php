<?php

namespace App\Support;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

class ActivityLogger
{
    public static function log(string $action, ?string $details = null): void
    {
        try {
            ActivityLog::create([
                'user_id' => Auth::id(),
                'action' => $action,
                'details' => $details,
            ]);
        } catch (\Throwable $e) {
            // Keep business flow running even if log insert fails.
        }
    }
}
