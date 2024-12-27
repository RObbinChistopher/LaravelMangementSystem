<template>
    <div class="container">
        <div class="offset-md-1 parent-accordion p-3 login_page" id="parent-accordion">
            <div class="p-3">
                <img
                    class="logo"
                    src="/images/logo.png"
                    alt="A picture or an image of Shopify logo for desktop"
                    title="Visit Shopify website"
                    width="105px"
                    height="auto"
                />
                <div class="flex-col gap-0">
                    <p class="heading mb-0" style="font-size: 28px; font-weight:700;">Sign in</p>
                    <p class="text">Continue to ViseTech</p>
                </div>
                <!-- <form @submit.prevent="onSubmitLoginForm" class="input-container"> -->
                    <!-- <p class="mb-0 color-red" v-if="errormessage">{{ errormessage }}</p> -->
                    <div class="mt-2 mb-2">
                        <label for="exampleFormControlInput1" class="form-label text mb-0 font-size">User Name</label>
                        <input type="text" class="form-control signIn" id="exampleFormControlInput1"
                               placeholder="User Name" v-model="credentials.email" style="box-shadow: none;">
                    </div>
                    <div class="mt-2 mb-2">
                        <label for="exampleFormControlInput1" class="form-label text mb-0 font-size">Email</label>
                        <input type="text" class="form-control signIn" id="exampleFormControlInput1"
                               placeholder="Email" v-model="credentials.email" style="box-shadow: none;">
                    </div>
                    <div class="mt-2 mb-2">
                        <label for="exampleFormControlInput1" class="form-label text mb-0 font-size">Password</label>
                        <input type="text" class="form-control signIn" id="exampleFormControlInput1"
                               placeholder="Password" v-model="credentials.email" style="box-shadow: none;">
                    </div>
                    <div class="mt-2 mb-2">
                        <label for="exampleFormControlInput1" class="form-label text mb-0 font-size">Confirm password</label>
                        <input type="text" class="form-control signIn" id="exampleFormControlInput1"
                               placeholder="Confirm password" v-model="credentials.password" style="box-shadow: none">
                    </div>
                    <!-- <button class="save-btn-login" :disabled="loading">
                        <span v-if="!loading">Continue with email</span>
                        <span v-else class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        <span class="visually-hidden">Loading...</span>
                    </button> -->
                    <button class="save-btn-login mb-2">
                        <span>Sign In</span>
                    </button>
                <!-- </form> -->
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
        };
    },
    methods: {
    },
};
</script>


<style scoped>
.signIn::placeholder{
    font-size: .8125rem;
}
.login_page{
    margin: 7.5rem auto 0 39.6rem !important;
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
    opacity: 0.8; /* Adjust the value as needed */
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
.save-btn-sign > a{
    text-decoration: none;
    color: #1554dd !important;
}
.text{
    color: #626262;
    font-size: .8125rem;
    font-weight: 550;
}
</style>
