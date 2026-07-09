<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('faculty')->nullable()->after('phone');
            $table->string('study_program')->nullable()->after('faculty');
            $table->string('gender')->nullable()->after('study_program');
            $table->string('address')->nullable()->after('gender');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['faculty', 'study_program', 'gender', 'address']);
        });
    }
};
