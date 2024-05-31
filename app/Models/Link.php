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
        'domain_id',
        'url',
        'is_active',
        'is_follow',
        'http_status',
        'anchor_text',
        'link_position',
        'points_to_correct_domain',

    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }


    public function domain(): BelongsTo
    {
        return $this->belongsTo(Domain::class);
    }


}
