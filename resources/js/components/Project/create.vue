<template>
    <div class="container">
        <div class="main-container">
            <router-link to="/projects" class="add-link">
                <div class="row1">
                    <i class="fas fa-arrow-left"></i>
                    <h3 class="heading" v-if="this.$route.params.id">Edit Projects</h3>
                    <h3 class="heading" v-else>Add Projects</h3>
                </div>
            </router-link>
            <div class="spinner2 d-flex justify-content-center" v-if="singleProjectLoading">
                <div class="spinner-border" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
            <div class="row" v-else>
                <form @submit.prevent="CreateProject()" novalidate>
                    <div class="col-md-10">
                        <div class="parent-accordion p-3 mb-3" id="parent-accordion">
                            <div class="mb-2">
                                <label for="businessName" class="form-label text">Project Name*</label>
                                <input type="text" class="form-control" id="name" v-model="from.name"
                                    :class="{ 'is-invalid': errors.includes('Your Name Is Required') }"
                                    placeholder="User Name">
                                <span v-if="errors.includes('Your Name Is Required')" class="invalid-feedback">Your Name
                                    Is
                                    Required</span>
                            </div>
                            <div class="mb-2">
                                <label for="businessName" class="form-label text">Client Name*</label>
                                <input type="text" class="form-control" id="clientName" v-model="from.clientName"
                                    :class="{ 'is-invalid': errors.includes('Your Client Name Is Required') }"
                                    placeholder="Client Name">
                                <span v-if="errors.includes('Your Client Name Is Required')"
                                    class="invalid-feedback">Your
                                    Client Name Is Required</span>
                            </div>
                            <div class="mb-2">
                                <label for="businessName" class="form-label text">Deadline*</label>
                                <input type="date" class="form-control" id="clientName" v-model="from.deadline"
                                    :class="{ 'is-invalid': errors.includes('Your Deadline Is Required') }"
                                    placeholder="Deadline">

                                <span v-if="errors.includes('Your Deadline Is Required')" class="invalid-feedback">Your
                                    Deadline Is Required</span>
                            </div>
                        </div>

                        <!-- password selection -->

                        <div class="parent-accordion p-3 mb-3" id="parent-accordion">
                            <div class="form-group mb-2">
                                <label for="licenseType" class="form-label text mb-1">Status</label>
                                <div class="input-icon">
                                    <select class="form-control form-select" id="licenseType" v-model="from.percentage"
                                        :class="{ 'is-invalid': errors.includes('Your Status Is Required') }">
                                        <option value="" class="text2">Select a Status</option>
                                        <option value="100" class="text2">Completing &nbsp; 100%</option>
                                        <option value="90" class="text2">Testing &nbsp; 90%</option>
                                        <option value="70" class="text2">In Progress &nbsp; 70%</option>
                                        <option value="30" class="text2">Planning &nbsp; 30%</option>
                                        <option value="0" class="text2">Project Initiated &nbsp; 0%</option>
                                    </select>
                                    <span v-if="errors.includes('Your Status Is Required')"
                                        class="invalid-feedback">Your
                                        Status Is Required</span>
                                </div>
                            </div>
                        </div>
                        <div class="parent-accordion p-3 mb-3">
                            <div class="mb-2">
                                <label for="addressLine1" class="form-label text">Description</label>
                                <quill-editor toolbar="full" v-model:content="from.description" :content-type="'html'"
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
import '@vueup/vue-quill/dist/vue-quill.snow.css';
import config from '../../config';
import axios from 'axios';
import { mapState, mapActions } from 'vuex';
import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';
export default {
    components: { QuillEditor },
    data() {
        return {
            from: {
                name: "",
                clientName: "",
                deadline: "",
                percentage: "",
                description: "" // Added confirmPassword field
            },
            errors: [],
            loading: false,
            originalFrom: {}, // Store the initial state
            isFormDirty: false // Track form changes
        };
    },
    methods: {
        ...mapActions('project', ['fetchSingleProjects']),
        async CreateProject() {
            this.errors = [];
            if (!this.from.name) this.errors.push('Your Name Is Required');
            if (!this.from.clientName) this.errors.push('Your Client Name Is Required');
            if (!this.from.deadline) this.errors.push('Your Deadline Is Required');
            if (!this.from.percentage) this.errors.push('Your Status Is Required');

            if (this.errors.length > 0) {
                console.log("Validation errors:", this.errors);
                return;
            }

            // If no validation errors, proceed with the form submission
            this.loading = true;

            const formData = new FormData();
            formData.append('name', this.from.name);
            formData.append('clientName', this.from.clientName);
            formData.append('deadline', this.from.deadline);
            formData.append('percentage', this.from.percentage);
            formData.append('description', this.from.description);


            let url;
            if (this.$route.params.id) {
                url = config.apiBaseUrl + `update-project/${this.$route.params.id}`;
            } else {
                url = config.apiBaseUrl + `create-project`;
            }

            const token = localStorage.getItem('token');
            try {
                await axios.post(url, formData, {
                    headers: {
                        'Authorization': `Bearer ${token}`,
                    }
                });
                if (this.$route.params.id) {
                    this.$router.push('/projects');
                    setTimeout(() => {
                        toast.success('Your Projects Update Successfully');
                    }, 500);
                } else {
                    this.$router.push('/projects');
                    setTimeout(() => {
                        toast.success('Your Projects Created Successfully');
                    }, 500);
                }

            } catch (error) {
                console.error("API call error:", error);
                this.loading = false;
            }
        },
        checkFormDirty() {
            if (!this.$route.params.id) {
                this.isFormDirty = JSON.stringify(this.from) !== JSON.stringify(this.originalFrom);
            }
        },
    },

    computed: {
        ...mapState('project', ['singleProject', 'singleProjectLoading'])
    },
    watch: {
        singleProject(newDetail) {
            if (newDetail) {
                this.from.name = newDetail.name || '';
                this.from.clientName = newDetail.client_name || '';
                this.from.deadline = newDetail.deadline || '';
                this.from.percentage = newDetail.percentage || '';
                this.from.description = newDetail.description || '';
            }
        },
        // Track form changes and update the dirty status
        'from.name': 'checkFormDirty',
        'from.clientName': 'checkFormDirty',
        'from.deadline': 'checkFormDirty',
        'from.percentage': 'checkFormDirty',
        'from.description': 'checkFormDirty',
    },

    mounted() {
        if (this.$route.params.id) {
            this.fetchSingleProjects(this.$route.params.id)
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