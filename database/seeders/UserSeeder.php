<?php

namespace Database\Seeders;

use App\Containers\v1\User\Enums\{UserStatus, UserVerifyStatus};
use App\Containers\v1\User\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();


        $now = Carbon::now();
        $usersData = [
            collect([
                'name' => config('app.seeders.admin.name'),
                'password' => Hash::make(config('app.seeders.admin.password')),
                'email' => config('app.seeders.admin.email'),
                'status' => UserStatus::Active,
                'verify_status' => UserVerifyStatus::Yes,
                'roles' => ['admin'],
                'created_at' => $now,
                'updated_at' => $now
            ])
        ];

        foreach ($usersData as $userData) {
            $data = $userData->only('email')->toArray();
            $updateData = $userData->except('email', 'roles')->toArray();

            $user = User::updateOrCreate($data, $updateData);
            $user->syncRoles($userData->only('roles')->toArray());
        }
    }
}
