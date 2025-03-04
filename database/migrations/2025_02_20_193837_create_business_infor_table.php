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
        Schema::create('business_infor', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('business_name')->nullable();
            $table->string('business_industry')->nullable();
            $table->string('existing_website')->nullable();
            $table->string('website_service')->nullable();
            $table->string('website_type')->nullable();
            $table->string('website_feature')->nullable();
            $table->string('website_color')->nullable();
            $table->string('website_reference')->nullable();
            $table->string('website_content')->nullable();
            $table->string('website_images')->nullable();
            $table->string('website_estimated_budget')->nullable();
            $table->string('website_desired_launch_date')->nullable();
            // social media
            $table->string('social_media_ad')->nullable();
            $table->string('social_media_paid_ad')->nullable();
            $table->string('social_media_budget_ad')->nullable();
            $table->string('social_media_perfer_ad_type')->nullable();
            $table->string('social_media_perfer_reporting_frequence')->nullable();
            $table->string('social_media_ad_track_keywords')->nullable();
            // Seo
            $table->string('seo_keyword')->nullable();
            $table->string('seo_primary_goal')->nullable();
            $table->string('seo_target_audience')->nullable();
            $table->string('seo_target_loaction')->nullable();
            $table->string('seo_competitor_website')->nullable();
            $table->string('seo_list_of_keywords')->nullable();
            $table->string('seo_keywords_main')->nullable();
            // graphical design
            $table->string('graphical_design_perferr_color')->nullable();
            $table->string('graphical_design_text_context')->nullable();
            $table->string('graphical_design_brand_guideliness')->nullable();
            $table->string('graphical_design_images_asserts')->nullable();
            $table->string('graphical_design_referce_design')->nullable();
            $table->string('graphical_design_file_formad')->nullable();
            $table->string('graphical_referrence_image')->nullable();
            $table->string('graphical_design_dimensions_size')->nullable();

            $table->longText('notes')->nullable();
            $table->enum('status', ['pending', 'payed'])->default('pending');
            $table->string('PaymentRang')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('business_infor');
    }
};
