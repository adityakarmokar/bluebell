<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
  
  	public function token()
    {
        return $this->belongsTo(Token::class);
    }

    public function userToken()
    {
        return $this->belongsTo(Token::class, 'token_id', 'id');
    }

}
