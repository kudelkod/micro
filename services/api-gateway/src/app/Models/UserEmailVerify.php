<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserEmailVerify extends Model
{
    protected $table = 'users_email_verify';

    protected $fillable = [
        'user_id',
        'token',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
