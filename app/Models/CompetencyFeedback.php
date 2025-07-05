<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CompetencyFeedback extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table = 'competency_feedbacks';
    protected $fillable = [
        'essay_id',
        'competency_name',
        'score',
        'feedback_text',
    ];

    /**
     * Get the essay that owns the competency feedback.
     */
    public function essay(): BelongsTo
    {
        return $this->belongsTo(Essay::class);
    }
}
