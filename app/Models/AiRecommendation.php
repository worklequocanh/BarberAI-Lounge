<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AiRecommendation extends Model
{
    use HasFactory;

    public const UPDATED_AT = null;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'conversation_id',
        'user_id',
        'detected_face_shape',
        'hair_type',
        'hairstyle_ids',
        'services_ids',
        'ai_reason',
        'confidence_score',
        'image_uploaded',
        'feedback_rating',
        'feedback_note',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'hairstyle_ids' => 'array',
            'services_ids' => 'array',
            'confidence_score' => 'decimal:2',
            'feedback_rating' => 'integer',
            'created_at' => 'datetime',
        ];
    }

    /**
     * Conversation that produced this recommendation.
     */
    public function conversation(): BelongsTo
    {
        return $this->belongsTo(AiConversation::class, 'conversation_id');
    }

    /**
     * User who received the recommendation.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Appointments booked based on this recommendation.
     */
    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class, 'ai_recommendation_id');
    }
}
