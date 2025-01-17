<template>
    <div class="container">
        <div class="main-container">
            <router-link to="/in-voice" class="add-link">
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
                                <label for="businessName" class="form-label text">Client First Name*</label>
                                <input type="text" class="form-control" id="businessName" v-model="from.client_name"
                                    :class="{ 'is-invalid': errors.includes('Client Name Is Required') }"
                                    placeholder="Client Name">
                                <span v-if="errors.includes('Client Name Is Required')" class="invalid-feedback">
                                    Client Name Is Required</span>
                            </div>
                            <div class="mb-2">
                                <label for="businessName" class="form-label text">Client Last Name*</label>
                                <input type="text" class="form-control" id="businessName"
                                    v-model="from.client_last_name"
                                    :class="{ 'is-invalid': errors.includes('Client Last Name Is Required') }"
                                    placeholder="Client Name">
                                <span v-if="errors.includes('Client Last Name Is Required')" class="invalid-feedback">
                                    Client Last Name Is Required</span>
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
                                <!-- <input type="text" class="form-control" id="businessName" v-model="from.phone"
                                    :class="{ 'is-invalid': errors.includes('Client Phone Is Required') }"
                                    placeholder="Client Phone"> -->
                                <vue-tel-input v-model="from.phone" mode="international"
                                    class="flag-input"></vue-tel-input>
                                <span v-if="errors.includes('Client Phone Is Required')" class="invalid-feedback">
                                    Client Phone Is Required</span>
                            </div>
                        </div>
                        <div v-for="(service, index) in services" :key="index" class="parent-accordion p-3 mb-3">
                            <div v-if="index > 0" class="close-btn" @click="removeService(index)"
                                style="cursor: pointer; color: red;">
                                <i class="fas fa-times"></i> <!-- You can use a FontAwesome 'x' icon -->
                            </div>
                            <!-- Service details as before -->
                            <div class="form-group mb-2">
                                <label for="licenseType" class="form-label text mb-1">Service*</label>
                                <div class="input-icon">
                                    <select class="form-control form-select" v-model="service.selectedService"
                                        @change="updateServiceDetails(index); updateTotalPayment()"
                                        :class="{ 'is-invalid': errors.includes('Service Selection Is Required') }">
                                        <option value="" class="text2">Select a Client Service</option>
                                        <option :value="item.id" class="text2" v-for="item in allserviceDetails">{{
                                            item.name }}</option>
                                    </select>
                                    <span v-if="errors.includes('Service Selection Is Required')"
                                        class="invalid-feedback">
                                        Service Selection Is Required
                                    </span>
                                </div>
                            </div>
                            <div class="mb-2" v-if="service.selectedService">
                                <label for="businessName" class="form-label text">Service Price*</label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon1">$</span>
                                    <input type="text" class="form-control" readonly placeholder="Service Price"
                                        v-model="service.price" aria-label="Username" aria-describedby="basic-addon1">
                                </div>
                            </div>

                            <div class="form-group mb-2">
                                <label for="licenseType" class="form-label text mb-1">Package*</label>
                                <div class="input-icon">
                                    <select class="form-control form-select" v-model="service.package"
                                        @change="updateTotalPayment()"
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
                                        class="invalid-feedback">
                                        Package Selection Is Required
                                    </span>
                                </div>
                            </div>
                        </div>


                        <!-- Add New Service Button -->
                        <div class="parent-accordion p-3 mb-3" id="parent-accordion">
                            <div class="text" style="text-align: right; cursor: pointer;" @click="addNewService">
                                + Add more Service
                            </div>
                        </div>
                        <!-- Add New Service Button -->
                        <div class="parent-accordion p-3 mb-3" id="parent-accordion">
                            <div class="mb-2">
                                <label for="businessName" class="form-label text">Service Tax*</label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon1">%</span>
                                    <input type="text" class="form-control" placeholder="Service Tax"
                                        v-model="from.service_tax" aria-label="Username"
                                        aria-describedby="basic-addon1">
                                </div>
                            </div>
                        </div>
                        <div class="parent-accordion p-3 mb-3">
                            <div class="mb-2">
                                <label for="addressLine1" class="form-label text-muted">Notes <span
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
                                    <input type="number" v-model="from.total_payment" @input="calculateRemainingPayment"
                                        class="form-control" placeholder="Total Client Payment"
                                        aria-label="Total Client Payment" aria-describedby="basic-addon1"
                                        :class="{ 'is-invalid': errors.includes('Client Total Payment Is Required') }">
                                    <span v-if="errors.includes('Client Total Payment Is Required')"
                                        class="invalid-feedback">Client Total Payment Is Required</span>
                                </div>
                            </div>
                            <div class="mb-2">
                                <label for="businessName" class="form-label text">Initial Client Payment*</label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon1">$</span>
                                    <input type="number" v-model="from.initial_payment"
                                        @input="calculateRemainingPayment" class="form-control"
                                        placeholder="Initial Client Payment" aria-label="Initial Client Payment"
                                        aria-describedby="basic-addon1"
                                        :class="{ 'is-invalid': errors.includes('Client Initial Payment Is Required') }">
                                    <span v-if="errors.includes('Client Initial Payment Is Required')"
                                        class="invalid-feedback">Client Initial Payment Is Required</span>
                                </div>
                            </div>

                            <div class="mb-2">
                                <label for="businessName" class="form-label text">Remaining Client Payment*</label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon1">$</span>
                                    <input type="number" class="form-control" placeholder="Remaining Client Payment"
                                        aria-label="Remaining Client Payment" aria-describedby="basic-addon1"
                                        v-model="from.remaining_payment" readonly>
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
            selectedServiceId: "", // Stores the ID of the selected service
            selectedServicePrice: "", // Stores the price of the selected service
            selectedServiceTax: "", // Stores the price of the selected service
            from: {
                client_name: "",
                client_last_name: "",
                email: "",
                phone: "",
                service: "",
                package: "",
                total_payment: 0,
                initial_payment: 0,
                remaining_payment: 0,
                description: "",
                payment_status: 'pending',
                invoice: '',
                service_tax: '',
            },
            errors: [],
            loading: false,
            invoiceUrl: null,
            originalFrom: {}, // Store the initial state
            isFormDirty: false, // Track form changes
            services: [
                {
                    selectedService: '',
                    price: '',
                    package: '',
                    startDate: new Date().toISOString().split('T')[0], // Default to today's date
                    endDate: '' // To be calculated
                }
            ]
        };
    },
    methods: {
        ...mapActions('service', ['fetchSingleServices', 'fetchAllServicesDetailsData']),
        updateServiceDetails(index) {
            const selectedServiceId = this.services[index].selectedService;
            const selectedService = this.allserviceDetails.find(service => service.id === selectedServiceId);

            if (selectedService) {
                // Update the price and tax based on the selected service
                this.services[index].price = selectedService.price;
                this.services[index].tax = selectedService.tax;
            }
        },
        handleFileUpload(event) {
            const file = event.target.files[0];
            this.from.invoice = file;

            if (file) {
                this.invoiceUrl = URL.createObjectURL(file); // Generate a temporary URL for the file
            }
        },
        addNewService() {
            // Add a new service with today's startDate and an empty endDate
            this.services.push({
                selectedService: '',
                price: '',
                package: '',
                startDate: new Date().toISOString().split('T')[0],
                endDate: ''
            });
        },
        // Method to remove service form based on index
        removeService(index) {
            this.services.splice(index, 1);
        },
        // updateServiceDetails(index) {
        //     const selectedServiceId = this.services[index].selectedService;
        //     const selectedService = this.allserviceDetails.find(service => service.id === selectedServiceId);

        //     if (selectedService) {
        //         // Directly update the properties of the service object
        //         this.services[index].price = selectedService.price;
        //         this.services[index].tax = selectedService.tax;
        //     }
        // },
        async CreateService() {
            this.errors = [];
            if (!this.from.client_name) this.errors.push('Client Name Is Required');
            if (!this.from.client_last_name) this.errors.push('Client Last Name Is Required');
            if (!this.from.email) this.errors.push('Client Email Is Required');
            if (!this.from.phone) this.errors.push('Client Phone Is Required');

            // Loop through each service and check if 'selectedService' and 'package' are filled
            this.services.forEach((service, index) => {
                if (!service.selectedService) this.errors.push(`Service Selection for Service #${index + 1} Is Required`);
                if (!service.package) this.errors.push(`Package Selection for Service #${index + 1} Is Required`);
            });

            if (!this.from.total_payment) this.errors.push('Client Total Payment Is Required');
            if (!this.from.initial_payment) this.errors.push('Client Initial Payment Is Required');
            if (!this.from.remaining_payment) this.errors.push('Client Remaining Payment Is Required');

            if (this.errors.length > 0) {
                console.log("Validation errors:", this.errors);
                return;
            }

            // If no validation errors, proceed with the form submission
            this.loading = true;

            const formData = new FormData();
            formData.append('client_name', this.from.client_name);
            formData.append('client_last_name', this.from.client_last_name);
            formData.append('email', this.from.email);
            formData.append('phone', this.from.phone);

            // Convert the services array to a JSON string before appending to formData
            formData.append('service', JSON.stringify(this.services));  // Convert the array to JSON string
            formData.append('service_tax', this.from.service_tax);  // Convert the array to JSON string

            formData.append('description', this.from.description);
            formData.append('package', this.from.package); // Ensure to send the correct package if necessary
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
                    this.$router.push('/in-voice');
                    setTimeout(() => {
                        toast.success('Invoice Updated Successfully');
                    }, 500);
                } else {
                    this.$router.push('/in-voice');
                    setTimeout(() => {
                        toast.success('Invoice Created Successfully');
                    }, 500);
                }
            } catch (error) {
                console.error("API call error:", error);
                this.loading = false;
            }
        },
        updateEndDate(index) {
            const service = this.services[index];

            if (service.package) {
                const startDate = new Date(service.startDate || new Date()); // Use existing startDate or today's date
                let daysToAdd = 0;

                // Determine the number of days to add based on the package
                switch (service.package) {
                    case '1week':
                        daysToAdd = 7;
                        break;
                    case '3week':
                        daysToAdd = 21;
                        break;
                    case '1month':
                        daysToAdd = 30; // Approximate 1 month as 30 days
                        break;
                    case '3month':
                        daysToAdd = 90;
                        break;
                    case '6month':
                        daysToAdd = 180;
                        break;
                    case '1year':
                        daysToAdd = 365;
                        break;
                    default:
                        daysToAdd = 0;
                        break;
                }
                // Calculate the end date
                const endDate = new Date(startDate);
                endDate.setDate(startDate.getDate() + daysToAdd);
                service.endDate = endDate.toISOString().split('T')[0]; // Format as YYYY-MM-DD
            }
        },
        updateTotalPayment() {
            let total = 0;

            // Loop through all services and calculate total price based on selected package
            this.services.forEach(service => {
                if (service.selectedService && service.package) {
                    const selectedService = this.allserviceDetails.find(s => s.id === parseInt(service.selectedService)); // Make sure to parse the service ID as an integer

                    if (selectedService) {
                        let packageMultiplier = 1;
                        switch (service.package) {
                            case '1week':
                                packageMultiplier = 1;
                                break;
                            case '3week':
                                packageMultiplier = 3;
                                break;
                            case '1month':
                                packageMultiplier = 4; // assuming 4 weeks in a month
                                break;
                            case '3month':
                                packageMultiplier = 12; // 3 months
                                break;
                            case '6month':
                                packageMultiplier = 24; // 6 months
                                break;
                            case '1year':
                                packageMultiplier = 48; // 1 year
                                break;
                            default:
                                packageMultiplier = 1; // fallback
                                break;
                        }
                        const servicePrice = parseFloat(selectedService.price) || 0;
                        total += servicePrice * packageMultiplier;
                    }
                }
            });

            // Set the formatted total payment with two decimal places
            this.from.total_payment = total.toFixed(2);
        },
        calculateRemainingPayment() {
            const total = parseFloat(this.from.total_payment) || 0;
            const initial = parseFloat(this.from.initial_payment) || 0;
            this.from.remaining_payment = Math.max(0, total - initial);
        },
        checkFormDirty() {
            if (!this.$route.params.id) {
                this.isFormDirty = JSON.stringify(this.from) !== JSON.stringify(this.originalFrom);
            }
        },
    },
    computed: {
        ...mapState('service', ['singleService', 'singleServicesLoading', 'allserviceDetails']),
    },
    watch: {
        'from.total_payment': 'calculateRemainingPayment',
        'from.initial_payment': 'calculateRemainingPayment',
        services: {
            handler(services) {
                services.forEach((service, index) => {
                    this.updateEndDate(index); // Recalculate the end date for all services
                });
            },
            deep: true // Watch for deep changes in the array
        },
        singleService(newDetail) {
            if (newDetail) {
                // Fill in basic fields
                this.from.client_name = newDetail.client_name || '';
                this.from.client_last_name = newDetail.client_last_name || '';
                this.from.email = newDetail.email || '';
                this.from.phone = newDetail.phone || '';
                this.from.description = newDetail.description || '';
                this.from.service_tax = newDetail.service_tax || '';
                this.from.package = newDetail.package || '';
                this.from.service_price = newDetail.service_price || '';
                this.from.service_tax = newDetail.service_tax || '';
                this.from.total_payment = newDetail.total_payment || '';
                this.from.initial_payment = newDetail.initial_payment || '';
                this.from.remaining_payment = newDetail.remaining_payment || '';
                this.from.invoice = newDetail.invoice || '';
                this.from.payment_status = newDetail.payment_status || '';

                // Handle invoice URL
                const baseUrl = process.env.VUE_APP_BASE_URL || 'http://localhost:8000';
                this.invoiceUrl = newDetail.invoice ? `${baseUrl}/${newDetail.invoice}` : null;

                // Check if 'service' is a string (JSON string) and parse it if so
                if (typeof newDetail.service === 'string') {
                    try {
                        this.services = JSON.parse(newDetail.service);
                    } catch (error) {
                        console.error("Error parsing service JSON:", error);
                        this.services = [];
                    }
                } else if (Array.isArray(newDetail.service)) {
                    // If it's already an array, just use it
                    this.services = newDetail.service;
                } else {
                    // In case it's neither a string nor an array, set an empty array
                    this.services = [];
                }
            }
        },
        // Track form changes and update the dirty status
        'from.client_name': 'checkFormDirty',
        'from.email': 'checkFormDirty',
        'from.phone': 'checkFormDirty',
        'from.description': 'checkFormDirty',
        'from.package': 'checkFormDirty',
        'from.service': 'checkFormDirty',
        'from.service_price': 'checkFormDirty',
        'from.service_tax': 'checkFormDirty',
        'from.total_payment': 'checkFormDirty',
        'from.initial_payment': 'checkFormDirty',
        'from.remaining_payment': 'checkFormDirty',
        'from.invoice': 'checkFormDirty',
        'from.payment_status': 'checkFormDirty',
        'from.invoice': 'checkFormDirty',
    },

    mounted() {
        if (this.$route.params.id) {
            this.fetchSingleServices(this.$route.params.id)
        }
        this.fetchAllServicesDetailsData();
    },
    beforeRouteLeave(to, from, next) {
        if (!this.$route.params.id || this.isFormDirty) {
            const answer = window.confirm('You have unsaved changes, are you sure you want to leave?');
            if (answer) {
                next();
            } else {
                next(false); // Prevent navigation
            }
        } else {
            next(); // Proceed with navigation when no unsaved changes
        }
    },
}
</script>
<style scoped>
.close-btn {
    text-align: right;
    margin-top: 10px;
}

.close-btn i {
    font-size: 20px;
    cursor: pointer;
    color: #99519e !important;
}

.close-btn i:hover {
    color: #99519e !important;
}

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