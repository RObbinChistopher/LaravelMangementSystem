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

            <div class="spinner2 d-flex justify-content-center" v-if="singleServiceDetailsLoading">
                <div class="spinner-border" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
            <div class="row" v-else>
                <form @submit.prevent="CreateService()" novalidate>
                    <div class="col-md-10">
                        <div class="parent-accordion p-3 mb-3" id="parent-accordion">
                            <div class="mb-2">
                                <label for="businessName" class="form-label text">Service Name*</label>
                                <input type="text" class="form-control" id="businessName" v-model="from.name"
                                    :class="{ 'is-invalid': errors.includes('Your Service Name Is Required') }"
                                    placeholder="Service Name">
                                <span v-if="errors.includes('Your Service Name Is Required')"
                                    class="invalid-feedback">Your Service Name Is Required</span>
                            </div>
                            <div class="mb-2">
                                <label for="businessName" class="form-label text">Service Price*</label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon1">$</span>
                                    <input type="text" class="form-control" aria-label="Username"
                                        aria-describedby="basic-addon1" v-model="from.price"
                                        :class="{ 'is-invalid': errors.includes('Your Service Price Is Required') }"
                                        placeholder="Service Price">
                                    <span v-if="errors.includes('Your Service Price Is Required')"
                                        class="invalid-feedback">Your Service Price Is Required</span>
                                </div>

                            </div>
                            <div class="mb-2">
                                <label for="businessName" class="form-label text">Service Tax</label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon1">%</span>
                                    <input type="text" class="form-control" v-model="from.tax" placeholder="Service Tax"
                                        aria-label="Username" aria-describedby="basic-addon1">
                                </div>
                            </div>
                        </div>


                        <button type="submit" class="save-btn text">
                            <span v-if="!loading">Save</span>
                            <span v-else class="spinner-border spinner-border-sm" role="status"
                                aria-hidden="true"></span>
                            <span class="visually-hidden">Loading...</span>
                        </button>
                    </div>
                </form>
                <div class="col-md-2">
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import config from '../../../config';
import axios from 'axios';
import { mapState, mapActions } from 'vuex';
import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';
export default {
    data() {
        return {
            from: {
                name: "",
                price: "",
                tax: "",
            },
            errors: [],
            loading: false,
            invoiceUrl: null,
        };
    },
    methods: {
        ...mapActions('service', ['fetchSingleServices', 'fetchSingleServicesDetails']),
        async CreateService() {
            this.errors = [];
            if (!this.from.name) this.errors.push('Your Service Name Is Required');
            if (!this.from.price) this.errors.push('Your Service Price Is Required');

            if (this.errors.length > 0) {
                console.log("Validation errors:", this.errors);
                return;
            }

            // If no validation errors, proceed with the form submission
            this.loading = true;

            const formData = new FormData();
            formData.append('name', this.from.name);
            formData.append('price', this.from.price);
            formData.append('tax', this.from.tax);

            let url;
            if (this.$route.params.id) {
                url = config.apiBaseUrl + `update-services-details/${this.$route.params.id}`;
            } else {
                url = config.apiBaseUrl + `store-services-details`;
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

    },
    watch: {
        singleServiceDetails(newDetail) {
            if (newDetail) {
                this.from.name = newDetail.name || '';
                this.from.price = newDetail.price || '';
                this.from.tax = newDetail.tax || '';
            }
        },
    },
    computed: {
        ...mapState('service', ['singleServiceDetails', 'singleServiceDetailsLoading'])
    },

    mounted(){
        if(this.$route.params.id){
            this.fetchSingleServicesDetails(this.$route.params.id)
        }
    }   
}
</script>
<style scoped>
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