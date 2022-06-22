<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now();
        $rolesData = [
            [
                'name' => 'admin',
                'guard_name' => 'api',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'developer',
                'guard_name' => 'api',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'user',
                'guard_name' => 'api',
                'created_at' => $now,
                'updated_at' => $now
            ]
        ];

        Schema::disableForeignKeyConstraints();

        $rolesData = collect($rolesData);
        $rolesData->each(function ($roleData) {
            $data = [
                'name' => $roleData['name'],
                'guard_name' => $roleData['guard_name']
            ];
            $timestamps = [
                'created_at' => $roleData['created_at'],
                'updated_at' => $roleData['updated_at']
            ];

            DB::table('roles')->updateOrInsert($data, $timestamps);
        });
    }
}
