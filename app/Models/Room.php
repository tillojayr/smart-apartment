<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'owner_id',
        'tenant',
        'joined_at',
        'password',
        'bill',
        'volts',
        'current',
        'consumed',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function electricVariable(): HasMany
    {
        return $this->hasMany(ElectricVariable::class);
    }

    public function control(): HasOne
    {
        return $this->hasOne(Control::class);
    }
}
