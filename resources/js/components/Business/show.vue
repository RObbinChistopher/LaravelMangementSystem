<template>
    <div class="container">
        <div class="offset-md-1 parent-accordion p-3 login_page" id="parent-accordion" v-if="!businessInfor">
            <div class="p-3">
                <div class="visetech-caption">
                    <img class="logo" src="/Images/logo.png" alt="Vise Tech Logo" title="Vise Tech Logo" width="105px"
                        height="auto" />
                    <small style="font-size: smaller; margin-bottom: 1rem;">Your Success, Our Priority.</small>
                </div>
                <p class="heading mb-0" style="font-size: 20px; font-weight:700;">Personal & Business Details</p>
                <form @submit.prevent="CreateUsers" class="input-container">
                    <p class="mb-0 color-red" v-if="errormessage">{{ errormessage }}</p>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mt-2 mb-2">
                                <label for="exampleFormControlInput1" class="form-label text mb-0 font-size">Full
                                    Name *</label>
                                <input type="text" class="form-control" id="userName" v-model="from.name"
                                    :class="{ 'is-invalid': errors.includes('Your User Name Is Required') }"
                                    placeholder="Full Name">
                                <span v-if="errors.includes('Your User Name Is Required')" class="invalid-feedback">Your
                                    User Name Is Required</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mt-2 mb-2">
                                <label for="exampleFormControlInput1" class="form-label text mb-0 font-size">Email
                                    *</label>
                                <input type="text" class="form-control" id="email" v-model="from.email"
                                    :class="{ 'is-invalid': errors.includes('Your Email Is Required') }"
                                    placeholder="Email">
                                <span v-if="errors.includes('Your Email Is Required')" class="invalid-feedback">Your
                                    Email Is Required</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mt-2 mb-2">
                                <label for="exampleFormControlInput1" class="form-label text mb-0 font-size">Phone
                                    Number *</label>
                                <vue-tel-input v-model="from.phone" mode="international" placeholder="Enter Phone"
                                    class="flag-input"
                                    :class="{ 'is-invalid': errors.includes('Your Phone Number Is Required') }"></vue-tel-input>
                                <span v-if="errors.includes('Your Phone Number Is Required')"
                                    class="invalid-feedback">Your
                                    Phone Number Is Required</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mt-2 mb-2">
                                <label for="exampleFormControlInput1" class="form-label text mb-0 font-size">Business
                                    Name *</label>
                                <input type="text" class="form-control" id="email" v-model="from.business_name"
                                    :class="{ 'is-invalid': errors.includes('Your Business Name Is Required') }"
                                    placeholder="Business Name">
                                <span v-if="errors.includes('Your Business Name Is Required')"
                                    class="invalid-feedback">Your
                                    Business Name Is Required</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mt-2 mb-2">
                                <label for="exampleFormControlInput1" class="form-label text mb-0 font-size">Business
                                    Industry *</label>
                                <select class="form-select" v-model="from.business_industry"
                                    :class="{ 'is-invalid': errors.includes('Your Business Industry Is Required') }">
                                    <option value="Health Tech" selected>Health Tech</option>
                                    <option value="Education Tech">Education Tech</option>
                                    <option value="E-Commerce">E-Commerce</option>
                                    <option value="Fitness and Wellness">Fitness and Wellness</option>
                                    <option value="Food & Beverages">Food & Beverages</option>
                                    <option value="Insurance">Insurance</option>
                                    <option value="Spa & Beauty Saloon">Spa & Beauty Saloon</option>
                                    <option value="Articles & Blogs">Articles & Blogs</option>
                                    <option value="Roofing & Plumbing">Roofing & Plumbing</option>
                                    <option value="Auto Repair">Auto Repair</option>
                                    <option value="other">Other</option>
                                </select>
                                <span v-if="errors.includes('Your Business Industry Is Required')"
                                    class="invalid-feedback">Your
                                    Business Industry Is Required</span>
                            </div>
                        </div>
                        <div class="col-md-6" v-if="from.service === 'Web-Development'">
                            <div class="mt-2 mb-2">
                                <label for="exampleFormControlInput1" class="form-label text mb-0 font-size">Existing
                                    Website *</label>
                                <input type="text" class="form-control" id="email" v-model="from.existing_website"
                                    :class="{ 'is-invalid': errors.includes('Your Existing Website Is Required') }"
                                    placeholder="Existing Website">
                                <span v-if="errors.includes('Your Existing Website Is Required')"
                                    class="invalid-feedback">Your Existing Website Is Required</span>
                            </div>
                        </div>
                        <p class="heading mb-0 mt-3" style="font-size: 20px; font-weight:700;">Service You Need
                        </p>
                        <div class="col-md-6">
                            <div class="mt-2 mb-2">
                                <label class="form-label text mb-0 font-size">Services *</label>
                                <select class="form-select" v-model="from.service" @change="updateWebsiteTypes">
                                    <option value="Web-Development">Web Development</option>
                                    <option value="SMM">SMM (Social Media Marketing)</option>
                                    <option value="SEO">SEO (Search Engine Optimization)</option>
                                    <option value="Graphic Designing">Graphic Designing</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mt-2 mb-2">
                                <label class="form-label text mb-0 font-size">

                                    <span v-if="from.service === 'Web-Development'">Type of Website *</span>
                                    <span v-if="from.service === 'SMM'">Social Media Marketing Plans *</span>
                                    <span v-if="from.service === 'SEO'">SEO Plans*</span>
                                    <span v-if="from.service === 'Graphic Designing'">Select Required Plan *</span>

                                </label>
                                <select class="form-select" v-model="from.website_type" @change="updatePlans">
                                    <option v-for="type in filteredWebsiteTypes" :key="type.value" :value="type.value">
                                        {{ type.label }}
                                    </option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mt-2 mb-2">
                                <label class="form-label text mb-0 font-size">Choose a Plan *</label>
                                <select class="form-select" v-model="from.website_feature">
                                    <option v-for="plan in filteredPlans" :key="plan.value" :value="plan.value">
                                        {{ plan.label }}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <!-- Graphic Designing starting -->
                        <p class="heading mb-0 mt-3" v-if="from.service === 'Graphic Designing'"
                            style="font-size: 20px; font-weight:700;">Content & Materials
                        </p>
                        <div class="col-md-6" v-if="from.service === 'Graphic Designing'">
                            <div class="mt-2 mb-2">
                                <label for="exampleFormControlInput1" class="form-label text mb-0 font-size">Preferred
                                    Colors</label>
                                <input type="text" class="form-control" id="email"
                                    v-model="from.graphical_design_perferr_color" placeholder="Preferred Colors">
                            </div>
                        </div>
                        <div class="col-md-6" v-if="from.service === 'Graphic Designing'">
                            <div class="mt-2 mb-2">
                                <label class="form-label text mb-0 font-size">Do you have brand guidelines?</label>
                                <select class="form-select" v-model="from.graphical_design_brand_guideliness">
                                    <option value="Yes (please provide)">Yes (please provide)</option>
                                    <option value="No, need help">No, need help</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6" v-if="from.service === 'Graphic Designing'">
                            <div class="mt-2 mb-2">
                                <label class="form-label text mb-0 font-size">Will You Provide Text Content? *</label>
                                <select class="form-select" v-model="from.graphical_design_text_context"
                                    :class="{ 'is-invalid': errors.includes('Will You Provide Text Content') }">
                                    <option value="Yes">Yes</option>
                                    <option value="No, need help with copywriting">No, need help with copywriting
                                    </option>
                                </select>
                                <span v-if="errors.includes('Will You Provide Text Content')"
                                    class="invalid-feedback">Will You Provide Text Content</span>
                            </div>
                        </div>
                        <div class="col-md-6" v-if="from.service === 'Graphic Designing'">
                            <div class="mt-2 mb-2">
                                <label class="form-label text mb-0 font-size">Will You Provide Images & Assets?
                                    *</label>
                                <select class="form-select" v-model="from.graphical_design_images_asserts"
                                    :class="{ 'is-invalid': errors.includes('Will You Provide Images & Assets') }">
                                    <option value="Yes">Yes</option>
                                    <option value="No, need stock images">No, need stock images</option>
                                </select>
                                <span v-if="errors.includes('Will You Provide Images & Assets')"
                                    class="invalid-feedback">Will You Provide Images & Assets</span>
                            </div>
                        </div>
                        <div class="col-md-6" v-if="from.service === 'Graphic Designing'">
                            <div class="mt-2 mb-2">
                                <label for="exampleFormControlInput1" class="form-label text mb-0 font-size">Reference
                                    Designs (if any)</label>
                                <input type="text" class="form-control" id="email"
                                    v-model="from.graphical_design_referce_design"
                                    placeholder="Reference Designs (if any)">
                            </div>
                        </div>
                        <div class="col-md-6" v-if="from.service === 'Graphic Designing'">
                            <div class="mt-2 mb-2">
                                <label for="exampleFormControlInput1" class="form-label text mb-0 font-size">
                                    Reference Document/Image
                                </label>
                                <input type="file" class="form-control" @change="previewImage($event, 'profile')"
                                    accept="image/*" />
                                <img v-if="from.profilePreview" :src="from.profilePreview" class="img-preview"
                                    alt="Profile Preview" style="width: 100%;">
                            </div>
                        </div>
                        <p class="heading mb-0 mt-3" v-if="from.service === 'Graphic Designing'"
                            style="font-size: 20px; font-weight:700;">Deliverables & Format
                        </p>
                        <div class="col-md-6" v-if="from.service === 'Graphic Designing'">
                            <div class="mt-2 mb-2">
                                <label class="form-label text mb-0 font-size">Required File Formats *</label>
                                <select class="form-select" v-model="from.graphical_design_file_formad"
                                    :class="{ 'is-invalid': errors.includes('File Formats Is Required') }">
                                    <option value="JPEG/PNG">JPEG/PNG (For Web & Social Media)
                                    </option>
                                    <option value="PDF">PDF (For Print)</option>
                                    <option value="AI/PSD">AI/PSD (Source Files)</option>
                                </select>
                                <span v-if="errors.includes('File Formats Is Required')" class="invalid-feedback">File
                                    Formats Is Required</span>
                            </div>
                        </div>
                        <div class="col-md-6" v-if="from.service === 'Graphic Designing'">
                            <div class="mt-2 mb-2">
                                <label class="form-label text mb-0 font-size">Design Size/Dimensions</label>
                                <input type="text" class="form-control" id="email"
                                    v-model="from.graphical_design_dimensions_size"
                                    placeholder="Design Size/Dimensions">
                            </div>
                        </div>
                        <!-- Graphic Designing ending -->
                        <!-- SMM Service starting -->
                        <p class="heading mb-0 mt-3" v-if="from.service === 'SMM'"
                            style="font-size: 20px; font-weight:700;">Social Media Requirements
                        </p>
                        <div class="col-md-12" v-if="from.service === 'SMM'">
                            <div class="mt-2 mb-2">
                                <label for="exampleFormControlInput1" class="form-label text mb-0 font-size">Ads? any
                                    Layout</label>
                                <input type="text" class="form-control" id="email" v-model="from.social_media_ad"
                                    placeholder="Any keywords">
                            </div>
                        </div>
                        <p class="heading mb-0 mt-3" v-if="from.service === 'SMM'"
                            style="font-size: 20px; font-weight:700;">Advertising & Paid Campaigns
                        </p>
                        <div class="col-md-6" v-if="from.service === 'SMM'">
                            <div class="mt-2 mb-2">
                                <label class="form-label text mb-0 font-size">Interested in Paid Social Media
                                    Ads?</label>
                                <select class="form-select" v-model="from.social_media_paid_ad">
                                    <option value="Yes">Yes</option>
                                    <option value="No, need help">No, need help</option>
                                </select>
                            </div>
                        </div>
                        <!-- <div class="col-md-6" v-if="from.service === 'SMM'">
                            <div class="mt-2 mb-2">
                                <label for="exampleFormControlInput1" class="form-label text mb-0 font-size">Budget for
                                    Ads *</label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon1">$</span>
                                    <input type="text" class="form-control" placeholder="Estimated Budget"
                                        v-model="from.social_media_budget_ad"
                                        :class="{ 'is-invalid': errors.includes('Your Estimated Budget for Ads Is Required') }"
                                        aria-label="Username" aria-describedby="basic-addon1">
                                    <span v-if="errors.includes('Your Estimated Budget for Ads Is Required')"
                                        class="invalid-feedback">Your
                                        Estimated Budget for Ads Is Required</span>
                                </div>

                            </div>
                        </div> -->
                        <div class="col-md-6" v-if="from.service === 'SMM'">
                            <div class="mt-2 mb-2">
                                <label class="form-label text mb-0 font-size">Preferred Ad Types</label>
                                <select class="form-select" v-model="from.social_media_perfer_ad_type">
                                    <option value="Brand Awareness Ads">Brand Awareness Ads</option>
                                    <option value="Lead Generation Ads">Lead Generation Ads</option>
                                    <option value="Website Traffic Ads">Website Traffic Ads</option>
                                    <option value="Sales & Conversion Ads">Sales & Conversion Ads</option>
                                </select>
                            </div>
                        </div>
                        <p class="heading mb-0 mt-3" v-if="from.service === 'SMM'"
                            style="font-size: 20px; font-weight:700;">Performance Tracking & Reporting
                        </p>
                        <div class="col-md-6" v-if="from.service === 'SMM'">
                            <div class="mt-2 mb-2">
                                <label class="form-label text mb-0 font-size">Preferred Reporting Frequency</label>
                                <select class="form-select" v-model="from.social_media_perfer_reporting_frequence">
                                    <option value="Weekly">Weekly</option>
                                    <option value="Lead Generation Ads">Bi-Weekly</option>
                                    <option value="Monthly">Monthly</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6" v-if="from.service === 'SMM'">
                            <div class="mt-2 mb-2">
                                <label class="form-label text mb-0 font-size">Key Metrics to Track</label>
                                <select class="form-select" v-model="from.social_media_ad_track_keywords">
                                    <option value="Engagement Rate">Engagement Rate (Likes, Comments, Shares)</option>
                                    <option value="Follower Growth">Follower Growth</option>
                                    <option value="Website Clicks">Website Clicks</option>
                                    <option value="Lead & Sales Conversion">Lead & Sales Conversion</option>
                                </select>
                            </div>
                        </div>
                        <!-- SMM Service Ending -->
                        <!-- SEO Service starting -->
                        <p class="heading mb-0 mt-3" v-if="from.service === 'SEO'"
                            style="font-size: 20px; font-weight:700;">SEO Goals & Objectives
                        </p>
                        <div class="col-md-12" v-if="from.service === 'SEO'">
                            <div class="mt-2 mb-2">
                                <label for="exampleFormControlInput1" class="form-label text mb-0 font-size">keywords?
                                    any (if)</label>
                                <input type="text" class="form-control" id="email" v-model="from.seo_keyword"
                                    placeholder="Any keywords">
                            </div>
                        </div>
                        <div class="col-md-6" v-if="from.service === 'SEO'">
                            <div class="mt-2 mb-2">
                                <label for="exampleFormControlInput1" class="form-label text mb-0 font-size">Primary SEO
                                    Goal *</label>
                                <input type="text" class="form-control" id="email" v-model="from.seo_primary_goal"
                                    :class="{ 'is-invalid': errors.includes('Your Primary SEO Goal Is Required') }"
                                    placeholder="Primary SEO Goal">
                                <span v-if="errors.includes('Your Primary SEO Goal Is Required')"
                                    class="invalid-feedback">Your Primary SEO Goal Is Required</span>
                            </div>
                        </div>
                        <div class="col-md-6" v-if="from.service === 'SEO'">
                            <div class="mt-2 mb-2">
                                <label for="exampleFormControlInput1" class="form-label text mb-0 font-size">Target
                                    Audience *</label>
                                <input type="text" class="form-control" id="email" v-model="from.seo_target_audience"
                                    :class="{ 'is-invalid': errors.includes('Your Target Audience Is Required') }"
                                    placeholder="Target Audience">
                                <span v-if="errors.includes('Your Target Audience Is Required')"
                                    class="invalid-feedback">Your Target Audience Is Required</span>
                            </div>
                        </div>
                        <div class="col-md-6" v-if="from.service === 'SEO'">
                            <div class="mt-2 mb-2">
                                <label for="exampleFormControlInput1" class="form-label text mb-0 font-size">Target
                                    Locations (if applicable)</label>
                                <input type="text" class="form-control" id="email" v-model="from.seo_target_loaction"
                                    placeholder="Target Locations">
                            </div>
                        </div>
                        <div class="col-md-6" v-if="from.service === 'SEO'">
                            <div class="mt-2 mb-2">
                                <label for="exampleFormControlInput1" class="form-label text mb-0 font-size">Competitor
                                    Websites (if any)</label>
                                <input type="text" class="form-control" id="email" v-model="from.seo_competitor_website"
                                    placeholder="Competitor Websites">
                            </div>
                        </div>
                        <p class="heading mb-0 mt-3" v-if="from.service === 'SEO'"
                            style="font-size: 20px; font-weight:700;">Keyword Strategy
                        </p>
                        <div class="col-md-6" v-if="from.service === 'SEO'">
                            <div class="mt-2 mb-2">
                                <label class="form-label text mb-0 font-size">Do you have a list of keywords?</label>
                                <select class="form-select" v-model="from.seo_list_of_keywords">
                                    <option value="Yes">Yes</option>
                                    <option value="No, need help with keyword research">No, need help with keyword
                                        research</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6" v-if="from.service === 'SEO'">
                            <div class="mt-2 mb-2">
                                <label for="exampleFormControlInput1" class="form-label text mb-0 font-size">
                                    Main Keywords (if available)</label>
                                <input type="text" class="form-control" id="email" v-model="from.seo_keywords_main"
                                    placeholder="Main Keyworks">
                            </div>
                        </div>
                        <!-- SEO Service Ending -->
                        <!-- Web-Development Service starting -->
                        <p class="heading mb-0 mt-3" v-if="from.service === 'Web-Development'"
                            style="font-size: 20px; font-weight:700;">Design Preferences
                        </p>
                        <div class="col-md-6" v-if="from.service === 'Web-Development'">
                            <div class="mt-2 mb-2">
                                <label for="exampleFormControlInput1" class="form-label text mb-0 font-size">Preferred
                                    Colors (also color code) *</label>
                                <input type="text" class="form-control" id="email" v-model="from.website_color"
                                    :class="{ 'is-invalid': errors.includes('Your Preferred Colors Is Required') }"
                                    placeholder="Preferred Color(s)">
                                <span v-if="errors.includes('Your Preferred Colors Is Required')"
                                    class="invalid-feedback">Your Preferred Colors Is Required</span>
                            </div>
                        </div>
                        <div class="col-md-6" v-if="from.service === 'Web-Development'">
                            <div class="mt-2 mb-2">
                                <label for="exampleFormControlInput1" class="form-label text mb-0 font-size">Reference
                                    Websites *</label>
                                <input type="text" class="form-control" id="email" v-model="from.website_reference"
                                    :class="{ 'is-invalid': errors.includes('Your Reference Websites Is Required') }"
                                    placeholder="Reference Website">
                                <span v-if="errors.includes('Your Reference Websites Is Required')"
                                    class="invalid-feedback">Your Reference Websites Is Required</span>
                            </div>
                        </div>
                        <p class="heading mb-0 mt-3" v-if="from.service === 'Web-Development'"
                            style="font-size: 20px; font-weight:700;">Content & Media</p>
                        <div class="col-md-6" v-if="from.service === 'Web-Development'">
                            <div class="mt-2 mb-2">
                                <label for="exampleFormControlInput1" class="form-label text mb-0 font-size">Will
                                    you
                                    provide content? *</label>
                                <select class="form-select" aria-label="Default select example"
                                    v-model="from.website_content"
                                    :class="{ 'is-invalid': errors.includes('Your Content Information Is Required') }">
                                    <option value="No, need help">No, need help</option>
                                    <option value="Yes">Yes</option>
                                </select>
                                <span v-if="errors.includes('Your Content Information Is Required')"
                                    class="invalid-feedback">Your
                                    Content Information Is Required</span>
                            </div>
                        </div>
                        <div class="col-md-6" v-if="from.service === 'Web-Development'">
                            <div class="mt-2 mb-2">
                                <label for="exampleFormControlInput1" class="form-label text mb-0 font-size">Do you
                                    have
                                    images & videos? *</label>
                                <select class="form-select" aria-label="Default select example"
                                    v-model="from.website_images"
                                    :class="{ 'is-invalid': errors.includes('Your images & videos Question Is Required') }">
                                    <option value="No, need stock images" selected>No, need stock images</option>
                                    <option value="Yes">Yes</option>
                                </select>
                                <span v-if="errors.includes('Your images & videos Question Is Required')"
                                    class="invalid-feedback">Your images & videos Question Is Required</span>
                            </div>
                        </div>
                        <p class="heading mb-0 mt-3" style="font-size: 20px; font-weight:700;">Budget & Timeline</p>
                        <!-- Web-Development Service ending -->
                        <div class="col-md-6">
                            <div class="mt-2 mb-2">
                                <label for="exampleFormControlInput1" class="form-label text mb-0 font-size">Estimated
                                    Budget *</label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon1">$</span>
                                    <input type="text" class="form-control" placeholder="Estimated Budget"
                                        v-model="from.website_estimated_budget"
                                        :class="{ 'is-invalid': errors.includes('Your Estimated Budget Is Required') }"
                                        aria-label="Username" aria-describedby="basic-addon1">
                                    <span v-if="errors.includes('Your Estimated Budget Is Required')"
                                        class="invalid-feedback">Your
                                        Estimated Budget Is Required</span>
                                </div>

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mt-2 mb-2">
                                <label for="exampleFormControlInput1" class="form-label text mb-0 font-size">Desired
                                    Launch Date *</label>
                                <input type="date" class="form-control" id="email"
                                    :class="{ 'is-invalid': errors.includes('Your Desired Launch Date Is Required') }"
                                    v-model="from.website_desired_launch_date" placeholder="Desired Launch Date">
                                <span v-if="errors.includes('Your Desired Launch Date Is Required')"
                                    class="invalid-feedback">Your
                                    Desired Launch Date Is Required</span>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mt-2 mb-2">
                                <label for="exampleFormControlInput1" class="form-label text mb-0 font-size">Any
                                    specific requirements or notes</label>
                                <div class="form-floating">
                                    <textarea class="form-control" placeholder="Leave Your requirements here"
                                        id="floatingTextarea" v-model="from.notes"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button class="save-btn-login mt-3" :disabled="loading">
                        <span v-if="!loading">Submit and Relax</span>
                        <span v-else class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        <span class="visually-hidden">Loading...</span>
                    </button>
                </form>
            </div>
        </div>
        <div class="mb-3" style="text-align: center;" v-if="businessInfor">
            <img src="/Images/business.svg" style="width: 26%;" alt="">
            <p class="businessInfor">Thank you!</p>
            <p class="businessInfor">Your business information has been successfully submitted. We will get back to you
                momentarily</p>
            <router-link to="/sign-in" class="link-items">Don't forget to create an account! Sign up now.</router-link>
        </div>
    </div>
</template>
<script>
import config from "../../config";
import axios from "axios";
import { toast } from "vue3-toastify";
import { mapActions, mapState } from "vuex";
export default {
    data() {
        return {
            from: {
                name: "",
                email: "",
                phone: "",
                user_id: null,
                business_name: "",
                business_industry: "Health Tech",
                existing_website: "",
                website_type: "", // Default selection
                website_feature: "",
                website_color: "",
                website_reference: "",
                website_content: "No, need help",
                website_images: "Yes",
                website_estimated_budget: "",
                website_desired_launch_date: "",
                notes: "",
                service: "Web-Development",
                // social media
                social_media_ad: "",
                social_media_paid_ad: "Yes",
                social_media_budget_ad: "",
                social_media_perfer_ad_type: "Brand Awareness Ads",
                social_media_perfer_reporting_frequence: "Weekly",
                social_media_ad_track_keywords: "Engagement Rate",
                // seo 
                seo_keyword: "",
                seo_primary_goal: "",
                seo_target_audience: "",
                seo_target_loaction: "",
                seo_competitor_website: "",
                seo_list_of_keywords: "Yes",
                seo_keywords_main: "",
                // graphical design
                graphical_design_perferr_color: "",
                graphical_design_text_context: "Yes",
                graphical_design_brand_guideliness: "No, need help",
                graphical_design_images_asserts: "Yes",
                graphical_design_referce_design: "",
                graphical_design_file_formad: "JPEG/PNG",
                graphical_design_dimensions_size: "",
                profile: null,
                profilePreview: "",
            },
            errors: [],
            loading: false,
            businessInfor: false,
            serviceOptions: {
                "Web-Development": [
                    { value: "Basic-Website", label: "Basic Website" },
                    { value: "E-commerce-Store", label: "E-commerce Store" },
                    { value: "Portfolio-Creative", label: "Portfolio & Creative Website" },
                    { value: "Custom-Development", label: "Custom Development" },
                    { value: "CMS", label: "CMS (Content Management System)" },
                ],
                "SEO": [
                    { value: "Starter", label: "Starter" },
                    { value: "Intermediate", label: "Intermediate" },
                    { value: "Advanced", label: "Advanced" },
                    { value: "Specialized", label: "Specialized" },
                ],
                "SMM": [
                    { value: "Starter Plan", label: "Starter Plan" },
                    { value: "Intermediate Plan", label: "Intermediate Plan" },
                    { value: "Advanced Plan", label: "Advanced Plan" },
                    { value: "Specialized Plan", label: "Specialized Plan" },
                ],
                "Graphic Designing": [
                    { value: "Starter-Plan", label: "Starter" },
                    { value: "Intermediate-Plan", label: "Intermediate" },
                    { value: "Premium-Plan", label: "Premium" },
                    { value: "Custom-Plan", label: "Custom" },
                ],
            },
            plans: {
                "Basic-Website": [
                    { value: "Landing Page Website", label: "Landing Page Website" },
                    { value: "Professional Presence", label: "Professional Presence" }
                ],
                "E-commerce-Store": [
                    { value: "Online Store Starter", label: "Online Store Starter" },
                    { value: "Commerce Pro Plan", label: "Commerce Pro Plan" },
                    { value: "Shopify Success Suite", label: "Shopify Success Suite" },
                ],
                "Portfolio-Creative": [
                    { value: "Portfolio Pro", label: "Portfolio Pro" },
                    { value: "Creative Edge Suite", label: "Creative Edge Suite" }
                ],
                "Custom-Development": [
                    { value: "Custom Code Plan", label: "Custom Code Plan" },
                    { value: "Personalized Web Solutions", label: "Personalized Web Solutions" }
                ],
                "CMS": [
                    { value: "CMS Starter Plan", label: "CMS Starter Plan" },
                    { value: "Dynamic CMS Solution", label: "Dynamic CMS Solution" }
                ],
                "Starter": [
                    { value: "SEO Boost Basic", label: "SEO Boost Basic" },
                    { value: "Local Visibility Starter", label: "Local Visibility Starter" }
                ],
                "Intermediate": [
                    { value: "Growth SEO Pro", label: "Growth SEO Pro" },
                    { value: "Content Authority Plus", label: "Content Authority Plus" }
                ],
                "Advanced": [
                    { value: "SEO Dominance Elite", label: "SEO Dominance Elite" },
                    { value: "Enterprise SEO Mastery", label: "Enterprise SEO Mastery" }
                ],
                "Specialized": [
                    { value: "E-Commerce SEO Accelerator", label: "E-Commerce SEO Accelerator" },
                    { value: "Local SEO Authority", label: "Local SEO Authority" },
                    { value: "Technical SEO Specialist", label: "Technical SEO Specialist" },
                ],
                "Starter Plan": [
                    { value: "Social Launch Basic", label: "Social Launch Basic" },
                    { value: "Growth Kickoff", label: "Growth Kickoff" },
                ],
                "Intermediate Plan": [
                    { value: "Social Momentum", label: "Social Momentum" },
                    { value: "Engagement Boost", label: "Engagement Boost" },
                ],
                "Advanced Plan": [
                    { value: "Social Dominance Pro", label: "Social Dominance Pro" },
                    { value: "Brand Authority Elite", label: "Brand Authority Elite" },
                ],
                "Specialized Plan": [
                    { value: "Content Creator Kit", label: "Content Creator Kit" },
                    { value: "E-Commerce Amplifier", label: "E-Commerce Amplifier" },
                ],
                "Starter-Plan": [
                    { value: "Design Spark", label: "Design Spark" },
                    { value: "Creative Launch", label: "Creative Launch" },
                ],
                "Intermediate-Plan": [
                    { value: "Creative Growth", label: "Creative Growth" },
                    { value: "Design Pro", label: "Design Pro" },
                ],
                "Premium-Plan": [
                    { value: "Creative Elite", label: "Design Mastery" },
                    { value: "E-Commerce Amplifier", label: "E-Commerce Amplifier" },
                ],
                "Custom-Plan": [
                    { value: "Custom Design Solutions", label: "Custom Design Solutions" },
                ],
            },
            filteredWebsiteTypes: [],
            filteredPlans: [],
        };
    },

    methods: {
        updateWebsiteTypes() {
            this.filteredWebsiteTypes = this.serviceOptions[this.from.service] || [];
            this.from.website_type = this.filteredWebsiteTypes.length ? this.filteredWebsiteTypes[0].value : "";
            this.updatePlans();
        },
        updatePlans() {
            this.filteredPlans = this.plans[this.from.website_type] || [];
            this.from.website_feature = this.filteredPlans.length ? this.filteredPlans[0].value : "";
        },
        previewImage(event, type) {
            const file = event.target.files[0];
            if (file) {
                this.from[type] = file;
                const reader = new FileReader();
                reader.onload = () => {
                    this.from[type + 'Preview'] = reader.result; // Fixing preview assignment
                };
                reader.readAsDataURL(file);
            }
        },
        async CreateUsers() {
            this.errors = [];
            if (!this.from.name) this.errors.push('Your User Name Is Required');
            if (!this.from.email) this.errors.push('Your Email Is Required');
            if (!this.from.phone) this.errors.push('Your Phone Number Is Required');
            if (!this.from.business_name) this.errors.push('Your Business Name Is Required');
            if (!this.from.business_industry) this.errors.push('Your Business Industry Is Required');
            if (!this.from.website_content) this.errors.push('Your Content Information Is Required');
            if (!this.from.website_type) this.errors.push('Your Website Type Is Required');
            if (!this.from.website_estimated_budget) this.errors.push('Your Estimated Budget Is Required');
            if (!this.from.website_desired_launch_date) this.errors.push('Your Desired Launch Date Is Required');
            if (this.from.service === 'Web-Development') {
                if (!this.from.existing_website) this.errors.push('Your Existing Website Is Required');
                if (!this.from.website_color) this.errors.push('Your Preferred Colors Is Required');
                if (!this.from.website_reference) this.errors.push('Your Reference Websites Is Required');
                if (!this.from.website_images) this.errors.push('Your images & videos Question Is Required');
            }
            if (this.from.service === 'SEO') {
                if (!this.from.seo_target_audience) this.errors.push('Your Target Audience Is Required');
                if (!this.from.seo_primary_goal) this.errors.push('Your Primary SEO Goal Is Required');

            }
            if (this.from.service === 'Graphic Designing') {
                if (!this.from.graphical_design_text_context) this.errors.push('Will You Provide Images & Assets');
                if (!this.from.graphical_design_images_asserts) this.errors.push('Will You Provide Text Content');
                if (!this.from.graphical_design_dimensions_size) this.errors.push('File Formats Is Required');
            }
            if (this.errors.length > 0) {
                console.log("Validation errors:", this.errors);
                return;
            }
            this.loading = true;
            const formData = new FormData();
            formData.append('name', this.from.name);
            formData.append('email', this.from.email);
            formData.append('phone', this.from.phone);
            formData.append('business_name', this.from.business_name);
            formData.append('business_industry', this.from.business_industry);
            formData.append('service', this.from.service); 7
            formData.append('website_type', this.from.website_type);
            formData.append('website_feature', this.from.website_feature);
            formData.append('website_estimated_budget', this.from.website_estimated_budget);
            formData.append('website_desired_launch_date', this.from.website_desired_launch_date);
            if (this.from.service === 'Web-Development') {
                formData.append('existing_website', this.from.existing_website);
                formData.append('website_color', this.from.website_color);
                formData.append('website_reference', this.from.website_reference);
                formData.append('website_content', this.from.website_content);
                formData.append('website_images', this.from.website_images);
            }
            formData.append('notes', this.from.notes);
            // social media
            if (this.from.service === 'SMM') {
                formData.append('social_media_ad', this.from.social_media_ad);
                formData.append('social_media_paid_ad', this.from.social_media_paid_ad);
                formData.append('social_media_budget_ad', this.from.social_media_budget_ad);
                formData.append('social_media_perfer_ad_type', this.from.social_media_perfer_ad_type);
                formData.append('social_media_perfer_reporting_frequence', this.from.social_media_perfer_reporting_frequence);
                formData.append('social_media_ad_track_keywords', this.from.social_media_ad_track_keywords);
                formData.append('graphical_design_name_plan_phone', this.from.graphical_design_name_plan_phone);
            }
            // seo
            if (this.from.service === 'SEO') {
                formData.append('seo_keyword', this.from.seo_keyword);
                formData.append('seo_primary_goal', this.from.seo_primary_goal);
                formData.append('seo_target_audience', this.from.seo_target_audience);
                formData.append('seo_target_loaction', this.from.seo_target_loaction);
                formData.append('seo_competitor_website', this.from.seo_competitor_website);
                formData.append('seo_list_of_keywords', this.from.seo_list_of_keywords);
                formData.append('seo_keywords_main', this.from.seo_keywords_main);
            }
            // graphical design
            if (this.from.service === 'Graphic Designing') {
                formData.append('graphical_design_perferr_color', this.from.graphical_design_perferr_color);
                formData.append('graphical_design_text_context', this.from.graphical_design_text_context);
                formData.append('graphical_design_brand_guideliness', this.from.graphical_design_brand_guideliness);
                formData.append('graphical_design_images_asserts', this.from.graphical_design_images_asserts);
                formData.append('graphical_design_referce_design', this.from.graphical_design_referce_design);
                formData.append('graphical_design_file_formad', this.from.graphical_design_file_formad);
                formData.append('graphical_design_dimensions_size', this.from.graphical_design_dimensions_size);
                if (this.from.profile) { formData.append('profile', this.from.profile) };
            }
            let url = config.apiBaseUrl + `create-business-information/${this.$route.params.id}`;
            try {
                await axios.post(url, formData);
                this.loading = false;
                this.businessInfor = true;

                // Clear form fields
                this.from = {
                    name: "",
                    email: "",
                    phone: "",
                    user_id: null,
                    business_name: "",
                    business_industry: "",
                    existing_website: "",
                    website_type: "",
                    website_feature: "",
                    website_color: "",
                    website_reference: "",
                    website_content: "",
                    website_images: "",
                    website_estimated_budget: "",
                    website_desired_launch_date: "",
                    notes: "",
                };

                toast.success("Business information submitted successfully!");
            } catch (error) {
                console.error("API call error:", error);
                this.loading = false;
            }
        },
    },
    mounted() {
        this.updateWebsiteTypes();
    },
};
</script>


<style scoped>
.businessInfor {
    font-size: 25px;
    font-weight: 800;
    text-decoration: underline;
}

.visetech-caption {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
}

.signIn::placeholder {
    font-size: .8125rem;
}

.login_page {
    margin: 3.5rem auto !important;
    width: 65%;
}

.color-red {
    color: #d70000 !important;
}

.font-size {
    font-size: 13px !important;
}

.logo {
    width: 20%;
}

.container {
    max-width: 560px
}

.text {
    font-size: 16px;
}

.save-btn-login {
    width: 100%;
    background: var(--viseTech);
    color: white !important;
    padding: 9px 9px;
    border-radius: 10px;
    border: none;

}

.save-btn-login:hover {
    background: var(--viseTech);
    opacity: 0.8;
}

.save-btn-sign {
    background: #ffffff;
    width: 100%;
    padding: 9px 9px;
    border-radius: 10px;
    border: 2px solid #99519e;
    font-weight: 400;
    text-align: center;
    transition: 0.3s ease-out;
}

.save-btn-sign>a {
    text-decoration: none;
    color: #1554dd !important;
}

.text {
    color: #626262;
    font-size: .8125rem;
    font-weight: 550;
}

.link-items {
    color: rgb(153 82 155);
    font-weight: 800;
}
</style>
