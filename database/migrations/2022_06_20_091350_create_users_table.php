<?php

use App\Containers\v1\User\Enums\{UserOnlineStatus, UserStatus, UserVerifyStatus};
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->rememberToken();
            $table->unsignedSmallInteger('status')->default(UserStatus::Inactive)->comment('Refer UserStatus Enum');
            $table->unsignedSmallInteger('verify_status')->default(UserVerifyStatus::No)->comment('Refer UserVerifyStatus Enum');
            $table->unsignedSmallInteger('online_status')->default(UserOnlineStatus::Offline)->comment('Refer to UserOnlineStatus enum class');
            $table->ipAddress('last_login_ip')->nullable();
            $table->timestamp('last_login_at')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
