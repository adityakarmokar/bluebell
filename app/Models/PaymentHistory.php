<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentHistory extends Model
{
    use HasFactory;
  
  	protected $guarded = [];
  
  	public function user()
    {
    	return $this->belongsTo(User::class);
    }
  
  	public function token()
    {
    	return $this->belongsTo(Token::class);
    }
  
  	public function service()
    {
        return $this->belongsTo(Service::class)->withTrashed();
    }

  
}
