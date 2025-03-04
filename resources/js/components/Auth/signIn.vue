<template>
    <div class="container">
        <div class="offset-md-1 parent-accordion p-3 login_page" id="parent-accordion">
            <div class="p-3">
                <img class="logo" src="/Images/logo.png" alt="Vise Tech Logo" title="Vise Tech Logo" width="105px"
                    height="auto" />
                <div class="flex-col gap-0">
                    <p class="heading mb-0" style="font-size: 28px; font-weight:700;">Sign Up As Member</p>
                </div>
                <form @submit.prevent="CreateUsers" class="input-container">
                    <p class="mb-0 color-red" v-if="errormessage">{{ errormessage }}</p>
                    <div class="mt-2 mb-2">
                        <label for="exampleFormControlInput1" class="form-label text mb-0 font-size">First Name
                            *</label>
                        <input type="text" class="form-control" id="userName" v-model="from.name"
                            :class="{ 'is-invalid': errors.includes('Your First Name Is Required') }"
                            placeholder="First Name">
                        <span v-if="errors.includes('Your First Name Is Required')" class="invalid-feedback">Your
                            First Name Is Required</span>
                    </div>
                    <div class="mt-2 mb-2">
                        <label for="exampleFormControlInput1" class="form-label text mb-0 font-size">Last Name *</label>
                        <input type="text" class="form-control" id="userName" v-model="from.last_name"
                            :class="{ 'is-invalid': errors.includes('Your Last Name Is Required') }"
                            placeholder="Last Name">
                        <span v-if="errors.includes('Your Last Name Is Required')" class="invalid-feedback">Your
                            Last Name Is Required</span>
                    </div>
                    <div class="mt-2 mb-2">
                        <label for="exampleFormControlInput1" class="form-label text mb-0 font-size">Email *</label>
                        <input type="text" class="form-control" id="email" v-model="from.email"
                            :class="{ 'is-invalid': errors.includes('Your Email Name Is Required') }"
                            placeholder="Email">
                        <span v-if="errors.includes('Your Email Name Is Required')" class="invalid-feedback">Your
                            Email Name Is Required</span>
                    </div>
                    <div class="mt-2 mb-2">
                        <label for="exampleFormControlInput1" class="form-label text mb-0 font-size">Phone
                            Number *</label>
                        <input type="text" class="form-control" id="email" v-model="from.phone"
                            :class="{ 'is-invalid': errors.includes('Your Phone Number Is Required') }"
                            placeholder="Phone Number">
                        <span v-if="errors.includes('Your Phone Number Is Required')" class="invalid-feedback">Your
                            Phone Number Is Required</span>
                    </div>
                    <div class="mb-2">
                        <label for="password" class="form-label text">Password *</label>
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
                        <label for="confirmPassword" class="form-label text">Confirm password *</label>
                        <div class="input-group">
                            <input :type="showConfirmPassword ? 'text' : 'password'" class="form-control"
                                id="confirmPassword" v-model="from.confirmPassword"
                                :class="{ 'is-invalid': errors.includes('Your Confirm password Is Required') }"
                                placeholder="Confirm password" />
                            <span class="input-group-text" @click="toggleConfirmPasswordVisibility">
                                <i :class="showConfirmPassword ? 'fa fa-eye-slash' : 'fa fa-eye'"></i>
                            </span>
                        </div>
                        <span v-if="errors.includes('Your Confirm password Is Required')" class="invalid-feedback">
                            Your Confirm password Is Required
                        </span>
                    </div>
                    <button class="save-btn-login" :disabled="loading">
                        <span v-if="!loading">Submit</span>
                        <span v-else class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        <span class="visually-hidden">Loading...</span>
                    </button>
                    <router-link to="/" class="mt-3">
                        <button class="save-btn-sign mt-3">
                            <span>Already have an account? Login</span>
                        </button>
                    </router-link>
                </form>
            </div>
        </div>
        <!-- Popup Modal -->
        <div v-if="showPopup" class="popup-overlay">
            <div class="popup-content">
                <div class="close-icon" @click="closePopup">
                    <i class="fa-solid fa-circle-xmark"></i>
                </div>
                <div class="row p-0">
                    <div class="col-md-7 p-0">
                        <div style="text-align: left;">
                            <div class="p-3">
                                <p class="sale-markeing-text mb-2">Earn More as You Sell More <br> <span
                                        style="color: blueviolet;" class="font800">Simple & Rewarding!</span>
                                </p>
                                <p class="font800 mb-2" style="font-size: 29px;">Affiliate Commission Tiers:</p>
                                <li class="poptext mb-2"> Tier 0: Get Rs. <span class="font800"
                                        style="font-size: 17px;">
                                        6,500</span> on sales less then<span class="font800"> $349</span></li>
                                <li class="poptext mb-2"> Tier 1: Get Rs. <span class="font800"
                                        style="font-size: 17px;">
                                        10,000</span> on sale from <span class="font800">$350 - $649</span>
                                </li>
                                <li class="poptext mb-2"> Tier 2: Get Rs. <span class="font800"
                                        style="font-size: 17px;">16,500</span> on sale from <span class="font800"
                                        style="font-size: 17px;"> $650 - $999</span></li>
                                <li class="poptext mb-2"> Tier 3: Get Rs. <span class="font800"
                                        style="font-size: 17px;">
                                        22,500</span> on sale from <span class="font800" style="font-size: 17px;">
                                        $1000 -
                                        $1,399</span></li>
                                <li class="poptext mb-2"> Tier 4: Earn a massive <span class="font800"
                                        style="font-size: 17px;"> 7%</span> commission on sales above <span
                                        class="font800" style="font-size: 17px;">$1,400!</span> </li>
                            </div>

                            <div class="p-1" style="background-color: black;"></div>
                            <p class="font800 mb-0 mt-3" style="font-size: 29px; padding-left: 15px;">Start selling &
                                earning today!</p>
                            <div class="" style="padding-left: 15px;">
                                <p class="sale-markeing-text font800 mb-0" style="color: blueviolet; font-size: 28px;">
                                    Note:</p>
                                <p class="mb-1 poptext" style="font-size: 17px;">You can offer up to 15% discount to
                                    your customers &
                                    boost your sales!</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5 p-0" style="position: relative;">
                        <img src="Images/image.png" style="width: 124%" alt="" class="announding-image">
                        <div class="logo-image">
                            <img class="logo mb-0" src="/Images/logo.png" alt="Vise Tech Logo" style="width: 79%"
                                title="Visit Shopify website" width="105px" height="auto" />
                        </div>
                    </div>
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
                last_name: "",
                email: "",
                role: "",
                phone: "",
                password: "",
                confirmPassword: "",
                position: "",
            },
            errors: [],
            loading: false,
            showPassword: false,
            showConfirmPassword: false,
            originalFrom: {},
            isFormDirty: false,
            showPopup: true,
        };
    },

    methods: {
        togglePasswordVisibility() {
            this.showPassword = !this.showPassword;
        },
        toggleConfirmPasswordVisibility() {
            this.showConfirmPassword = !this.showConfirmPassword;
        },
        closePopup() {
            this.showPopup = false;
        },
        handleClickOutside(event) {
            const popup = document.querySelector(".popup-content");
            if (this.showPopup && popup && !popup.contains(event.target)) {
                this.closePopup();
            }
        },
        async CreateUsers() {
            this.errors = [];
            if (!this.from.name) this.errors.push('Your First Name Is Required');
            if (!this.from.last_name) this.errors.push('Your Last Name Is Required');
            if (!this.from.email) this.errors.push('Your Email Name Is Required');
            if (!this.from.phone) this.errors.push('Your Phone Number Is Required');
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
            formData.append('last_name', this.from.last_name);
            formData.append('email', this.from.email);
            formData.append('phone', this.from.phone);
            formData.append('role', 'Affiliate');
            formData.append('position', 'Affiliate');
            if (!this.$route.params.id) {
                formData.append('password', this.from.password);
            }


            let url = config.apiBaseUrl + `create-user`;
            try {
                await axios.post(url, formData);

                this.$router.push('/');
                setTimeout(() => {
                    toast.success('Sign In Successfully');
                }, 500);
                this.loading = false
            } catch (error) {
                console.error("API call error:", error);
                this.loading = false;
            }
        },
    },
    mounted() {
        document.addEventListener("click", this.handleClickOutside);
    },

    beforeUnmount() {
        document.removeEventListener("click", this.handleClickOutside);
    },
};
</script>


<style scoped>
.logo-image {
    position: absolute;
    top: 26.5rem;
    left: 83px;
}

.announding-image {
    width: 114% !important;
    position: absolute;
    top: 10px;
    right: 0;
}

.poptext {
    font-size: 16px;
    color: black;
    font-weight: 500;
}

.font800 {
    font-weight: 800 !important;
}

.sale-tire {
    text-decoration: underline;
}

.sale-markeing-text {
    font-size: 36px;
    font-weight: 600;
    color: black;
    line-height: 45px;
}

.signIn::placeholder {
    font-size: .8125rem;
}

.login_page {
    margin: 7.5rem auto !important;
    width: 35%;
}

.color-red {
    color: #d70000 !important;
}

.font-size {
    font-size: 13px !important;
}

.logo {
    margin-bottom: 1rem !important;
    width: 40%;
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
    /* Adjust the value as needed */
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

.popup-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 1000;
}

.popup-content {
    background: white;
    padding: 20px;
    border-radius: 8px;
    text-align: center;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
    width: 65%;
    background-image: url(/Images/popup.jpg)
}

.popup-content button {
    margin-top: 10px;
    padding: 8px 16px;
    background: #007bff;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.popup-content button:hover {
    background: #0056b3;
}

.close-icon {
    position: absolute;
    top: 10px;
    right: 15px;
    font-size: 24px;
    color: white;
    cursor: pointer;
}

.close-icon:hover {
    color: white;
}
</style>
