<template>
    <div class="container">
        <div class="main-container">
            <router-link to="/affiliate" class="add-link">
                <div class="row1">
                    <i class="fas fa-arrow-left"></i>
                    <h3 class="heading">Edit Affiliate</h3>
                </div>
            </router-link>

            <div class="row" style="margin-bottom: 5rem;">
                <div class="spinner2 d-flex justify-content-center" v-if="singleUserLoading">
                    <div class="spinner-border" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
                <div class="col-md-10" v-else>
                    <form @submit.prevent="CreateUsers" class="input-container">
                        <div class="parent-accordion p-3 mb-3" id="parent-accordion">
                            <p class="mb-0 color-red" v-if="errormessage">{{ errormessage }}</p>
                            <div class="mt-2 mb-2">
                                <label for="exampleFormControlInput1" class="form-label text mb-0 font-size">User
                                    Name</label>
                                <input type="text" class="form-control" id="userName" v-model="from.name"
                                    :class="{ 'is-invalid': errors.includes('Your User Name Is Required') }"
                                    placeholder="User Name">
                                <span v-if="errors.includes('Your User Name Is Required')" class="invalid-feedback">Your
                                    User Name Is Required</span>
                            </div>
                            <div class="mt-2 mb-2">
                                <label for="exampleFormControlInput1"
                                    class="form-label text mb-0 font-size">Email</label>
                                <input type="text" class="form-control" id="email" v-model="from.email"
                                    :class="{ 'is-invalid': errors.includes('Your Email Name Is Required') }"
                                    placeholder="Email">
                                <span v-if="errors.includes('Your Email Name Is Required')"
                                    class="invalid-feedback">Your
                                    Email Name Is Required</span>
                            </div>
                            <div class="mt-2 mb-2">
                                <label for="exampleFormControlInput1" class="form-label text mb-0 font-size">Phone
                                    Number</label>
                                <input type="text" class="form-control" id="email" v-model="from.phone"
                                    :class="{ 'is-invalid': errors.includes('Your Phone Number Is Required') }"
                                    placeholder="Phone Number">
                                <span v-if="errors.includes('Your Phone Number Is Required')"
                                    class="invalid-feedback">Your
                                    Phone Number Is Required</span>
                            </div>
                        </div>
                        <div class="parent-accordion p-3 mb-3" id="parent-accordion">
                            <div class="form-group mb-2">
                                <label for="role" class="form-label text mb-1">User Role</label>
                                <div class="input-icon">
                                    <select class="form-control form-select" id="role" v-model="from.role">
                                        <option value="" class="text2">Select a Role</option>
                                        <option value="Admin" class="text2">Admin</option>
                                        <option value="Project-Manager" class="text2">Project Manager</option>
                                        <option value="Project-Manager" class="text2">Team Lead</option>
                                        <option value="Team-Member" class="text2">Team Member</option>
                                        <option value="Affiliate" class="text2">Affiliate</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mt-2 mb-2">
                                <label for="exampleFormControlInput1" class="form-label text mb-0 font-size">Referral
                                    Number</label>
                                <input type="text" class="form-control" id="email" v-model="from.referral_id"
                                    placeholder="Referral Number" readonly>
                            </div>
                        </div>
                        <div class="parent-accordion p-3 mb-3" id="parent-accordion">
                            <div class="mb-2">
                                <label for="password" class="form-label text">Password*</label>
                                <div class="input-group">
                                    <input :type="showPassword ? 'text' : 'password'" class="form-control" id="password"
                                        v-model="from.password"
                                        :class="{ 'is-invalid': errors.includes('Your Password Is Required') }"
                                        placeholder="Password" />
                                    <span class="input-group-text" @click="togglePasswordVisibility">
                                        <i :class="showPassword ? 'fa fa-eye-slash' : 'fa fa-eye'"></i>
                                    </span>
                                </div>
                                <span v-if="errors.includes('Your Password Is Required')" class="invalid-feedback">
                                    Your Password Is Required
                                </span>
                            </div>

                            <div class="mb-2">
                                <label for="confirmPassword" class="form-label text">Confirm password*</label>
                                <div class="input-group">
                                    <input :type="showConfirmPassword ? 'text' : 'password'" class="form-control"
                                        id="confirmPassword" v-model="from.confirmPassword"
                                        :class="{ 'is-invalid': errors.includes('Your Confirm password Is Required') }"
                                        placeholder="Confirm password" />
                                    <span class="input-group-text" @click="toggleConfirmPasswordVisibility">
                                        <i :class="showConfirmPassword ? 'fa fa-eye-slash' : 'fa fa-eye'"></i>
                                    </span>
                                </div>
                                <span v-if="errors.includes('Your Confirm password Is Required')"
                                    class="invalid-feedback">
                                    Your Confirm password Is Required
                                </span>
                            </div>
                        </div>
                        <button class="save-btn text" :disabled="loading">
                            <span v-if="!loading">Update</span>
                            <span v-else class="spinner-border spinner-border-sm" role="status"
                                aria-hidden="true"></span>
                            <span class="visually-hidden">Loading...</span>
                        </button>
                    </form>
                </div>
                <div class="col-md-2">
                </div>
            </div>
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
                role: "",
                phone: "",
                referral_id: "",
                password: "",
                confirmPassword: "",
                position: "",
            },
            errors: [],
            loading: false,
            showPassword: false,
            showConfirmPassword: false,
            originalFrom: {}, // Store the initial state
            isFormDirty: false // Track form changes
        };
    },

    methods: {
        togglePasswordVisibility() {
            this.showPassword = !this.showPassword;
        },
        toggleConfirmPasswordVisibility() {
            this.showConfirmPassword = !this.showConfirmPassword;
        },
        ...mapActions('auth', ['fetchSingleUsers']),
        async CreateUsers() {
            this.errors = [];
            if (!this.from.name) this.errors.push('Your User Name Is Required');
            if (!this.from.email) this.errors.push('Your Email Name Is Required');
            if (!this.from.phone) this.errors.push('Your Phone Number Is Required');
            if (!this.$route.params.id) {
                if (this.from.password !== this.from.confirmPassword) {
                    this.errors.push('Passwords do not match');
                }
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
            formData.append('role', this.from.role);
            formData.append('position', 'Affiliate');
            if (!this.$route.params.id) {
                formData.append('password', this.from.password);
            }

            let url = config.apiBaseUrl + `update-user/${this.$route.params.id}`;
            const token = localStorage.getItem('token');
            try {
                await axios.post(url, formData, {
                    headers: {
                        'Authorization': `Bearer ${token}`,
                    }
                });

                this.$router.push('/affiliate');
                setTimeout(() => {
                    toast.success('Affiliate Update Successfully');
                }, 500);
                this.loading = false
            } catch (error) {
                console.error("API call error:", error);
                this.loading = false;
            }
        },
    },
    computed: {
        ...mapState('auth', ['singleUser', 'singleUserLoading']),
    },
    watch: {
        singleUser(newDetail) {
            if (newDetail) {
                this.from.name = newDetail.name || '';
                this.from.email = newDetail.email || '';
                this.from.role = newDetail.role || '';
                this.from.phone = newDetail.phone || '';
                this.from.position = newDetail.position || '';
                this.from.referral_id = newDetail.referral_id || '';
            }
        },
    },
    mounted() {
        if (this.$route.params.id) {
            this.fetchSingleUsers(this.$route.params.id);
        }
    },
};
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