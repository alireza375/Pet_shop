<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('uuid', 64)->unique();
            $table->string('username')->index();
            $table->string('name')->index()->nullable();
            $table->string('email')->unique();
            $table->string('phone', 63)->nullable();
            $table->text('image')->nullable();
            $table->text('birthday')->nullable();
            $table->string('gender')->nullable();
            $table->tinyInteger('role')->comment('user = 1,admin = 3,trainer = 2')->default(USER);
            $table->tinyInteger('status')->comment('active = 1,inactive = 0')->default(INACTIVE);
            $table->boolean('is_mail_verified')->default(DISABLE);
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
