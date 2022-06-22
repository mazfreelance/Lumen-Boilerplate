<?php

namespace Database\Factories;

use App\Containers\v1\User\Enums\{UserStatus, UserVerifyStatus};
use App\Containers\v1\User\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    public function configure()
    {
        return $this->afterCreating(function (User $user) {
            $user->syncRoles('user');
        });
    }

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => Hash::make(config('app.seeders.developer.password')),
            'status' => UserStatus::Active(),
            'verify_status' => UserVerifyStatus::Yes(),
            'email_verified_at' => Carbon::now()
        ];
    }
}
