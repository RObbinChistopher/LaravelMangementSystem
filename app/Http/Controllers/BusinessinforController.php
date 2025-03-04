<?php

namespace App\Http\Controllers;

use App\Http\Resources\BusinessInforResource;
use App\Models\BusinessInformation;
use App\Traits\ImageUploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BusinessinforController extends Controller
{
    use ImageUploadTrait;
    public function createBusinessInfor(Request $request, string $id)
    {
        $business = new BusinessInformation();
        $business->user_id = $id;
        $business->name = $request->name;
        $business->email = $request->email;
        $business->phone = $request->phone;
        $business->business_name = $request->business_name;
        $business->business_industry = $request->business_industry;
        $business->existing_website = $request->existing_website;
        $business->website_type = $request->website_type;
        $business->website_feature = $request->website_feature;
        $business->website_service = $request->service;
        $business->website_color = $request->website_color;
        $business->website_reference = $request->website_reference;
        $business->website_content = $request->website_content;
        $business->website_images = $request->website_images;
        $business->website_estimated_budget = $request->website_estimated_budget;
        $business->website_desired_launch_date = $request->website_desired_launch_date;
        
        // soical media
        $business->social_media_ad = $request->social_media_ad;
        $business->social_media_paid_ad = $request->social_media_paid_ad;
        $business->social_media_budget_ad = $request->social_media_budget_ad;
        $business->social_media_perfer_ad_type = $request->social_media_perfer_ad_type;
        $business->social_media_perfer_reporting_frequence = $request->social_media_perfer_reporting_frequence;
        $business->social_media_ad_track_keywords = $request->social_media_ad_track_keywords;

        // seo
        $business->seo_keyword = $request->seo_keyword;
        $business->seo_primary_goal = $request->seo_primary_goal;
        $business->seo_target_audience = $request->seo_target_audience;
        $business->seo_target_loaction = $request->seo_target_loaction;
        $business->seo_competitor_website = $request->seo_competitor_website;
        $business->seo_list_of_keywords = $request->seo_list_of_keywords;
        $business->seo_keywords_main = $request->seo_keywords_main;
        
        // graphical design
        $business->graphical_design_perferr_color = $request->graphical_design_perferr_color;
        $business->graphical_design_text_context = $request->graphical_design_text_context;
        $business->graphical_design_brand_guideliness = $request->graphical_design_brand_guideliness;
        $business->graphical_design_images_asserts = $request->graphical_design_images_asserts;
        $business->graphical_design_referce_design = $request->graphical_design_referce_design;
        $business->graphical_design_file_formad = $request->graphical_design_file_formad;
        $business->graphical_design_dimensions_size = $request->graphical_design_dimensions_size;
        $image = $this->Uploadimage($request, 'profile', 'business_infor');
        $business->graphical_referrence_image = $image;
        $business->notes = $request->notes;
        $business->save();
        return response()->json(['success' => 'Business Create Successfully']);
    }

    public function showAllBusinessInformation()
    {
        $user = Auth::user();
        $business = BusinessInformation::paginate(10);
        return BusinessInforResource::collection($business);
    }
    public function showbusinessByagent()
    {
        $user = Auth::user();
        $business = BusinessInformation::where('user_id', $user->id)->paginate(10);
        return BusinessInforResource::collection($business);
    }

    public function editBusinessInformation(string $id)
    {
        $business = BusinessInformation::findOrFail($id);
        return new BusinessInforResource($business);
    }

    public function DeleteBusinessInformation(string $id)
    {
        $business = BusinessInformation::findOrFail($id);
        $business->delete();
        return response()->json(['success' => 'Business Delete Successfully']);
    }
    public function BusinessInformationSearch(Request $request)
    {
        $query = $request->input('query.query');

        $results = BusinessInformation::where('name', 'like', "%$query%")
            ->orWhere('email', 'like', "%$query%")
            ->orWhere('phone', 'like', "%$query%")
            ->limit(5)
            ->get();

        return BusinessInforResource::collection($results);
    }
    public function BusinessInformationPaymentStatus(Request $request, string $id)
    {
        $business = BusinessInformation::findOrFail($id);
        $business->status = $request->status;
        $business->PaymentRang = $request->PaymentRang;
        $business->save();
        return response()->json(['success' => 'Successfully Update']);
    }


    // user Client
    public function UserBusinessInformation()
    {
        $user = Auth::user();
        $business = BusinessInformation::where('user_id', $user->id)->paginate(10);
        return BusinessInforResource::collection($business);
    }
    public function UserBusinessPayemntstatus()
    {
        $user = Auth::user();
        $business = BusinessInformation::where('user_id', $user->id)
            ->where('status', 'pending')
            ->get();

        return BusinessInforResource::collection($business);
    }

    public function clientPaymentRange(Request $request)
    {
        $user = Auth::user();
        $businesses = BusinessInformation::where('user_id', $user->id)
            ->where('status', 'payed')
            ->get();
        $paymentRanges = [];

        foreach ($businesses as $business) {
            $paymentRange = $business->PaymentRang;
            $tier = null;
            $earnings = 0;
            $count = 0;

            if ($paymentRange < 350) {
                $tier = "Tier 1";
                $earnings = 6500;
            } elseif ($paymentRange >= 350 && $paymentRange < 650) {
                $tier = "Tier 2";
                $earnings = 10000;
            } elseif ($paymentRange >= 650 && $paymentRange < 1000) {
                $tier = "Tier 3";
                $earnings = 16500;
            } elseif ($paymentRange >= 1000 && $paymentRange < 1400) {
                $tier = "Tier 4";
                $earnings = 22500;
            } elseif ($paymentRange >= 1400) {
                $tier = "Tier 5";
                $earnings = round($paymentRange * 0.07, 2);
            }
            $paymentRanges[] = [
                'PaymentRang' => $paymentRange,
                'Tier' => $tier,
                'count' => $count,
            ];
        }

        return response()->json([
            'user_id' => $user->id,
            'businesses' => $paymentRanges,
        ]);
    }
    public function businessinformationforClient()
    {
        $business = BusinessInformation::where('status', 'pending')->count();
        return response()->json(data: $business);
    }
}
