<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Attendance extends Model
{
    protected $guarded = [];

    protected $casts = [
        'service_date' => 'date',
    ];

    /**
     * Automatically normalize service_date to Y-m-d to prevent format mismatches.
     */
    public function setServiceDateAttribute($value)
    {
        $this->attributes['service_date'] = Carbon::parse($value)->toDateString();
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }
}
