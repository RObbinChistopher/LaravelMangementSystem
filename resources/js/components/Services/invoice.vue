<template>
    <div class="container extra-class-container" style="margin: 1.5rem 0px !important">
        <div class="row">
            <div class="col-md-4 col-6 header-col">
            </div>
            <div class="col-md-8 col-6">
                <div class="btn-text m-0 add-new-cat " style="display: flex; justify-content: flex-end;">
                    <router-link to="/in-voice" class="import2 add-cc hover-cc">Back</router-link>
                </div>
            </div>
        </div>
        <!-- Loading Spinner -->
        <div class="spinner2 d-flex justify-content-center" v-if="singleServicesLoading">
            <div class="spinner-border" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
        <div class="invoice-container" v-else>
            <div class="row">
                <div class="col-md-4 col-6 header-col">
                    <h3 class="heading">Services Invoice</h3>
                </div>
            </div>
            <div class="parent-accordion p-3" id="parent-accordion">
                <div class="row">
                    <div class="col-md-6">
                        <div class="client-details">
                            <img src="/Images/logo.png" class="logo mb-2">
                            <p><strong>Email:</strong> vise.tech1@gmail.com</p>
                            <p><strong>Phone #:</strong> +92 3004257361</p>
                            <p><strong>Loaction:</strong>Cavalry Ground, Lahore<br>Punjab, Pakistan</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="client-details">
                            <h2>Client Details</h2>
                            <p><strong>Name:</strong> {{ singleService.client_name }}</p>
                            <p><strong>Email:</strong> {{ singleService.email }}</p>
                            <p><strong>Phone:</strong> {{ singleService.phone }}</p>
                        </div>
                    </div>
                </div>


                <div class="service-details">
                    <h3>Service Details</h3>
                    <div style="margin-bottom: 20px;">
                        <table style="width: 100%; border-collapse: collapse; margin-top: 10px;">
                            <thead>
                                <tr>
                                    <th
                                        style="padding: 10px; background-color: #f5f5f5; border: 1px solid #ddd; text-align: left;">
                                        Service Name</th>
                                    <th
                                        style="padding: 10px; background-color: #f5f5f5; border: 1px solid #ddd; text-align: left;">
                                        Package</th>
                                    <th
                                        style="padding: 10px; background-color: #f5f5f5; border: 1px solid #ddd; text-align: left;">
                                        Price</th>
                                    <th
                                        style="padding: 10px; background-color: #f5f5f5; border: 1px solid #ddd; text-align: left;">
                                        Start Date</th>
                                    <th
                                        style="padding: 10px; background-color: #f5f5f5; border: 1px solid #ddd; text-align: left;">
                                        End Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in parsedServices" :key="item.selectedService">
                                    <td style="padding: 10px; border: 1px solid #ddd;">{{ item.name }}</td>
                                    <td style="padding: 10px; border: 1px solid #ddd;">{{ item.package }}</td>
                                    <td style="padding: 10px; border: 1px solid #ddd;">{{ item.price }}$</td>
                                    <td style="padding: 10px; border: 1px solid #ddd;">{{ item.startDate }}</td>
                                    <td style="padding: 10px; border: 1px solid #ddd;">{{ item.endDate }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div style="margin-bottom: 20px;">
                        <h3>Payment Details</h3>
                        <table>
                            <thead>
                                <tr>
                                    <th>Payment Field</th>
                                    <th>Payment Value</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Total Payment</td>
                                    <td>{{ singleService.total_payment }}$</td>
                                </tr>
                                <tr>
                                    <td>Initial Payment</td>
                                    <td>{{ singleService.initial_payment }}$</td>
                                </tr>
                                <tr>
                                    <td>Remaining Payment</td>
                                    <td>{{ singleService.remaining_payment }}$</td>
                                </tr>
                                <tr>
                                    <td>Payment Status</td>
                                    <td>{{ singleService.payment_status || 'Pending' }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>


                <div class="description">
                    <div class="text-center">Thank you for your business!</div>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <button @click="downloadInvoice" :disabled="loading">
                        <span v-if="!loading">Download Invoice as PDF</span>
                        <span v-else class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        <span class="visually-hidden">Loading...</span>
                    </button>
                    <button @click="sendTasksEmail" :disabled="loading">
                        <span v-if="!loading">Send Email</span>
                        <span v-else class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        <span class="visually-hidden">Loading...</span>
                    </button>
                </div>
            </div>
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
            loading: false, // Tracks the loading state
        };
    },
    methods: {
        ...mapActions('service', ['fetchSingleServices']),
        async downloadInvoice() {
            try {
                this.loading = true;
                const response = await axios.post('/download-service-invoice', {
                    client_name: this.singleService.client_name,
                    email: this.singleService.email,
                    phone: this.singleService.phone,
                    services: this.singleService.services,
                    package: this.singleService.package,
                    total_payment: this.singleService.total_payment,
                    initial_payment: this.singleService.initial_payment,
                    remaining_payment: this.singleService.remaining_payment,
                    payment_status: this.singleService.payment_status,
                    starting_date: this.singleService.starting_date,
                    ending_date: this.singleService.ending_date
                }, {
                    responseType: 'blob',
                });

                const url = window.URL.createObjectURL(new Blob([response.data]));
                const link = document.createElement('a');
                link.href = url;
                link.setAttribute('download', 'invoice.pdf');
                document.body.appendChild(link);
                link.click();
                link.remove();
                toast.success('Invoice Download Successfully');
            } catch (error) {
                console.error("Error downloading invoice:", error);
            } finally {
                this.loading = false;
            }
        },
        async sendTasksEmail() {

            const token = localStorage.getItem('token');
            try {
                this.loading = true;
                const response = await axios.post('/api/send-service-email', {
                    client_name: this.singleService.client_name,
                    email: this.singleService.email,
                    phone: this.singleService.phone,
                    services: this.singleService.services,
                    package: this.singleService.package,
                    total_payment: this.singleService.total_payment,
                    initial_payment: this.singleService.initial_payment,
                    remaining_payment: this.singleService.remaining_payment,
                    payment_status: this.singleService.payment_status,
                    starting_date: this.singleService.starting_date,
                    ending_date: this.singleService.ending_date
                }, {
                    headers: {
                        'Authorization': `Bearer ${token}`,
                    }
                })
                toast.success('Email Send Successfully')
            } catch (error) {
                console.error("Error sending email:", error);
                this.errorMessage = error.response?.data?.message || 'Failed to send email.';
                this.successMessage = '';
            } finally {
                this.loading = false; // Stop loading
            }
        },

    },
    computed: {
        ...mapState('service', ['singleService', 'singleServicesLoading']),
        parsedServices() {
            try {
                return JSON.parse(this.singleService.service).map(service => ({
                    ...service,
                    name: this.singleService.services.find(s => s.package === service.package)?.name || '',
                }));
            } catch (error) {
                console.error("Error parsing services:", error);
                return [];
            }
        },
    },

    mounted() {
        if (this.$route.params.id) {
            this.fetchSingleServices(this.$route.params.id)
        }

    }
}
</script>

<style scoped>
.logo {
    width: 35%;
}

.invoice-container {
    max-width: 800px;
    margin: 1.5rem auto;
    padding: 20px;
    font-family: Arial, sans-serif;
    border: 1px solid #ccc;
    border-radius: 8px;
    background-color: #f9f9f9;
}

h1,
h2 {
    color: #333;
}

.client-details,
.service-details,
.description {
    margin-bottom: 20px;
}

p {
    margin: 5px 0;
}

button {
    padding: 10px 20px;
    background-color: var(--viseTech);
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

button:hover {
    background-color: var(--viseTechHover);
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 10px;
}

table,
th,
td {
    border: 1px solid #ccc;
}

th,
td {
    padding: 10px;
    text-align: left;
}

th {
    background-color: #f4f4f4;
}

td {
    background-color: #fff;
}
</style>