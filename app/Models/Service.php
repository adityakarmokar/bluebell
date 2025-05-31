<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'service_icons',
        'service_banner',
        'service_details',
        'action_by',
        'status',
    ];

    public function serviceDocuments()
    {
        return $this->hasMany(ServiceDocument::class);
    }

    public function token()
    {
        return $this->hasMany(Token::class);
    }

}
