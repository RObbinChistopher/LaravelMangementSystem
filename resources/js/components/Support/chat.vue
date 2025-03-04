<template>
    <div class="container extra-class-container" style="margin: 1.5rem 0px !important; padding: 0 2rem;">
        <div class="row">
            <div class="col-md-4 col-6 header-col">
                <h3 style="font-weight: 700;" class="m-0">Help Center</h3>
                <p style="font-size: small;">Your Success, Our Priority.</p>
            </div>
            <div class="col-md-8 col-6">
                <div class="btn-text m-0 add-new-cat " style="display: flex; justify-content: flex-end;">
                    <h3 class="heading">Support Forum</h3>
                </div>
            </div>
        </div>



        <!-- <div class="parent-accordion p-3 mb-3" id="parent-accordion">
            <div class="row">
                <div class="col-md-12 col-6 header-col">
                </div>
                <div style="text-align: center;">
                    <img src="../../../../public/Images/logo.png" style="width: 19%;" alt="">
                </div>
                <p class="support-text mb-0">Vise Tech Team – Here to Assist You with Anything, Anytime.</p>
                <small class="cational-line">Reliable. Responsive. Ready to Help.</small>
            </div>

        </div> -->
        <div class="spinner2 d-flex justify-content-center" v-if="ReplyLoading">
            <div class="spinner-border" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
        <div v-else>
            <div class="message-container">
                <!-- first Text messsage -->
                <div class="parent-accordion mb-3" style="overflow: hidden;" id="parent-accordion">
                    <div class="p-3 text-header">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="flex-between">
                                    <div class="d-flex gap-2">
                                        <div class="support-profile">
                                            <img src="../../../../public/Images/dLogo.jpg" style="width: 100%;" alt="">
                                        </div>
                                        <div>
                                            <p class="text mb-0">{{ this.AllTicketsReply.user_name }} | <samll>Agent
                                                </samll>
                                            </p>
                                            <p class="support-email mb-0">{{ this.AllTicketsReply.user_email }}</p>
                                        </div>
                                    </div>
                                    <p class="support-email">{{ this.AllTicketsReply.created_at }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="p-3" v-html="AllTicketsReply.message"></div>
                </div>
                <div v-for="item in reply">
                    <!-- user Text messsage -->
                    <div class="parent-accordion mb-3" style="overflow: hidden;" id="parent-accordion"
                        v-if="item.role === 'Affiliate'">
                        <div class="p-3 text-header">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="flex-between">
                                        <div class="d-flex gap-2">
                                            <div class="support-profile">
                                                <img src="../../../../public/Images/dLogo.jpg" style="width: 100%;"
                                                    alt="">
                                            </div>
                                            <div>
                                                <p class="text mb-0">{{ item.user_name }} | <samll>Agent</samll>
                                                </p>
                                                <p class="support-email mb-0">{{ item.user_email }}</p>
                                            </div>
                                        </div>
                                        <p class="support-email">{{ item.created_at }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="p-3" v-html="item.message"></div>
                    </div>
                    <!-- Admin Text messsage -->
                    <div class="parent-accordion mb-3" style="overflow: hidden;" id="parent-accordion"
                        v-if="item.role === 'Admin'">
                        <div class="p-3 admin-text-header">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="flex-between">
                                        <div class="d-flex gap-2">
                                            <div class="support-profile">
                                                <img src="../../../../public/Images/dLogo.jpg" style="width: 100%;"
                                                    alt="">
                                            </div>
                                            <div>
                                                <p class="text mb-0" style="color: white;">SUPPORT ADMIN | <samll>Admin
                                                    </samll>
                                                </p>
                                                <p class="admin-support-email mb-0">Vise Tech Team</p>
                                            </div>
                                        </div>
                                        <p class="admin-support-email">{{ item.created_at }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="p-3" v-html="item.message"></div>
                    </div>
                </div>

            </div>
            <!-- Quill Editor -->
            <form @submit.prevent="CreateTicket()" novalidate>
                <div class="parent-accordion mb-3" style="overflow: hidden; margin-bottom: 5rem !important;"
                    id="parent-accordion">
                    <div class="editor-container">
                        <quill-editor toolbar="full" v-model:content="from.message" :content-type="'html'"
                            class="custom-quill-editor" theme="snow"
                            :class="{ 'is-invalid': errors.includes('Your Message Is Required') }" />
                        <span v-if="errors.includes('Your Message Is Required')" class="invalid-feedback">Your Message
                            Is
                            Required</span>
                    </div>
                    <button type="submit" class="save-btn text">
                        <span v-if="!loading">Save</span>
                        <span v-else class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        <span class="visually-hidden">Loading...</span>
                    </button>
                </div>
            </form>
        </div>

    </div>
</template>
<script>
import { QuillEditor } from '@vueup/vue-quill'
import '@vueup/vue-quill/dist/vue-quill.snow.css'
import config from '../../config';
import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';
import { mapActions, mapState } from 'vuex/dist/vuex.cjs.js';
export default {
    components: { QuillEditor },
    data() {
        return {
            from: {
                ticket_id: '',
                message: '',
                status: '',
                Ticketstatus: '',
                role: '',
            },
            errors: [],
            loading: false,
        };
    },
    methods: {
        ...mapActions('support', ['fetchAllTicketsReply', 'fetchTicketReply']),
        async CreateTicket() {
            this.errors = [];
            if (!this.from.message) this.errors.push('Your Message Is Required');
            if (this.errors.length > 0) {
                console.log("Validation errors:", this.errors);
                return;
            }

            this.loading = true;

            const formData = new FormData();
            formData.append('message', this.from.message);
            formData.append('ticket_id', this.$route.params.id);
            formData.append('status', 'pending');
            if (this.profile && this.profile.role === 'Admin') {
                formData.append('Ticketstatus', 'Pending');
            } else {
                formData.append('Ticketstatus', 'Open');
            }
            formData.append('role', this.profile.role);

            let url = config.apiBaseUrl + `give-reply`;

            const token = localStorage.getItem('token');
            try {
                await axios.post(url, formData, {
                    headers: {
                        'Authorization': `Bearer ${token}`,
                    }
                });
                toast.success('Reply Send successfully.');
                // Clear the message field
                this.from.message = "";
                this.loading = false;
                this.fetchTicketReply(this.$route.params.id);
            } catch (error) {
                console.error("API call error:", error);
                this.loading = false;
            }
        },
    },

    computed: {
        ...mapState('support', ['AllTicketsReply', 'AllTicketsReplyLoading', 'reply', 'ReplyLoading']),
        ...mapState('auth', ['profile'])
    },

    mounted() {
        this.fetchAllTicketsReply(this.$route.params.id);
        this.fetchTicketReply(this.$route.params.id);
    }
}

</script>

<style scoped>
.main-containers {
    height: 100vh;
}

.editor-container {
    position: sticky;
    bottom: 0;
    padding: 1rem;
    box-shadow: 0 -2px 5px rgba(0, 0, 0, 0.1);
}

.message-container {
    overflow-y: auto;
}

.admin-support-email {
    font-size: small;
    color: white;
}

.admin-text-header {
    background: #99519e;
}

.text-header {
    background: #e9edf1;
}

.flex-between {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.support-email {
    font-size: small;
    color: #9f9f9f;
}

.support-profile {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    overflow: hidden;
}

.cational-line {
    text-align: center;
    font-size: smaller;
}

.support-text {
    text-align: center;
    font-size: 22px;
    font-weight: 900;
}

.extra-class-container {
    padding: 0 0 0 15px;
}

.role-selected {
    width: 46%;
    height: 38px !important;
    border: 2px solid #e9edf1 !important;
    box-shadow: none;
}

.active {
    text-decoration: none;
    border-radius: 6px;
    text-align: center;
    width: auto;
    padding: 3px 12px;
    background: #99519e !important;
    border: 1px solid #99519e;
    font-size: .8125rem;
    font-weight: 600;
    font-family: "Poppins", sans-serif;
    color: rgb(255 255 255);
}

.mr-text {
    font-size: 15px !important;
}

.save-btn {
    background: var(--viseTech);
    color: white !important;
    padding: 6px 15px;
    border-radius: 6px;
    margin-top: 1rem;
    margin-bottom: 1rem;
    margin-left: 1rem;
    border: none;
}

.save-btn:hover {
    background-color: var(--viseTechHover);
}

.save-btn::placeholder {
    background-color: var(--viseTechHover);
}

@media screen and (max-width: 600px) {
    .search-input {
        width: 100%;
        margin-bottom: 1rem;
    }

    .search-input .search-icon {
        top: 54%;
    }

    .heading {
        padding-left: 10px;
    }

    .extra-class-container {
        padding: 0 0 0 0;
    }
}
</style>