<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Services\ActivityLogPdfService;
use Illuminate\Support\Str;

class ActivityLogController extends Controller
{
    public function __construct(
        protected ActivityLogPdfService $pdfService
    ) {
    }

    public function index()
    {
        $logs = ActivityLog::with('user')->orderBy('created_at','desc')->paginate(50);
        return view('admin.activity_logs.index', compact('logs'));
    }

    public function exportPdf()
    {
        $logs = ActivityLog::with('user')->orderBy('created_at', 'desc')->get();
        $filename = 'laporan-log-aktivitas-'.now()->format('Ymd-His').'-'.Str::lower(Str::random(6)).'.pdf';
        $outputPath = storage_path('app/activity-logs/'.$filename);

        try {
            $this->pdfService->generate($logs, $outputPath);
        } catch (\Throwable $exception) {
            return redirect()
                ->route('admin.activity_logs.index')
                ->withErrors(['pdf' => 'PDF gagal dibuat. Pastikan Google Chrome atau Microsoft Edge tersedia di server.']);
        }

        return response()->download($outputPath, $filename)->deleteFileAfterSend(true);
    }
}
