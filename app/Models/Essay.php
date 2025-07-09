<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Essay extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'title',
        'content',
        'overall_score',
        'status',
        'ia_feedback',
        'analyzed_at',
    ];

    /**
     * Get the user that owns the essay.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the competency feedbacks for the essay.
     */
    public function competencyFeedbacks(): HasMany
    {
        return $this->hasMany(CompetencyFeedback::class);
    }

    /**
     * Get the interventions for the essay.
     */
    public function interventions(): HasMany
    {
        return $this->hasMany(Intervention::class);
    }
}

