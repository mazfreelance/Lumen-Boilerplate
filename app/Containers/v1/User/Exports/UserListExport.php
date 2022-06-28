<?php

namespace App\Containers\v1\User\Exports;

use App\Containers\v1\User\Models\User;
use Maatwebsite\Excel\Concerns\{FromQuery, WithHeadings, WithMapping};

class UserListExport implements FromQuery, WithMapping, WithHeadings
{
    private $filterData;

    public function __construct(array $filterData)
    {
        $this->filterData = $filterData;
    }

    public function query()
    {
        return User::filter($this->filterData)->latest();
    }

    public function map($user): array
    {
        return [
            $user->id,
            $user->name,
            $user->email,
            $user->verify_status ? $user->verify_status->description : null,
            $user->status ? $user->status->description : null,
            $user->last_login_ip,
            $user->last_login_at,
            $user->email_verified_at,
            $user->created_at,
            $user->updated_at
        ];
    }

    public function headings(): array
    {
        return [
            'User ID',
            'Name',
            'Email',
            'Email Status',
            'Status',
            'Last Login IP Address',
            'Last Login At',
            'Email Verified At',
            'Created At',
            'Updated At'
        ];
    }
}
