<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'phone',
        'phone_verified_at',
        'email',
        'email_verified_at',
        'pan_no',
        'dob',
        'father_name',
        'adhar_number',
        'address',
        'image',
        'otp',
        'otp_expires_at',
        'user_token',
        'password',
        'action_by',
        'status',
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
        'phone_verified_at' => 'datetime',
      	'otp_expires_at' => 'datetime',
    ];

    public function userBankAccountDetail()
    {
        return $this->hasMany(UserBankAccountDetail::class);
    }

    public function userDocuments()
    {
        return $this->hasOne(UserDocument::class);
    }

    public function ca_tokens()
    {
        return $this->hasMany(Token::class);
    }

    public function userAddress()
    {
        return $this->hasOne(UserAddress::class);
    }

    public function userLedger()
    {
        return $this->hasMany(Payment::class, 'user_id', 'id');
    }
  
  	public function latestUserBankAccountDetail()
    {
      return $this->hasOne(UserBankAccountDetail::class)->latestOfMany();
    }
    
    
}
