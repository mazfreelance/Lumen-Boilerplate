<?php

namespace App\Containers\v1\User\Models;

use App\Containers\v1\User\Enums\{UserOnlineStatus, UserStatus, UserVerifyStatus};
use App\Containers\v1\User\ModelFilters\UserFilter;
use App\Ship\Abstracts\Models\User as BaseUser;
use Database\Factories\UserFactory;
use EloquentFilter\Filterable;

class User extends BaseUser
{
    use Filterable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'email_verified_at',
        'verification_token',
        'status',
        'verify_status',
        'online_status',
        'last_login_at',
        'last_login_ip'
    ];


    protected $casts = [
        'email_verified_at' => 'datetime',
        'status' =>  UserStatus::class,
        'verify_status' => UserVerifyStatus::class,
        'online_status' => UserOnlineStatus::class
    ];

    public function modelFilter()
    {
        return $this->provideFilter(UserFilter::class);
    }

    protected static function newFactory()
    {
        return UserFactory::new();
    }
}
