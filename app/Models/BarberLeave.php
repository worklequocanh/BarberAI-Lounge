<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BarberLeave extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'barber_id',
        'leave_date',
        'reason',
        'status',
        'created_at',
    ];

    protected function casts(): array
    {
        return [
            'leave_date' => 'date',
            'created_at' => 'datetime',
        ];
    }

    public function barber(): BelongsTo
    {
        return $this->belongsTo(Barber::class);
    }
}
