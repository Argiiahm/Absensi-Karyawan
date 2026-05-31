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
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('employee')->after('password');
            $table->boolean('is_face_enrolled')->default(false)->after('role');
            $table->longText('face_descriptor')->nullable()->after('is_face_enrolled');
            $table->string('face_photo_path')->nullable()->after('face_descriptor');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'is_face_enrolled', 'face_descriptor', 'face_photo_path']);
        });
    }
};
