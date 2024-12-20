<template>
    <div class="container">
        <div class="main-container">
            <router-link to="/service" class="add-link">
                <div class="row1">
                    <i class="fas fa-arrow-left"></i>
                    <h3 class="heading" v-if="this.$route.params.id">Edit Service</h3>
                    <h3 class="heading" v-else>Add Service</h3>
                </div>
            </router-link>
            <form @submit.prevent="CreateService()" novalidate>
                <!-- Loading Spinner -->
                <div class="spinner2 d-flex justify-content-center" v-if="singleServicesLoading">
                    <div class="spinner-border" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
                <div class="row" v-else>
                    <div class="col-md-8">
                        <div class="parent-accordion p-3 mb-3" id="parent-accordion">
                            <div class="mb-2">
                                <label for="businessName" class="form-label text">Client Name*</label>
                                <input type="text" class="form-control" id="businessName" v-model="from.client_name"
                                    :class="{ 'is-invalid': errors.includes('Client Name Is Required') }"
                                    placeholder="Client Name">
                                <span v-if="errors.includes('Client Name Is Required')" class="invalid-feedback">
                                    Client Name Is Required</span>
                            </div>
                            <div class="mb-2">
                                <label for="businessName" class="form-label text">Client Email*</label>
                                <input type="text" class="form-control" id="businessName" v-model="from.email"
                                    :class="{ 'is-invalid': errors.includes('Client Email Is Required') }"
                                    placeholder="Client Email">
                                <span v-if="errors.includes('Client Email Is Required')" class="invalid-feedback">
                                    Client Email Is Required</span>
                            </div>
                            <div class="mb-2">
                                <label for="businessName" class="form-label text">Client Phone*</label>
                                <input type="text" class="form-control" id="businessName" v-model="from.phone"
                                    :class="{ 'is-invalid': errors.includes('Client Phone Is Required') }"
                                    placeholder="Client Phone">
                                <span v-if="errors.includes('Client Phone Is Required')" class="invalid-feedback">
                                    Client Phone Is Required</span>
                            </div>
                        </div>
                        <div class="parent-accordion p-3 mb-3" id="parent-accordion">
                            <div class="form-group mb-2">
                                <label for="licenseType" class="form-label text mb-1">Client Service*</label>
                                <div class="input-icon">
                                    <select class="form-control form-select" id="licenseType" v-model="from.service"
                                        :class="{ 'is-invalid': errors.includes('Service Selection Is Required') }">
                                        <option value="" class="text2">Select a Client Service</option>
                                        <option value="web-design" class="text2">Web Design</option>
                                        <option value="web-development" class="text2">Web Development</option>
                                        <option value="ecommerce" class="text2">E-commerce Development</option>
                                        <option value="seo" class="text2">SEO Services</option>
                                        <option value="ui-ux-design" class="text2">UI/UX Design</option>
                                        <option value="maintenance" class="text2">Website Maintenance</option>
                                        <option value="digital-marketing" class="text2">Digital Marketing</option>
                                        <option value="cms-development" class="text2">CMS Development</option>
                                        <option value="api-integration" class="text2">API Integration</option>
                                        <option value="hosting-services" class="text2">Hosting Services</option>
                                    </select>
                                    <span v-if="errors.includes('Service Selection Is Required')"
                                        class="invalid-feedback">Service Selection Is Required</span>
                                </div>
                            </div>

                            <div class="form-group mb-2">
                                <label for="licenseType" class="form-label text mb-1">Client Package*</label>
                                <div class="input-icon">
                                    <select class="form-control form-select" id="licenseType" v-model="from.package"
                                        :class="{ 'is-invalid': errors.includes('Package Selection Is Required') }">
                                        <option value="" class="text2">Select a Client Package</option>
                                        <option value="1week" class="text2">Weekly Package (1 Week)</option>
                                        <option value="3week" class="text2">3 Weekly Package (3 Week)</option>
                                        <option value="1month" class="text2">Monthly Package (1 Month)</option>
                                        <option value="3month" class="text2">Quarterly Package (3 Months)</option>
                                        <option value="6month" class="text2">Half-Yearly Package (6 Months)</option>
                                        <option value="1year" class="text2">Yearly Package (1 Year)</option>
                                    </select>

                                    <span v-if="errors.includes('Package Selection Is Required')"
                                        class="invalid-feedback">Package Selection Is Required</span>
                                </div>
                            </div>
                        </div>
                        <div class="parent-accordion p-3 mb-3">
                            <div class="mb-2">
                                <label for="addressLine1" class="form-label text-muted">Message <span
                                        class="reminder">(For
                                        Own reminder)</span></label>
                                <quill-editor toolbar="full" v-model:content="from.description" :content-type="'html'"
                                    class="custom-quill-editor" theme="snow" />

                            </div>
                        </div>

                        <button type="submit" class="save-btn text">
                            <span v-if="!loading">Save</span>
                            <span v-else class="spinner-border spinner-border-sm" role="status"
                                aria-hidden="true"></span>
                            <span class="visually-hidden">Loading...</span>
                        </button>
                    </div>
                    <div class="col-md-4">
                        <div class="parent-accordion p-3 mb-3" id="parent-accordion">
                            <div class="mb-2">
                                <label for="businessName" class="form-label text">Total Client Payment*</label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon1">$</span>
                                    <input type="text" class="form-control" placeholder="Total Client Payment"
                                        aria-label="Username" aria-describedby="basic-addon1"
                                        v-model="from.total_payment"
                                        :class="{ 'is-invalid': errors.includes('Client Total Payment Is Required') }">
                                    <span v-if="errors.includes('Client Total Payment Is Required')"
                                        class="invalid-feedback">Client
                                        Total Payment Is Required</span>
                                </div>

                            </div>
                            <div class="mb-2">
                                <label for="businessName" class="form-label text">Initial Client Payment*</label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon1">$</span>
                                    <input type="text" class="form-control" placeholder="Initial Client Payment"
                                        aria-label="Username" aria-describedby="basic-addon1"
                                        v-model="from.initial_payment"
                                        :class="{ 'is-invalid': errors.includes('Client Initia Payment Is Required') }">
                                    <span v-if="errors.includes('Client Initia Payment Is Required')"
                                        class="invalid-feedback">Client Initia Payment Is Required</span>
                                </div>
                            </div>
                            <div class="mb-2">
                                <label for="businessName" class="form-label text">Remaining Client Payment*</label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon1">$</span>
                                    <input type="text" class="form-control" placeholder="Remaining Client Payment"
                                        aria-label="Username" aria-describedby="basic-addon1"
                                        v-model="from.remaining_payment"
                                        :class="{ 'is-invalid': errors.includes('Client Remaining Payment Is Required') }">
                                    <span v-if="errors.includes('Client Remaining Payment Is Required')"
                                        class="invalid-feedback">Client Remaining Payment Is Required</span>
                                </div>
                            </div>
                            <div class="mb-2">
                                <label for="businessName" class="form-label text">Upload Payment Invoice*</label>
                                <div class="input-group mb-3">
                                    <input type="file" class="form-control" placeholder="Upload Payment Invoice"
                                        aria-label="Username" aria-describedby="basic-addon1"
                                        @change="handleFileUpload">
                                </div>

                                <a :href="invoiceUrl" target="_blank" class="invoice" v-if="invoiceUrl">See Invoice</a>
                            </div>
                        </div>

                        <div class="parent-accordion p-3 mb-3" id="parent-accordion">
                            <div class="form-group mb-2">
                                <label for="licenseType" class="form-label text mb-1">Client Payment Status*</label>
                                <div class="input-icon">
                                    <select class="form-control form-select" id="licenseType"
                                        v-model="from.payment_status">
                                        <option value="pending" class="text2">Pending</option>
                                        <option value="complete" class="text2">Complete</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>
<script>
import { QuillEditor } from '@vueup/vue-quill'
import '@vueup/vue-quill/dist/vue-quill.snow.css';
import config from '../../config';
import axios from 'axios';
import { mapState, mapActions } from 'vuex';
import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';
export default {
    components: { QuillEditor },
    data() {
        return {
            from: {
                client_name: "",
                email: "",
                phone: "",
                service: "",
                package: "",
                total_payment: "",
                initial_payment: "",
                remaining_payment: "",
                description: "",
                payment_status: 'pending',
                invoice: '',
            },
            errors: [],
            loading: false,
            invoiceUrl: null,
        };
    },
    methods: {
        ...mapActions('service', ['fetchSingleServices']),
        handleFileUpload(event) {
            const file = event.target.files[0];
            this.from.invoice = file;

            if (file) {
                this.invoiceUrl = URL.createObjectURL(file); // Generate a temporary URL for the file
            }
        },
        async CreateService() {
            this.errors = [];
            if (!this.from.client_name) this.errors.push('Client Name Is Required');
            if (!this.from.email) this.errors.push('Client Email Is Required');
            if (!this.from.phone) this.errors.push('Client Phone Is Required');
            if (!this.from.service) this.errors.push('Service Selection Is Required');
            if (!this.from.package) this.errors.push('Package Selection Is Required');
            if (!this.from.total_payment) this.errors.push('Client Total Payment Is Required');
            if (!this.from.initial_payment) this.errors.push('Client Initia Payment Is Required');
            if (!this.from.remaining_payment) this.errors.push('Client Remaining Payment Is Required');

            if (this.errors.length > 0) {
                console.log("Validation errors:", this.errors);
                return;
            }

            // If no validation errors, proceed with the form submission
            this.loading = true;

            const formData = new FormData();
            formData.append('client_name', this.from.client_name);
            formData.append('email', this.from.email);
            formData.append('phone', this.from.phone);
            formData.append('service', this.from.service);
            formData.append('description', this.from.description);
            formData.append('package', this.from.package);
            formData.append('total_payment', this.from.total_payment);
            formData.append('initial_payment', this.from.initial_payment);
            formData.append('remaining_payment', this.from.remaining_payment);
            formData.append('payment_status', this.from.payment_status);
            formData.append('invoice', this.from.invoice);

            let url;
            if (this.$route.params.id) {
                url = config.apiBaseUrl + `update-services/${this.$route.params.id}`;
            } else {
                url = config.apiBaseUrl + `store-services`;
            }

            const token = localStorage.getItem('token');
            try {
                await axios.post(url, formData, {
                    headers: {
                        'Authorization': `Bearer ${token}`,
                    }
                });
                if (this.$route.params.id) {
                    this.$router.push('/service');
                    setTimeout(() => {
                        toast.success('Service Update Successfully');
                    }, 500);
                } else {
                    this.$router.push('/service');
                    setTimeout(() => {
                        toast.success('Service Created Successfully');
                    }, 500);
                }

            } catch (error) {
                console.error("API call error:", error);
                this.loading = false;
            }
        },

        calculateRemainingPayment() {
            this.from.remaining_payment = this.from.total_payment - this.from.initial_payment;
        }
    },
    computed: {
        ...mapState('service', ['singleService', 'singleServicesLoading']),
    },
    watch: {
        singleService(newDetail) {
            if (newDetail) {
                this.from.client_name = newDetail.client_name || '';
                this.from.email = newDetail.email || '';
                this.from.phone = newDetail.phone || '';
                this.from.description = newDetail.description || '';
                this.from.package = newDetail.package || '';
                this.from.service = newDetail.service || '';
                this.from.total_payment = newDetail.total_payment || '';
                this.from.initial_payment = newDetail.initial_payment || '';
                this.from.remaining_payment = newDetail.remaining_payment || '';
                this.from.invoice = newDetail.invoice || '';
                this.from.payment_status = newDetail.payment_status || '';
                const baseUrl = process.env.VUE_APP_BASE_URL || 'http://localhost:8000';
                this.invoiceUrl = newDetail.invoice ? `${baseUrl}/${newDetail.invoice}` : null;
            }
        },
        'from.total_payment': function (newTotal) {
            this.calculateRemainingPayment();
        },
        'from.initial_payment': function (newInitial) {
            this.calculateRemainingPayment();
        }
    },

    mounted() {
        if (this.$route.params.id) {
            this.fetchSingleServices(this.$route.params.id)
        }

    }
}
</script>
<style scoped>
.invoice {
    background: none;
    color: #99519e !important;
    border-radius: 6px;
    border: none;
}

.reminder {
    font-size: 10px;
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