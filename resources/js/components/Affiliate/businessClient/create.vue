<template>
    <div class="container">
        <div class="main-container">
            <router-link to="/client-affiliate" class="add-link">
                <div class="row1">
                    <i class="fas fa-arrow-left"></i>
                    <h3 class="heading">Show Affiliate Client</h3>
                </div>
            </router-link>

            <div class="row" style="margin-bottom: 5rem;">
                <div class="spinner2 d-flex justify-content-center" v-if="singleAgentLoading">
                    <div class="spinner-border" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
                <div class="col-md-12" v-else>
                    <div class="parent-accordion p-3 mb-3" id="parent-accordion">
                        <div class="row">
                            <div class="col-md-6 mb-3"><strong>Affiliate Lable</strong></div>
                            <div class="col-md-6 mb-3"><strong>Affiliate Data</strong></div>
                            <div class="col-md-6 mb-3" v-if="singleAgent && singleAgent.user_name">Affiliate Name</div>
                            <div class="col-md-6 mb-3" v-if="singleAgent && singleAgent.user_name">{{
                                singleAgent.user_name }}</div>
                            <div class="col-md-6 mb-3" v-if="singleAgent && singleAgent.user_email">Affiliate Email
                            </div>
                            <div class="col-md-6 mb-3" v-if="singleAgent && singleAgent.user_email">{{
                                singleAgent.user_email }}</div>
                            <div class="col-md-6 mb-3" v-if="singleAgent && singleAgent.name">Client Name</div>
                            <div class="col-md-6 mb-3" v-if="singleAgent && singleAgent.name">{{ singleAgent.name }}
                            </div>
                            <div class="col-md-6 mb-3" v-if="singleAgent && singleAgent.email">Client Email</div>
                            <div class="col-md-6 mb-3" v-if="singleAgent && singleAgent.email">{{ singleAgent.email }}
                            </div>
                            <div class="col-md-6 mb-3" v-if="singleAgent && singleAgent.business_name">Client Business
                                Name</div>
                            <div class="col-md-6 mb-3" v-if="singleAgent && singleAgent.business_name">{{
                                singleAgent.business_name }}</div>
                            <div class="col-md-6 mb-3" v-if="singleAgent && singleAgent.business_industry">Client
                                Business Industry</div>
                            <div class="col-md-6 mb-3" v-if="singleAgent && singleAgent.business_industry">{{
                                singleAgent.business_industry }}</div>
                            <div class="col-md-6 mb-3" v-if="singleAgent && singleAgent.existing_website">Client Website
                                Existing</div>
                            <div class="col-md-6 mb-3" v-if="singleAgent && singleAgent.existing_website">{{
                                singleAgent.existing_website }}</div>
                            <div class="col-md-6 mb-3" v-if="singleAgent && singleAgent.website_type">Client Website
                                Type</div>
                            <div class="col-md-6 mb-3" v-if="singleAgent && singleAgent.website_type">{{
                                singleAgent.website_type }}</div>
                            <div class="col-md-6 mb-3" v-if="singleAgent && singleAgent.website_feature">Client Website
                                Feature</div>
                            <div class="col-md-6 mb-3" v-if="singleAgent && singleAgent.website_feature">{{
                                singleAgent.website_feature }}</div>
                            <div class="col-md-6 mb-3" v-if="singleAgent && singleAgent.website_serives">Client Website
                                Serives</div>
                            <div class="col-md-6 mb-3" v-if="singleAgent && singleAgent.website_serives">{{
                                singleAgent.website_serives }}</div>
                            <div class="col-md-6 mb-3" v-if="singleAgent && singleAgent.website_color">Client Website
                                Color</div>
                            <div class="col-md-6 mb-3" v-if="singleAgent && singleAgent.website_color">{{
                                singleAgent.website_color }}</div>
                            <div class="col-md-6 mb-3" v-if="singleAgent && singleAgent.website_reference">Client
                                Website Reference</div>
                            <div class="col-md-6 mb-3" v-if="singleAgent && singleAgent.website_reference">{{
                                singleAgent.website_reference }}</div>
                            <div class="col-md-6 mb-3" v-if="singleAgent && singleAgent.website_content">Will They
                                provide content?</div>
                            <div class="col-md-6 mb-3" v-if="singleAgent && singleAgent.website_content">{{
                                singleAgent.website_content }}</div>
                            <div class="col-md-6 mb-3" v-if="singleAgent && singleAgent.website_images">Does They
                                provide images & videos?</div>
                            <div class="col-md-6 mb-3" v-if="singleAgent && singleAgent.website_images">{{
                                singleAgent.website_images }}</div>
                            <div class="col-md-6 mb-3" v-if="singleAgent && singleAgent.website_estimated_budget">Client
                                Website Estimated Budget</div>
                            <div class="col-md-6 mb-3" v-if="singleAgent && singleAgent.website_estimated_budget">{{
                                singleAgent.website_estimated_budget }}</div>
                            <div class="col-md-6 mb-3" v-if="singleAgent && singleAgent.website_desired_launch_date">
                                Client Website Desired Launch Date</div>
                            <div class="col-md-6 mb-3" v-if="singleAgent && singleAgent.website_desired_launch_date">{{
                                singleAgent.website_desired_launch_date }}</div>
                            <div class="col-md-6 mb-3" v-if="singleAgent && singleAgent.social_media_ad">Interested in
                                Social Media Ads ?</div>
                            <div class="col-md-6 mb-3" v-if="singleAgent && singleAgent.social_media_ad">{{
                                singleAgent.social_media_ad }}</div>
                            <div class="col-md-6 mb-3" v-if="singleAgent && singleAgent.social_media_paid_ad">Interested
                                in Paid Social Media Ads ?</div>
                            <div class="col-md-6 mb-3" v-if="singleAgent && singleAgent.social_media_paid_ad">{{
                                singleAgent.social_media_paid_ad }}</div>
                            <div class="col-md-6 mb-3" v-if="singleAgent && singleAgent.social_media_budget_ad">Budget
                                for Ads</div>
                            <div class="col-md-6 mb-3" v-if="singleAgent && singleAgent.social_media_budget_ad">{{
                                singleAgent.social_media_budget_ad }}</div>
                            <div class="col-md-6 mb-3" v-if="singleAgent && singleAgent.social_media_perfer_ad_type">
                                Preferred Ad Types</div>
                            <div class="col-md-6 mb-3" v-if="singleAgent && singleAgent.social_media_perfer_ad_type">{{
                                singleAgent.social_media_perfer_ad_type }}</div>
                            <div class="col-md-6 mb-3"
                                v-if="singleAgent && singleAgent.social_media_perfer_reporting_frequence">Preferred
                                Reporting Frequency</div>
                            <div class="col-md-6 mb-3"
                                v-if="singleAgent && singleAgent.social_media_perfer_reporting_frequence">{{
                                    singleAgent.social_media_perfer_reporting_frequence }}</div>
                            <div class="col-md-6 mb-3" v-if="singleAgent && singleAgent.social_media_ad_track_keywords">
                                Key Metrics to Track</div>
                            <div class="col-md-6 mb-3" v-if="singleAgent && singleAgent.social_media_ad_track_keywords">
                                {{ singleAgent.social_media_ad_track_keywords }}</div>
                            <div class="col-md-6 mb-3" v-if="singleAgent && singleAgent.seo_keyword">keywords</div>
                            <div class="col-md-6 mb-3" v-if="singleAgent && singleAgent.seo_keyword">{{
                                singleAgent.seo_keyword }}</div>
                            <div class="col-md-6 mb-3" v-if="singleAgent && singleAgent.seo_primary_goal">Primary SEO
                                Goa</div>
                            <div class="col-md-6 mb-3" v-if="singleAgent && singleAgent.seo_primary_goal">{{
                                singleAgent.seo_primary_goal }}</div>
                            <div class="col-md-6 mb-3" v-if="singleAgent && singleAgent.seo_target_audience">Target
                                Audience</div>
                            <div class="col-md-6 mb-3" v-if="singleAgent && singleAgent.seo_target_audience">{{
                                singleAgent.seo_target_audience }}</div>
                            <div class="col-md-6 mb-3" v-if="singleAgent && singleAgent.seo_target_loaction">Target
                                Locations</div>
                            <div class="col-md-6 mb-3" v-if="singleAgent && singleAgent.seo_target_loaction">{{
                                singleAgent.seo_target_loaction }}</div>
                            <div class="col-md-6 mb-3" v-if="singleAgent && singleAgent.seo_competitor_website">
                                Competitor Websites</div>
                            <div class="col-md-6 mb-3" v-if="singleAgent && singleAgent.seo_competitor_website">{{
                                singleAgent.seo_competitor_website }}</div>
                            <div class="col-md-6 mb-3" v-if="singleAgent && singleAgent.seo_list_of_keywords">Do They
                                have a list of keywords?</div>
                            <div class="col-md-6 mb-3" v-if="singleAgent && singleAgent.seo_list_of_keywords">{{
                                singleAgent.seo_list_of_keywords }}</div>
                            <div class="col-md-6 mb-3" v-if="singleAgent && singleAgent.seo_list_of_keywords">Do They
                                have a list of keywords?</div>
                            <div class="col-md-6 mb-3" v-if="singleAgent && singleAgent.seo_list_of_keywords">{{
                                singleAgent.seo_list_of_keywords }}</div>
                            <div class="col-md-6 mb-3" v-if="singleAgent && singleAgent.seo_keywords_main">Main Any have
                                keyword</div>
                            <div class="col-md-6 mb-3" v-if="singleAgent && singleAgent.seo_keywords_main">{{
                                singleAgent.seo_keywords_main }}</div>
                            <div class="col-md-6 mb-3" v-if="singleAgent && singleAgent.graphical_design_perferr_color">
                                Graphic Designing Preferred Colors</div>
                            <div class="col-md-6 mb-3" v-if="singleAgent && singleAgent.graphical_design_perferr_color">
                                {{ singleAgent.graphical_design_perferr_color }}</div>
                            <div class="col-md-6 mb-3"
                                v-if="singleAgent && singleAgent.graphical_design_brand_guideliness">Do They have brand
                                guidelines Us?</div>
                            <div class="col-md-6 mb-3"
                                v-if="singleAgent && singleAgent.graphical_design_brand_guideliness">{{
                                    singleAgent.graphical_design_brand_guideliness }}</div>
                            <div class="col-md-6 mb-3" v-if="singleAgent && singleAgent.graphical_design_text_context">
                                Will They Provide Text Content Us?</div>
                            <div class="col-md-6 mb-3" v-if="singleAgent && singleAgent.graphical_design_text_context">
                                {{ singleAgent.graphical_design_text_context }}</div>
                            <div class="col-md-6 mb-3"
                                v-if="singleAgent && singleAgent.graphical_design_images_asserts">Will They Provide
                                Images & Assets Us?</div>
                            <div class="col-md-6 mb-3"
                                v-if="singleAgent && singleAgent.graphical_design_images_asserts">{{
                                    singleAgent.graphical_design_images_asserts }}</div>
                            <div class="col-md-6 mb-3"
                                v-if="singleAgent && singleAgent.graphical_design_referce_design">Graphic Designing
                                Reference Designs</div>
                            <div class="col-md-6 mb-3"
                                v-if="singleAgent && singleAgent.graphical_design_referce_design">{{
                                    singleAgent.graphical_design_referce_design }}</div>
                            <div class="col-md-6 mb-3" v-if="singleAgent && singleAgent.graphical_design_file_formad">
                                Graphic Designing File Formats</div>
                            <div class="col-md-6 mb-3" v-if="singleAgent && singleAgent.graphical_design_file_formad">{{
                                singleAgent.graphical_design_file_formad }}</div>
                            <div class="col-md-6 mb-3" v-if="singleAgent && singleAgent.graphical_referrence_image">
                                Graphic Designing Image</div>
                            <div class="col-md-6 mb-3" v-if="singleAgent && singleAgent.graphical_referrence_image">
                                <!-- Image Thumbnail -->
                                <img :src="'/' + singleAgent.graphical_referrence_image" alt="Agent Image"
                                    style="width: 100%; cursor: pointer;"
                                    @click="showImage(singleAgent.graphical_referrence_image)">

                                <!-- Full-Screen Image Modal -->
                                <div v-if="isModalOpen" class="modal" @click="isModalOpen = false">
                                    <img :src="'/' + selectedImage" class="full-image">
                                </div>
                            </div>

                            <div class="col-md-6 mb-3" v-if="singleAgent && singleAgent.notes">Client Important Notes
                            </div>
                            <div class="col-md-6 mb-3" v-if="singleAgent && singleAgent.notes">{{ singleAgent.notes }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import { mapActions, mapState } from 'vuex';
export default {
    data() {
        return {
            isModalOpen: false,
            selectedImage: ''
        };
    },
    methods: {
        showImage(image) {
            this.selectedImage = image;
            this.isModalOpen = true;
        },
        ...mapActions('agent', ['fetchEditAffiliateClientAdmin']),
    },
    computed: {
        ...mapState('agent', ['singleAgent', 'singleAgentLoading']),
    },

    mounted() {
        this.fetchEditAffiliateClientAdmin(this.$route.params.id)
    }
};

</script>
<style scoped>
.modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.8);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 1000;
}

.full-image {
    max-width: 90%;
    max-height: 90%;
    border-radius: 10px;
}

.col-md-6 {
    border-bottom: 1px solid #626262;
}

.text {
    color: #626262 !important;
    font-size: 0.9rem;
    font-weight: 700;
}

.container {
    max-width: 1000px !important;
    margin: 1.5rem auto !important;
}

.main-container {
    margin: auto 6rem !important;
}

.save-btn {
    background: var(--viseTech);
    color: white !important;
    padding: 6px 15px;
    border-radius: 6px;
    margin-top: 1rem;
    margin-bottom: 3rem;
    margin-left: 0.3rem;
    border: none;
}

.save-btn:hover {
    background-color: var(--viseTechHover);
}

.save-btn::placeholder {
    background-color: var(--viseTechHover);
}

@media screen and (max-width: 600px) {
    .main-container {
        margin: auto 2rem !important;
    }
}
</style>