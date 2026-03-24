<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    protected $fillable = ['user_id','device_id','start_date','end_date','status','note','returned_at'];
    protected $casts = [
        'returned_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function device()
    {
        return $this->belongsTo(Device::class);
    }
}
