<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    public const CONDITION_BAIK = 'baik';
    public const CONDITION_RUSAK_RINGAN = 'rusak ringan';
    public const CONDITION_RUSAK_BERAT = 'rusak berat';
    public const RETURN_CONDITIONS = [
        self::CONDITION_BAIK => 'Baik',
        self::CONDITION_RUSAK_RINGAN => 'Rusak Ringan',
        self::CONDITION_RUSAK_BERAT => 'Rusak Berat',
        'hilang' => 'Hilang',
    ];

    protected $fillable = [
        'name',
        'stock',
        'good_stock',
        'minor_damage_stock',
        'major_damage_stock',
        'category_id',
        'condition',
        'status',
        'image',
    ];

    public static function conditionOptions(): array
    {
        return [
            self::CONDITION_BAIK => 'Baik',
            self::CONDITION_RUSAK_RINGAN => 'Rusak Ringan',
            self::CONDITION_RUSAK_BERAT => 'Rusak Berat',
        ];
    }

    public static function returnConditionOptions(): array
    {
        return self::RETURN_CONDITIONS;
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function loans()
    {
        return $this->hasMany(Loan::class);
    }

    public function scopeWithActiveLoansCount($query)
    {
        return $query->withSum([
            'loans as active_loans_quantity' => function ($loanQuery) {
                $loanQuery->whereIn('status', ['pending', 'approved']);
            },
        ], 'quantity');
    }

    public function getTotalStockAttribute(): int
    {
        return (int) $this->good_stock + (int) $this->minor_damage_stock + (int) $this->major_damage_stock;
    }

    public function getAvailableStockAttribute(): int
    {
        if (array_key_exists('active_loans_quantity', $this->attributes)) {
            $activeLoansCount = (int) $this->attributes['active_loans_quantity'];
        } elseif ($this->exists) {
            $activeLoansCount = (int) $this->loans()->whereIn('status', ['pending', 'approved'])->sum('quantity');
        } else {
            $activeLoansCount = 0;
        }

        return max(0, (int) $this->good_stock - $activeLoansCount);
    }

    public function syncInventoryAttributes(): void
    {
        $this->stock = $this->total_stock;

        if ((int) $this->good_stock > 0) {
            $this->condition = self::CONDITION_BAIK;
        } elseif ((int) $this->minor_damage_stock > 0) {
            $this->condition = self::CONDITION_RUSAK_RINGAN;
        } elseif ((int) $this->major_damage_stock > 0) {
            $this->condition = self::CONDITION_RUSAK_BERAT;
        } else {
            $this->condition = null;
        }

        if (array_key_exists('active_loans_quantity', $this->attributes)) {
            $activeLoansCount = (int) $this->attributes['active_loans_quantity'];
        } elseif ($this->exists) {
            $activeLoansCount = (int) $this->loans()->whereIn('status', ['pending', 'approved'])->sum('quantity');
        } else {
            $activeLoansCount = 0;
        }

        if ($this->available_stock > 0) {
            $this->status = 'available';
        } elseif ($activeLoansCount > 0) {
            $this->status = 'borrowed';
        } else {
            $this->status = 'unavailable';
        }
    }

    public function refreshInventoryStatus(): void
    {
        $this->loadSum([
            'loans as active_loans_quantity' => function ($loanQuery) {
                $loanQuery->whereIn('status', ['pending', 'approved']);
            },
        ], 'quantity');

        $this->syncInventoryAttributes();
        $this->save();
    }

    public function applyReturnCondition(?string $condition, int $quantity = 1, bool $reverse = false): void
    {
        if (!$condition || $condition === self::CONDITION_BAIK) {
            return;
        }

        if ($reverse) {
            if ($condition === self::CONDITION_RUSAK_RINGAN) {
                $this->good_stock += $quantity;
                $this->minor_damage_stock = max(0, (int) $this->minor_damage_stock - $quantity);
            } elseif ($condition === self::CONDITION_RUSAK_BERAT) {
                $this->good_stock += $quantity;
                $this->major_damage_stock = max(0, (int) $this->major_damage_stock - $quantity);
            } elseif ($condition === 'hilang') {
                $this->good_stock += $quantity;
            }

            return;
        }

        if ($condition === self::CONDITION_RUSAK_RINGAN) {
            $this->good_stock = max(0, (int) $this->good_stock - $quantity);
            $this->minor_damage_stock += $quantity;
        } elseif ($condition === self::CONDITION_RUSAK_BERAT) {
            $this->good_stock = max(0, (int) $this->good_stock - $quantity);
            $this->major_damage_stock += $quantity;
        } elseif ($condition === 'hilang') {
            $this->good_stock = max(0, (int) $this->good_stock - $quantity);
        }
    }
}
