<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
// use App\Notifications\ResetPasswordNotification;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $guarded = [];
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     *
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'username',
        'firstname',
        'lastname',
        'nickname',
        'nickname',
        'mobile1',
        'mobile2',
        'mobile3',
        'isVerified',
        'phone_number',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Vikas
    // public function sendPasswordResetNotification($token)
    // {
    //     $url = 'https://example.com/reset-password?token=' . $token;

    //     $this->notify(new ResetPasswordNotification($url));
    // }

    public function  userCalls()
    {
        return $this->hasMany(UserCallingDetails::class);
    }


    public function  follows()
    {
        return $this->belongsToMany(User::class, 'follows', 'user_id', 'following_user_id');
    }
}
