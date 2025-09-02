<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Hospital extends Model
{
    protected $fillable = [
        'name',
        'address',
        'email',
        'phone',
    ];

    public function patients(): HasMany
    {
        return $this->hasMany(Patient::class);
    }
}
