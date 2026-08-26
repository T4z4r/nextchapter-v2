<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->string('color_primary', 9)->nullable()->after('logo_path');
            $table->string('color_deep', 9)->nullable()->after('color_primary');
            $table->string('color_ink', 9)->nullable()->after('color_deep');
            $table->string('color_accent', 9)->nullable()->after('color_ink');
        });
    }

    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn(['color_primary', 'color_deep', 'color_ink', 'color_accent']);
        });
    }
};
