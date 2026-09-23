<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Hairstyle extends Model
{
    use HasFactory, SoftDeletes;

    public const UPDATED_AT = null;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
        'difficulty',
        'face_shape_ids',
        'hair_types',
        'tags',
        'recommended_combo_id',
        'views',
        'is_active',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'difficulty' => 'integer',
            'face_shape_ids' => 'array',
            'hair_types' => 'array',
            'tags' => 'array',
            'recommended_combo_id' => 'integer',
            'views' => 'integer',
            'is_active' => 'boolean',
            'created_at' => 'datetime',
        ];
    }

    /**
     * Recommended combo package to achieve this hairstyle.
     */
    public function recommendedCombo(): BelongsTo
    {
        return $this->belongsTo(Service::class, 'recommended_combo_id');
    }

    /**
     * Services required or associated with this hairstyle.
     */
    public function services(): BelongsToMany
    {
        return $this->belongsToMany(Service::class, 'hairstyle_service');
    }
}
