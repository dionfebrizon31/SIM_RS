<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;
    protected $guard = 'users';  
    // protected $with = ['jabatans'];
    

    public function Jabatans(): BelongsTo
    {
        return $this->belongsTo(Jabatans::class);
    }
    public function Cutis(): BelongsTo
    {
        return $this->belongsTo(Cuti::class);
    }



}
