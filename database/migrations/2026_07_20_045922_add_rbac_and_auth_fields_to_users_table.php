<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('role_id')
                ->nullable()
                ->after('id')
                ->constrained('roles')
                ->restrictOnDelete();

            $table->string('username', 50)
                ->nullable()
                ->unique()
                ->after('name');

            $table->string('google_id')
                ->nullable()
                ->unique()
                ->after('email');

            $table->text('avatar')
                ->nullable()
                ->after('google_id');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['role_id']);

            $table->dropColumn([
                'role_id',
                'username',
                'google_id',
                'avatar',
            ]);
        });
    }
};
