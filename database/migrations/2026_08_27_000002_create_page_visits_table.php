<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('page_visits', function (Blueprint $table) {
            $table->id();
            $table->string('path', 255)->index();
            $table->string('method', 10)->default('GET');
            $table->string('ip', 45)->nullable()->index();
            $table->string('user_agent', 255)->nullable();
            $table->string('referer', 255)->nullable();
            $table->timestamp('visited_at')->useCurrent();
            $table->index('visited_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('page_visits');
    }
};