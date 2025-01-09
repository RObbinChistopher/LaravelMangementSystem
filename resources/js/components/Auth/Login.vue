<template>
    <div class="container">
        <div class="offset-md-1 parent-accordion p-3 login_page" id="parent-accordion">
            <div class="p-3">
                <img class="logo" src="/Images/logo.png" alt="A picture or an image of Shopify logo for desktop"
                    title="Visit Shopify website" width="105px" height="auto" />
                <div class="flex-col gap-0">
                    <p class="heading mb-0" style="font-size: 28px; font-weight:700;">Log in</p>
                    <p class="text">Continue to ViseTech</p>
                </div>
                <form @submit.prevent="onSubmitLoginForm" class="input-container">
                    <p class="mb-0 color-red" v-if="errormessage">{{ errormessage }}</p>
                    <div class="mt-2 mb-2">
                        <label for="exampleFormControlInput1" class="form-label text mb-0 font-size">Email</label>
                        <input type="text" class="form-control" id="exampleFormControlInput1" placeholder=""
                            v-model="credentials.email" style="box-shadow: none;">
                    </div>
                    <div class="mt-2 mb-2">
                        <label for="exampleFormControlInput1" class="form-label text mb-0 font-size">Password</label>
                        <input type="text" class="form-control" id="exampleFormControlInput1" placeholder=""
                            v-model="credentials.password" style="box-shadow: none">
                    </div>
                    <button class="save-btn-login mb-2" :disabled="loading">
                        <span v-if="!loading">Continue with email</span>
                        <span v-else class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        <span class="visually-hidden">Loading...</span>
                    </button>
                    <!-- <button class="">
                    <span>Continue with email</span>
                </button> -->
                    <!-- <router-link to="/sign-in">
                    <button class="save-btn-sign">
                        <span>Sign In</span>
                    </button>
                </router-link> -->

                </form>
            </div>
        </div>
    </div>
</template>

<script>
import {mapState, mapActions} from 'vuex';

export default {
    name: "Login",
    data() {
        return {
            credentials: {
                email: '',
                password: ''
            },
            errormessage: '',
            loading: false
        };
    },

    computed: {
        ...mapState('auth', ['isAuthenticated', 'user']),
    },
    methods: {
        ...mapActions('auth', ['login']),
        async onSubmitLoginForm() {
            this.loading = true;
            const {success, message, error, user} = await this.login(this.credentials);
            if (success) {
                    const redirect = this.$route.query.redirect || '/dashboard'; // Default to dashboard if no redirect
                    this.$router.push(redirect);
                    // this.fetchTotalOrder();
            } else {
                if (error.response && error.response.status === 401) {
                    this.errormessage = "Invalid Email OR Password";
                }else {
                    this.errormessage = error.response ? error.response.data.message : "An unknown error occurred.";
                }
                console.log('Error:', error.response ? error.response.data.message : error);
            }
            this.loading = false;
        }
    },
};
</script>



<style scoped>
.login_page {
    margin: 7.5rem auto !important;
    width: 30%;
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

@media screen and (max-width: 600px) {
    .login_page {
        margin: 7.5rem auto !important;
        width: 100%;
    }
}
</style>
