<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Barber extends Model
{
    use HasFactory, SoftDeletes;

    public const UPDATED_AT = null;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'bio',
        'experience_years',
        'specialties',
        'rating_avg',
        'total_reviews',
        'is_available',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'experience_years' => 'integer',
            'specialties' => 'array',
            'rating_avg' => 'decimal:2',
            'total_reviews' => 'integer',
            'is_available' => 'boolean',
            'created_at' => 'datetime',
        ];
    }

    /**
     * Associated user account.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Work schedules.
     */
    public function schedules(): HasMany
    {
        return $this->hasMany(BarberSchedule::class);
    }

    /**
     * Appointments assigned to this barber.
     */
    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class, 'barber_id');
    }

    /**
     * Reviews for this barber.
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class, 'barber_id');
    }
}
