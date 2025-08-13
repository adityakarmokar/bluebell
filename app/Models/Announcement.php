<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Announcement extends Model
{
    use HasFactory;
  
  	protected $guarded = [];
  
  	protected $appends = ['updated_at_human'];
  
  	public function getUpdatedAtHumanAttribute(){
      return Carbon::parse($this->updated_at)->diffForHumans();
    }
}
