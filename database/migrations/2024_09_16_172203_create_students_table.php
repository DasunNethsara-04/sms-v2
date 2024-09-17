<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use \App\Models\UserRole;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('gender');
            $table->string('nic')->unique()->nullable();
            $table->string('index_no')->unique()->nullable();
            $table->timestamps();
            $table->foreignId('user_id')->constrained('users');
            
            // $table->foreign('role_id')->references('id')->on('user_roles');
            // $table->foreignIdFor(UserRole::class, 'role_id')->constrained('user_role', 'id')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stundets');
    }
};
