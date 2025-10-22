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
        Schema::create('room_infos', function (Blueprint $table) {
            $table->id();

            $table->integer('admin_uid');

            $table->timestamps();
        });

        Schema::create('rooms', function (Blueprint $table) {
            $table->id();

            $table->integer('room_id');
            $table->string('room_name');
            $table->string('password');
            $table->boolean('is_private');

            $table->timestamps();

            $table->index('room_name');
        });

        Schema::create('user_rooms', function (Blueprint $table) {
            $table->id();

            $table->integer('user_id');
            $table->integer('room_id');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('room_infos');
        Schema::dropIfExists('rooms');
        Schema::dropIfExists('user_rooms');
    }
};
