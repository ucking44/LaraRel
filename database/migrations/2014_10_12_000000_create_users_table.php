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
            $table->string('full_name');
            $table->string('contact_no');
            $table->string('username');
            $table->bigInteger('account_category')->default(1)->nullable();
            $table->bigInteger('account_status')->default(1)->nullable();
            $table->string('email_address')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('userpassword')->nullable();
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
