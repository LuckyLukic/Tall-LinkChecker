<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Link extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'url',
        'is_active',
        'is_follow',
    ];


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
