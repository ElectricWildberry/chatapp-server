<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class UserProfile extends Model
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'profile_name',
        'comment',
        'color_primary',
        'color_secondary',
    ];
    
    /**
     * The attributes that should be changed into dates.
     *
     * @var list<string>
     */
    protected $dates = [
        'created_at',
        'updated_at',
    ];
}
