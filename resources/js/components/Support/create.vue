<template>
    <div class="container">
        <div class="main-container">
            <router-link to="/support" class="add-link">
                <div class="row1">
                    <i class="fas fa-arrow-left"></i>
                    <h3 class="heading">Add Ticket</h3>
                </div>
            </router-link>

            <div class="row">
                <form @submit.prevent="CreateTicket()" novalidate>
                    <div class="col-md-10">
                        <div class="parent-accordion p-3 mb-3" id="parent-accordion">
                            <div class="mb-2">
                                <label for="businessName" class="form-label text">Subject*</label>
                                <input type="text" v-model="from.subject"
                                    :class="{ 'is-invalid': errors.includes('Your Subject Is Required') }"
                                    class="form-control" id="businessName" placeholder="Subject">
                                <span v-if="errors.includes('Your Subject Is Required')" class="invalid-feedback">Your
                                    Subject Is Required</span>
                            </div>
                        </div>
                        <div class="parent-accordion p-3 mb-3">
                            <div class="mb-2">
                                <label for="addressLine1" class="form-label text">Message</label>
                                <quill-editor toolbar="full" v-model:content="from.message" :content-type="'html'"
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
                </form>
                <div class="col-md-2">
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import { QuillEditor } from '@vueup/vue-quill'
import '@vueup/vue-quill/dist/vue-quill.snow.css'
import config from '../../config';
import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';
export default {
    components: { QuillEditor },
    data() {
        return {
            from: {
                subject: '',
                message: '',
            },
            errors: [],
            loading: false,
        };
    },
    methods: {
        async CreateTicket() {
            this.errors = [];
            if (!this.from.subject) this.errors.push('Your Subject Is Required');
            if (this.errors.length > 0) {
                console.log("Validation errors:", this.errors);
                return;
            }

            this.loading = true;

            const formData = new FormData();
            formData.append('subject', this.from.subject);
            formData.append('message', this.from.message);

            let url = config.apiBaseUrl + `create-ticket`;

            const token = localStorage.getItem('token');
            try {
                await axios.post(url, formData, {
                    headers: {
                        'Authorization': `Bearer ${token}`,
                    }
                });
                this.$router.push('/support');
                setTimeout(() => {
                    toast.success('Your Request is Send Successfully');
                }, 500);
                this.loading = false;
            } catch (error) {
                console.error("API call error:", error);
                this.loading = false;
            }
        },
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