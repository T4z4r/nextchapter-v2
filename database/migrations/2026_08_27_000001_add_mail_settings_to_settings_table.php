<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->string('mail_driver', 20)->nullable()->after('color_accent');
            $table->string('mail_host', 190)->nullable()->after('mail_driver');
            $table->string('mail_port', 10)->nullable()->after('mail_host');
            $table->string('mail_username', 190)->nullable()->after('mail_port');
            $table->string('mail_password', 300)->nullable()->after('mail_username');
            $table->string('mail_encryption', 10)->nullable()->after('mail_password');
            $table->string('mail_from_address', 190)->nullable()->after('mail_encryption');
            $table->string('mail_from_name', 190)->nullable()->after('mail_from_address');
        });
    }

    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn([
                'mail_driver', 'mail_host', 'mail_port', 'mail_username', 'mail_password',
                'mail_encryption', 'mail_from_address', 'mail_from_name',
            ]);
        });
    }
};