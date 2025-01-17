<template>
    <div class="container">
        <div class="main-container">
            <router-link to="/notification" class="add-link">
                <div class="row1">
                    <i class="fas fa-arrow-left"></i>
                    <h3 class="heading" v-if='this.$route.params.id'>Edit Notifications</h3>
                    <h3 class="heading" v-else>Add Notifications</h3>
                </div>
            </router-link>
            <div class="spinner2 d-flex justify-content-center" v-if="singleNotificationLoading">
                <div class="spinner-border" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
            <div class="row" v-else>
                <form @submit.prevent="sendEmail">
                    <div class="col-md-10">
                        <div class="parent-accordion p-3 mb-3" id="parent-accordion">
                            <p v-if="errorMessage" class="error">{{ errorMessage }}</p>
                            <div class="form-group mb-2">
                                <label for="licenseType" class="form-label text mb-1">User Name*</label>
                                <div class="input-icon">
                                    <select class="form-control form-select" id="licenseType" v-model="form.userId"
                                        @change="setEmail">
                                        <option value="" class="text2">Select a User Name</option>
                                        <option :value="item.id" class="text2" v-for="item in allUser">{{ item.name }}
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <div class="mb-2">
                                <label for="businessName" class="form-label text">Email*</label>
                                <input type="text" class="form-control" id="businessName" placeholder="Email"
                                    v-model="form.email" required>
                            </div>
                            <div class="mb-2">
                                <label for="businessName" class="form-label text">Subject*</label>
                                <input type="text" class="form-control" id="businessName" v-model="form.subject"
                                    required placeholder="Subject">
                            </div>
                        </div>
                        <div class="parent-accordion p-3 mb-3">
                            <div class="mb-2">
                                <label for="addressLine1" class="form-label text">Message</label>
                                <quill-editor toolbar="full" v-model:content="form.message" :content-type="'html'"
                                    class="custom-quill-editor" theme="snow" />

                            </div>
                        </div>

                        <button type="submit" class="save-btn text">
                            <span>Send</span>
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
import { QuillEditor } from '@vueup/vue-quill'
import '@vueup/vue-quill/dist/vue-quill.snow.css';
import config from '../../config';
import { mapActions, mapState } from 'vuex/dist/vuex.cjs.js';
export default {
    components: { QuillEditor },
    data() {
        return {
            form: {
                email: '',
                subject: '',
                message: '',
                userId: null,
            },
            successMessage: '',
            errorMessage: '',
            originalFrom: {}, // Store the initial state
            isFormDirty: false // Track form changes
        };
    },
    methods: {
        ...mapActions('auth', ['fetchGetAllUsers']),
        ...mapActions('notification', ['fetchSingleNotification']),
        setEmail() {
            const user = this.allUser.find(u => u.id === this.form.userId);
            if (user) {
                this.form.email = user.email;
            } else {
                this.form.email = '';
            }
        },
        async sendEmail() {
            const token = localStorage.getItem('token');
            try {
                if (this.$route.params.id) {
                    let url = config.apiBaseUrl +  `update-notification/${this.$route.params.id}`;
                    const response = await axios.post(url, this.form, {
                        headers: {
                            'Authorization': `Bearer ${token}`,
                        }
                    });
                } else {
                    const response = await axios.post('/api/send-email', this.form, {
                        headers: {
                            'Authorization': `Bearer ${token}`,
                        }
                    });
                    this.successMessage = response.data.success;
                    this.errorMessage = '';
                }

                this.$router.push('/notification');
            } catch (error) {
                this.errorMessage = error.response?.data?.message || 'Failed to send email.';
                this.successMessage = '';
            }
        },
        
        checkFormDirty() {
            if (!this.$route.params.id) {
                this.isFormDirty = JSON.stringify(this.from) !== JSON.stringify(this.originalFrom);
            }
        },
    },
    computed: {
        ...mapState('auth', ['allUser']),
        ...mapState('notification', ['singleNotification', 'singleNotificationLoading']),
    },
    watch: {
        singleNotification(newDetail) {
            if (newDetail) {
                this.form.email = newDetail.email || '';
                this.form.subject = newDetail.subject || '';
                this.form.message = newDetail.message || '';
                this.form.userId = newDetail.userId || '';
            }
        },
          // Track form changes and update the dirty status
          'form.email': 'checkFormDirty',
        'form.subject': 'checkFormDirty',
        'form.message': 'checkFormDirty',
        'form.userId': 'checkFormDirty',

    },
    mounted() {
        this.fetchGetAllUsers();
        if (this.$route.params.id) {
            this.fetchSingleNotification(this.$route.params.id);
        }
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