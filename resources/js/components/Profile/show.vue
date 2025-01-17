<template>
    <div class="container">
        <div class="main-container">
            <div @click="goBack" class="add-link">
                <div class="row1" style="cursor: pointer;">
                    <i class="fas fa-arrow-left"></i>
                    <h3 class="heading">Update Profile</h3>
                </div>
            </div>
            <div class="spinner2 d-flex justify-content-center" v-if="isAuthenticated">
                <div class="spinner-border" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
            <div class="row" v-else>

                <div class="col-md-8">
                    <form @submit.prevent="UpdateProfile()" novalidate>
                        <div class="parent-accordion p-3 mb-3" id="parent-accordion">
                            <div class="mb-2 flex-col gap-0">
                                <div class="preview text mt-3">Preview</div>
                                <img v-if="previewImage" :src="previewImage"
                                    style="width: 25%; margin-top: 10px; margin-bottom: 2rem;">
                                <br>
                                <img :src="profile.profile ? profile.profile : '/Images/logo.png'" v-if="profile"
                                    style="width: 25%; margin-top: 10px; margin-bottom: 1rem">

                                <br>
                                <label for="exampleFormControlInput1" class="form-label text">Profile Image</label>
                                <div class="Media">
                                    <div class="d-flex">
                                        <a @click="triggerFileUpload" class="import2 upload">Upload new</a>
                                        <p class="text"
                                            style="color: #343434 !important; margin: auto; padding-left: 10px">
                                            {{ selectedFileName || 'Select existing' }}
                                        </p>
                                    </div>
                                    <input type="file" ref="fileInput" style="display: none"
                                        @change="handleFileUpload" />
                                    <p class="text mt-2">Accepts images only...</p>
                                </div>
                            </div>
                            <div class="mb-2">
                                <label for="businessName" class="form-label text">User Name*</label>
                                <input type="text" class="form-control" id="businessName" v-model="from.name"
                                    v-if="profile" :class="{ 'is-invalid': errors.includes('Your Name Is Required') }"
                                    placeholder="User Name">
                                <span v-if="errors.includes('Your Name Is Required')" class="invalid-feedback">Your Name
                                    Is
                                    Required</span>
                            </div>
                            <div class="mb-2">
                                <label for="businessName" class="form-label text">Email*</label>
                                <input type="Email" class="form-control" id="businessName" v-model="from.email"
                                    v-if="profile" :class="{ 'is-invalid': errors.includes('Your Email Is Required') }"
                                    placeholder="Email">
                                <span v-if="errors.includes('Your Email Is Required')" class="invalid-feedback">Your
                                    Email
                                    Is Required</span>
                            </div>
                            <div class="mb-2">
                                <label for="businessName" class="form-label text">Phone Number*</label>
                                <input type="Number" class="form-control" id="businessName" v-model="from.phone"
                                    v-if="profile" placeholder="Phone Number">
                            </div>
                        </div>

                        <!-- password selection -->

                        <button type="submit" class="save-btn text">
                            <span v-if="!loading">Update</span>
                            <span v-else class="spinner-border spinner-border-sm" role="status"
                                aria-hidden="true"></span>
                            <span class="visually-hidden">Loading...</span>
                        </button>
                    </form>
                </div>

                <div class="col-md-4">
                    <form @submit.prevent="updatePasswordUser()" novalidate>
                        <div class="parent-accordion p-3 mb-3" id="parent-accordion">
                            <label for="businessName" class="form-label heading mb-2" style="font-size: 16px;">Update Password:</label>
                            <div class="mb-2">
                                <label for="businessName" class="form-label text">Password*</label>
                                <input type="text" class="form-control" id="businessName" placeholder="Password"
                                    v-model="new_password">
                            </div>
                            <div class="mb-2">
                                <label for="businessName" class="form-label text">Confirm password*</label>
                                <input type="text" class="form-control" id="businessName" placeholder="Confirm password"
                                    v-model="confirm_password">
                            </div>
                        </div>
                        <button type="submit" class="save-btn text" style="margin-left: 0.5rem !important;"
                            :disabled="passwordLoading">
                            <span v-if="passwordLoading" class="spinner-border spinner-border-sm" role="status"
                                aria-hidden="true"></span>
                            <span v-else>Update</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import { mapActions, mapState } from 'vuex/dist/vuex.cjs.js';
import config from '../../config';
import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';
export default {
    data() {
        return {
            previewImage: null,
            loading: false, // Loading state
            selectedFileName: '',
            errors: [],
            loading: false,
            from: {
                name: '',
                email: '',
                phone: '',
                image: '',
            }
        }
    },
    methods: {
        ...mapActions('auth', ['fetchloginUser', 'updatePassword']),
        triggerFileUpload() {
            this.$refs.fileInput.click();
        },
        goBack() {
            this.$router.go(-1);
        },
        handleFileUpload(event) {
            const file = event.target.files[0];
            if (file) {
                this.selectedFileName = file.name;
                this.previewImage = URL.createObjectURL(file);
                this.from.image = file;  // Corrected this line
            }
        },
        async UpdateProfile() {
            this.errors = [];
            if (!this.from.name) this.errors.push('Your Name Is Required');
            if (!this.from.email) this.errors.push('Your Email Is Required');

            if (this.errors.length > 0) {
                console.log("Validation errors:", this.errors);
                return;
            }

            // If no validation errors, proceed with the form submission
            this.loading = true;

            const formData = new FormData();
            formData.append('name', this.from.name);
            formData.append('email', this.from.email);
            formData.append('phone', this.from.phone);
            if (this.from.image) {
                formData.append('image', this.from.image);
            }

            let url = config.apiBaseUrl + `user-profile`;

            const token = localStorage.getItem('token');
            try {
                await axios.post(url, formData, {
                    headers: {
                        'Authorization': `Bearer ${token}`,
                    }
                });
                toast.success('Your Profile Update Successfully');
                this.previewImage = null,
                    this.selectedFileName = '',
                    this.loading = false;
                this.fetchloginUser();
            } catch (error) {
                console.error("API call error:", error);
                this.loading = false;
            }
        },
        updatePasswordUser() {
            if (this.new_password !== this.confirm_password) {
                console.log('password not match')
                toast.error('Passwords Are Not Match!');
                return;
            }
            if (!this.new_password || !this.confirm_password) {
                toast.error('Please enter both new and confirm passwords.');
                return;
            }
            this.updatePassword(this.new_password);
            toast.success('Your Password Update Successfully');
        },
    },
    computed: {
        ...mapState('auth', ['profile', 'profileLoading', 'passwordLoading'])
    },
    watch: {
        profile(newDetail) {
            if (newDetail) {
                this.from.name = newDetail.name || '';
                this.from.email = newDetail.email || '';
                this.from.phone = newDetail.phone || '';
                this.from.image = newDetail.image || '';
            }
        },

    },
    mounted() {
        this.fetchloginUser();
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

.Media {
    width: 100%;
    padding: .375rem .75rem;
    font-size: 0.9rem;
    font-weight: 400;
    line-height: 1.3;
    color: var(--bs-body-color);
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    background-color: var(--bs-body-bg);
    background-clip: padding-box;
    border: 1px dashed #8a8a8a !important;
    border-radius: 8px;
    height: 120px;
    text-align: center;
    transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
}

@media screen and (max-width: 600px) {
    .main-container {
        margin: auto 2rem !important;
    }

    .save-btn-2 {
        margin-top: 0rem;
        margin-bottom: 1rem;
    }
}
</style>