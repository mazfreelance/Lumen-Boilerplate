<?php

namespace App\Containers\v1\Authentication\Models;

use App\Ship\Abstracts\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PasswordReset extends Model
{
    use HasFactory;

    protected $fillable = ['email', 'token', 'expired_at'];
}
