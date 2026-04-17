<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Loan extends Model
{
    protected $fillable = [
        'user_id',
        'device_id',
        'quantity',
        'start_date',
        'end_date',
        'status',
        'return_condition',
        'fine_amount',
        'payment_method',
        'note',
        'returned_at',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'returned_at' => 'datetime',
        'fine_amount' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function device()
    {
        return $this->belongsTo(Device::class);
    }

    public function calculateLateDays(?Carbon $referenceDate = null): int
    {
        if (!$this->end_date) {
            return 0;
        }

        $endDate = Carbon::parse($this->end_date)->startOfDay();
        $comparisonDate = ($referenceDate ?? $this->returned_at ?? now());

        if (!$comparisonDate instanceof Carbon) {
            $comparisonDate = Carbon::parse($comparisonDate);
        }

        $comparisonDate = $comparisonDate->copy()->startOfDay();

        if ($comparisonDate->lessThanOrEqualTo($endDate)) {
            return 0;
        }

        return $endDate->diffInDays($comparisonDate);
    }

    public function calculateAutomaticFineUnits(?Carbon $referenceDate = null): int
    {
        if (!$this->end_date) {
            return 0;
        }

        return max(1, $this->calculateLateDays($referenceDate));
    }

    public function calculateAutomaticFine(?Carbon $referenceDate = null): int
    {
        return $this->calculateAutomaticFineUnits($referenceDate) * 2000;
    }

    public function fineTypeLabel(): string
    {
        $note = strtolower((string) $this->note);

        if (str_contains($note, 'denda otomatis keterlambatan')) {
            return 'Otomatis Keterlambatan';
        }

        if (str_contains($note, 'denda manual kerusakan')) {
            return 'Denda Kerusakan';
        }

        if ((float) $this->fine_amount > 0) {
            return 'Denda Manual';
        }

        return 'Tanpa Denda';
    }

    public function paymentMethodLabel(): string
    {
        return match ($this->payment_method) {
            'tunai' => 'Tunai',
            'qris' => 'QRIS',
            'none' => 'Tidak Ada',
            default => '-',
        };
    }

    public function statusLabel(): string
    {
        if ($this->status === 'returned' && $this->payment_method === 'none') {
            return 'Belum Lunas';
        }

        return match ($this->status) {
            'approved' => 'Belum Lunas',
            'returned' => 'Lunas',
            'pending' => 'Pending',
            'rejected' => 'Ditolak',
            default => ucfirst((string) $this->status),
        };
    }

    public function statusBadgeClass(): string
    {
        if ($this->status === 'returned' && $this->payment_method === 'none') {
            return 'danger';
        }

        return match ($this->status) {
            'returned' => 'primary',
            'approved' => 'success',
            'pending' => 'warning',
            'rejected' => 'danger',
            default => 'secondary',
        };
    }
}
