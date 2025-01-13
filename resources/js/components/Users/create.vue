<template>
    <div class="container">
        <div class="main-container">
            <router-link to="/users" class="add-link">
                <div class="row1">
                    <i class="fas fa-arrow-left"></i>
                    <h3 class="heading" v-if="this.$route.params.id">Edit User</h3>
                    <h3 class="heading" v-else>Add Team Member</h3>
                </div>
            </router-link>
            <div v-if="filteredErrors.length" class="alert alert-danger">
                <ul>
                    <li v-for="(error, index) in filteredErrors" :key="index">{{ error }}</li>
                </ul>
            </div>
            <form @submit.prevent="CreateUsers()" novalidate>
                <div class="spinner2 d-flex justify-content-center" v-if="singleUserLoading">
                    <div class="spinner-border" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
                <div class="row" v-else>
                    <div class="col-md-10">
                        <div class="parent-accordion p-3 mb-3" id="user-info-accordion">
                            <div class="mb-2">
                                <label for="userName" class="form-label text">User Name*</label>
                                <input type="text" class="form-control" id="userName" v-model="from.name"
                                    :class="{ 'is-invalid': errors.includes('Your User Name Is Required') }"
                                    placeholder="User Name">
                                <span v-if="errors.includes('Your User Name Is Required')" class="invalid-feedback">Your
                                    User Name Is Required</span>
                            </div>
                            <div class="mb-2">
                                <label for="email" class="form-label text">Email*</label>
                                <input type="text" class="form-control" id="email" v-model="from.email"
                                    :class="{ 'is-invalid': errors.includes('Your Email Name Is Required') }"
                                    placeholder="Email">
                                <span v-if="errors.includes('Your Email Name Is Required')"
                                    class="invalid-feedback">Your
                                    Email Name Is Required</span>
                            </div>
                            <div class="form-group mb-2">
                                <label for="role" class="form-label text mb-1">User Role</label>
                                <div class="input-icon">
                                    <select class="form-control form-select" id="role" v-model="from.role">
                                        <option value="" class="text2">Select a Role</option>
                                        <option value="Admin" class="text2">Admin</option>
                                        <option value="Project-Manager" class="text2">Project Manager</option>
                                        <option value="Project-Manager" class="text2">Team Lead</option>
                                        <option value="Team-Member" class="text2">Team Member</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group mb-2">
                                <label for="userName" class="form-label text">User Position</label>
                                <input type="text" class="form-control" id="userName" v-model="from.position"
                                    placeholder="User Position">
                            </div>
                        </div>

                        <!-- password selection -->

                        <div class="parent-accordion p-3 mb-3" id="password-accordion" v-if="!this.$route.params.id">
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

                        <button type="submit" class="save-btn text">
                            <span v-if="!loading">Save</span>
                            <span v-else class="spinner-border spinner-border-sm" role="status"
                                aria-hidden="true"></span>
                            <span class="visually-hidden">Loading...</span>
                        </button>

                    </div>
                    <div class="col-md-2">
                    </div>
                </div>
            </form>
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
                password: "",
                confirmPassword: "",
                position: "",
            },
            errors: [],
            loading: false,
            showPassword: false,
            showConfirmPassword: false
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
            if (!this.from.role) this.errors.push('Your Role Is Required');
            if (!this.$route.params.id) {
                if (!this.from.password) this.errors.push('Your Password Is Required');
                if (!this.from.confirmPassword) this.errors.push('Confirm Password Is Required');
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
            formData.append('role', this.from.role);
            formData.append('position', this.from.position);
            if (!this.$route.params.id) {
                formData.append('password', this.from.password);
            }


            let url;
            if (this.$route.params.id) {
                url = config.apiBaseUrl + `update-user/${this.$route.params.id}`;
            } else {
                url = config.apiBaseUrl + `create-user`;
            }

            const token = localStorage.getItem('token');
            try {
                await axios.post(url, formData, {
                    headers: {
                        'Authorization': `Bearer ${token}`,
                    }
                });
                if (this.$route.params.id) {
                    this.$router.push('/users');
                    setTimeout(() => {
                        toast.success('Your User Update Successfully');
                    }, 500);
                } else {
                    this.$router.push('/users');
                    setTimeout(() => {
                        toast.success('Your User Created Successfully');
                    }, 500);
                }

            } catch (error) {
                console.error("API call error:", error);
                this.loading = false;
            }
        },
    },
    computed: {
        ...mapState('auth', ['singleUser', 'singleUserLoading']),
        filteredErrors() {
            return this.errors.filter(error =>
                error === 'Passwords do not match' || error === 'Your Role Is Required'
            );
        }
    },
    watch: {
        singleUser(newDetail) {
            if (newDetail) {
                this.from.name = newDetail.name || '';
                this.from.email = newDetail.email || '';
                this.from.role = newDetail.role || '';
                this.from.position = newDetail.position || '';
            }
        },

    },
    mounted() {
        if (this.$route.params.id) {
            this.fetchSingleUsers(this.$route.params.id);
        }

    }

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