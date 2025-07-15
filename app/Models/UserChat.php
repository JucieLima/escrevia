<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserChat extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'content',
        'role',
        'interaction_type',
        'context_data',
        'session_id',
    ];

    // Isso é VITAL para que o Laravel trate 'context_data' como um array/objeto PHP automaticamente.
    protected $casts = [
        'context_data' => 'array', // Ou 'object', dependendo de como você prefere acessar. 'array' é geralmente mais flexível.
    ];

}
