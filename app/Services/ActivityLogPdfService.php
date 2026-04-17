<?php

namespace App\Services;

use Illuminate\Contracts\View\Factory as ViewFactory;
use Illuminate\Support\Collection;
use Symfony\Component\Process\Process;

class ActivityLogPdfService
{
    public function __construct(
        protected ViewFactory $view
    ) {
    }

    public function generate(Collection $logs, string $outputPath): void
    {
        $browserPath = $this->resolveBrowserPath();

        if (! $browserPath) {
            throw new \RuntimeException('Browser headless untuk generate PDF tidak ditemukan.');
        }

        $directory = dirname($outputPath);
        if (! is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        $profilePath = storage_path('app/activity-logs/browser-profile');
        if (! is_dir($profilePath)) {
            mkdir($profilePath, 0755, true);
        }

        $tempHtmlPath = $directory.'/'.pathinfo($outputPath, PATHINFO_FILENAME).'.html';

        file_put_contents($tempHtmlPath, $this->view->make('admin.activity_logs.pdf', [
            'logs' => $logs,
            'generatedAt' => now(),
        ])->render());

        $process = new Process([
            $browserPath,
            '--headless',
            '--disable-gpu',
            '--no-sandbox',
            '--disable-crash-reporter',
            '--no-first-run',
            '--user-data-dir='.$profilePath,
            '--allow-file-access-from-files',
            '--print-to-pdf='.$outputPath,
            $this->toFileUrl($tempHtmlPath),
        ]);

        $process->setTimeout(120);
        $process->run();

        @unlink($tempHtmlPath);

        if (! $process->isSuccessful() || ! file_exists($outputPath)) {
            throw new \RuntimeException('Gagal membuat file PDF log aktivitas.');
        }
    }

    protected function resolveBrowserPath(): ?string
    {
        $candidates = [
            'C:\Program Files\Google\Chrome\Application\chrome.exe',
            'C:\Program Files (x86)\Google\Chrome\Application\chrome.exe',
            'C:\Program Files (x86)\Microsoft\Edge\Application\msedge.exe',
            'C:\Program Files\Microsoft\Edge\Application\msedge.exe',
        ];

        foreach ($candidates as $candidate) {
            if (file_exists($candidate)) {
                return $candidate;
            }
        }

        return null;
    }

    protected function toFileUrl(string $path): string
    {
        return 'file:///'.str_replace('\\', '/', ltrim($path, '\\/'));
    }
}
