<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserDocument extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'form_16_a',
        'annex_use',
        'form_16_parantal',
        'inv_lic_mf',
        'intrest_certificate',
        'public_investment',
        'bank_statement',
        'sales_purchase',
        'comment',  
        'action_by',
        'doc_type',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
