<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BusinessInforResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'business_name' => $this->business_name,
            'business_industry' => $this->business_industry,
            'existing_website' => $this->existing_website,
            'website_type' => $this->website_type,
            'website_feature' => $this->website_feature,
            'website_serives' => $this->website_serives,
            'website_color' => $this->website_color,
            'website_reference' => $this->website_reference,
            'website_content' => $this->website_content,
            'website_images' => $this->website_images,
            'website_estimated_budget' => $this->website_estimated_budget,
            'website_desired_launch_date' => $this->website_desired_launch_date,
            'notes' => $this->notes,
            'status' => $this->status,
            'PaymentRang' => $this->PaymentRang,
            // social media
            'social_media_ad' => $this->social_media_ad,
            'social_media_paid_ad' => $this->social_media_paid_ad,
            'social_media_budget_ad' => $this->social_media_budget_ad,
            'social_media_perfer_ad_type' => $this->social_media_perfer_ad_type,
            'social_media_perfer_reporting_frequence' => $this->social_media_perfer_reporting_frequence,
            'social_media_ad_track_keywords' => $this->social_media_ad_track_keywords,
            // seo 
            'seo_keyword' => $this->seo_keyword,
            'seo_primary_goal' => $this->seo_primary_goal,
            'seo_target_audience' => $this->seo_target_audience,
            'seo_target_loaction' => $this->seo_target_loaction,
            'seo_competitor_website' => $this->seo_competitor_website,
            'seo_list_of_keywords' => $this->seo_list_of_keywords,
            'seo_keywords_main' => $this->seo_keywords_main,

            // graphic design
            'graphical_referrence_image' => $this->graphical_referrence_image,
            'graphical_design_perferr_color' => $this->graphical_design_perferr_color,
            'graphical_design_text_context' => $this->graphical_design_text_context,
            'graphical_design_brand_guideliness' => $this->graphical_design_brand_guideliness,
            'graphical_design_images_asserts' => $this->graphical_design_images_asserts,
            'graphical_design_referce_design' => $this->graphical_design_referce_design,
            'graphical_design_file_formad' => $this->graphical_design_file_formad,
            'user_name' => $this->user ? $this->user->name : null,
            'user_role' => $this->user ? $this->user->role   : null,
            'user_email' => $this->user ? $this->user->email   : null,
            'created_at' => $this->created_at ? $this->created_at->format('D M d, Y h:i A') : "",
        ];
    }
}
