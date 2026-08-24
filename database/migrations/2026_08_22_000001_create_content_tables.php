<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('site_name')->default('Next Chapter');
            $table->string('logo_path')->nullable();
            $table->string('footer_logo_path')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('contact_email')->nullable();
            $table->string('opening_hours')->nullable();
            $table->string('location')->nullable();
            $table->text('disclaimer_bar_text')->nullable();
            $table->text('footer_blurb')->nullable();
            $table->string('copyright_holder')->nullable();
            $table->string('legal_footnote')->nullable();
            $table->timestamps();
        });

        Schema::create('sections', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->string('name'); // admin-friendly label
            $table->string('eyebrow')->nullable();
            $table->text('heading')->nullable();
            $table->text('subheading')->nullable();
            $table->text('body')->nullable();
            $table->string('cta1_label')->nullable();
            $table->string('cta1_url')->nullable();
            $table->string('cta2_label')->nullable();
            $table->string('cta2_url')->nullable();
            $table->string('video_url')->nullable();
            $table->json('data')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('steps', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('sort')->default(0);
            $table->string('num_label');
            $table->string('title');
            $table->text('description')->nullable();
            $table->text('bullets')->nullable();   // one per line
            $table->text('footnote')->nullable();
            $table->string('style', 20)->default('normal'); // normal | highlight
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('platform_features', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('sort')->default(0);
            $table->string('type', 20)->default('feature'); // lead | feature | pair
            $table->string('pip')->nullable();       // e.g. "The USP"
            $table->string('tag')->nullable();       // e.g. "Settlement engine"
            $table->string('icon')->nullable();
            $table->string('title');
            $table->text('description')->nullable();
            $table->text('bullets')->nullable();
            $table->string('visual', 30)->nullable(); // scenarios | projection | none
            $table->string('kicker')->nullable();    // small caption under visual
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('tutorials', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('sort')->default(0);
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('duration', 12)->nullable();
            $table->boolean('is_locked')->default(true);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('sort')->default(0);
            $table->string('slug')->unique();
            $table->string('tier_label');           // Tier 1 · Standard
            $table->string('name');                 // DIY Financial Navigator
            $table->string('duration_label')->nullable();
            $table->decimal('price_ind', 10, 2)->default(0);
            $table->decimal('price_joint', 10, 2)->default(0);
            $table->text('sub_ind')->nullable();
            $table->text('sub_joint')->nullable();
            $table->text('features')->nullable();   // one per line
            $table->string('badge')->nullable();    // Most popular
            $table->boolean('featured')->default(false);
            $table->string('cta_label')->default('Choose');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('addons', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('sort')->default(0);
            $table->string('name');
            $table->text('description');
            $table->decimal('price_ind', 10, 2)->default(0);
            $table->decimal('price_joint', 10, 2)->nullable();
            $table->string('price_suffix')->nullable(); // per session / per hour ...
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('values', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('sort')->default(0);
            $table->string('icon')->nullable();
            $table->string('title');
            $table->text('description');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('faqs', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('sort')->default(0);
            $table->string('question');
            $table->text('answer');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('contact_messages', function (Blueprint $table) {
            $table->id();
            $table->string('type', 20)->default('enquiry'); // enquiry | checkout
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone', 40)->nullable();
            $table->string('package_interest')->nullable();
            $table->string('billing_mode', 20)->nullable(); // individual | joint
            $table->text('message')->nullable();
            $table->boolean('is_read')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contact_messages');
        Schema::dropIfExists('faqs');
        Schema::dropIfExists('values');
        Schema::dropIfExists('addons');
        Schema::dropIfExists('plans');
        Schema::dropIfExists('tutorials');
        Schema::dropIfExists('platform_features');
        Schema::dropIfExists('steps');
        Schema::dropIfExists('sections');
        Schema::dropIfExists('settings');
    }
};
