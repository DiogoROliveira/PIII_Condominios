<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {

        Schema::create('roles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });


        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('email')->unique();
            $table->string('phone')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->unsignedInteger('role_id')->default(2);
            $table->rememberToken();
            $table->timestamps();

            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });

        DB::table('roles')->insert([
            ['name' => 'admin', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'user', 'created_at' => now(), 'updated_at' => now()]
        ]);

        DB::table('users')->insert([
            ['name' => 'Admin', 'email' => Crypt::encrypt('admin@example.com'), 'phone' => '1234567890',  'password' => '$2y$12$MT/QJ5bIf1hODwqAWbh/GuG/adIofFteSMvoSNI3y8eUc5MTnqAzW', 'role_id' => 1,  'created_at' => now(), 'updated_at' => now()],
            ['name' => 'User', 'email' => Crypt::encrypt('user@example.com'), 'phone' => '1234567891', 'password' => '$2y$12$hCN/YF3RSfZy6kGQTdJZLuJi4x2BiD220xx0KnJUu/lF5JhaDcD3m', 'role_id' => 2, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('roles');
    }
};
