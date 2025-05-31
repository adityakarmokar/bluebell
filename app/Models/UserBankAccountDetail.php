<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserBankAccountDetail extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'bank_name',
        'account_no',
        'ifsc',
        'branch',
        'income_tax_password',
        'action_by',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
