<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'sender_user_id',
        'room_id',
        'content',
        'send_notification',
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
