<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Patient extends Model
{
    protected $fillable = [
        'name',
        'address',
        'phone',
        'hospital_id',
    ];

    public function hospital(): BelongsTo
    {
        return $this->belongsTo(Hospital::class);
    }
}
