<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServiceDocument extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'service_id',
        'doc_icon',
        'doc_name',
        'action_by',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
