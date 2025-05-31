<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Token extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tokenDocument()
    {
        return $this->hasOne(TokenDocument::class);
    }

    public function tokenStatus()
    {
        return $this->hasMany(TokenStatus::class);
    }
  
  	protected $cast = [
      'updated_at' => 'datetime'
    ];
  
  	protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d');
    }
  
  	public function payment()
    {
    	return $this->hasOne(Payment::class);
    }

}
