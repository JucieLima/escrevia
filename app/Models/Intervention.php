<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Intervention extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'essay_id',
        'user_id',
        'type',
        'message',
        'suggested_action',
    ];

    /**
     * Get the essay that the intervention belongs to.
     */
    public function essay(): BelongsTo
    {
        return $this->belongsTo(Essay::class);
    }

    /**
     * Get the user that the intervention belongs to.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

