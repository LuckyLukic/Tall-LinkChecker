<?php

namespace App\Models;

use App\Models\User;
use App\Models\UserDetail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'street',
        'city',
        'province',
        'postal_code',
        'country',
    ];

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function userDetails(): HasMany
    {
        return $this->hasMany(UserDetail::class, 'billing_address_id');
    }


}
