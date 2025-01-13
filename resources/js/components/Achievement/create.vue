<template>
    <div class="container">
        <div class="main-container">
            <router-link to="/milestones" class="add-link">
                <div class="row1">
                    <i class="fas fa-arrow-left"></i>
                    <h3 class="heading" v-if="this.$route.params.id">Edit Milestones</h3>
                    <h3 class="heading" v-else>Add Milestones</h3>
                </div>
            </router-link>
            <div class="spinner2 d-flex justify-content-center" v-if="singleMileStoneLoading">
                <div class="spinner-border" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
            <div class="row" v-else>
                <form @submit.prevent="CreateMileStore()" novalidate>
                    <div class="col-md-10">
                        <div class="parent-accordion p-3 mb-3" id="parent-accordion">
                            <div class="mb-2">
                                <label for="businessName" class="form-label text">Name*</label>
                                <input type="text" class="form-control" id="businessName" v-model="from.name"
                                    :class="{ 'is-invalid': errors.includes('Your Milestones Name Is Required') }"
                                    placeholder="Milestones Name">
                                <span v-if="errors.includes('Your Milestones Name Is Required')"
                                    class="invalid-feedback">Your
                                    Milestones Name Is Required</span>
                            </div>
                            <div class="form-group mb-2">
                                <label for="licenseType" class="form-label text mb-1">Project Name</label>
                                <div class="input-icon">
                                    <select class="form-control form-select" id="licenseType" v-model="from.projectId"
                                        :class="{ 'is-invalid': errors.includes('Your Project Name Is Required') }">
                                        <option value="" class="text2">Select a Project Name</option>
                                        <option :value="item.id" class="text2" v-for="item in project">{{ item.name }}
                                        </option>
                                    </select>
                                    <span v-if="errors.includes('Your Project Name Is Required')"
                                        class="invalid-feedback">Your
                                        Project Name Is Required</span>
                                </div>
                            </div>
                            <div class="mb-2">
                                <label for="businessName" class="form-label text">Deadline*</label>
                                <input type="date" class="form-control" id="businessName" v-model="from.deadline"
                                    :class="{ 'is-invalid': errors.includes('Your Deadline Is Required') }"
                                    placeholder="Deadline">

                                <span v-if="errors.includes('Your Deadline Is Required')" class="invalid-feedback">Your
                                    Deadline Is Required</span>
                            </div>
                        </div>

                        <div class="parent-accordion p-3 mb-3" id="parent-accordion">
                            <div class="form-group mb-2">
                                <label for="licenseType" class="form-label text mb-1">Status</label>
                                <div class="input-icon">
                                    <select class="form-control form-select" id="licenseType" v-model="from.status">
                                        <option value="" class="text2">Select a Status</option>
                                        <option value="complete" class="text2">Complete</option>
                                        <option value="progress" class="text2">Progress</option>
                                        <option value="in-complete" class="text2">Incomplete</option>
                                    </select>
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
import { mapState, mapActions } from 'vuex/dist/vuex.cjs.js';
import config from '../../config';
import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';

export default {
    components: { QuillEditor },
    data() {
        return {
            from: {
                name: "",
                projectId: "",
                deadline: "",
                status: "",
                description: "" // Added confirmPassword field
            },
            originalFrom: {}, // Store the initial state
            errors: [],
            loading: false,
            isFormDirty: false // Track form changes
        };
    },
    methods: {
        ...mapActions('project', ['fetchAllProjects']),
        ...mapActions('milestone', ['fetchSingleMilestores']),
        async CreateMileStore() {
            this.errors = [];
            if (!this.from.name) this.errors.push('Your Milestones Name Is Required');
            if (!this.from.projectId) this.errors.push('Your Project Name Is Required');
            if (!this.from.deadline) this.errors.push('Your Deadline Is Required');

            if (this.errors.length > 0) {
                console.log("Validation errors:", this.errors);
                return;
            }

            this.loading = true;

            const formData = new FormData();
            formData.append('name', this.from.name);
            formData.append('projectId', this.from.projectId);
            formData.append('deadline', this.from.deadline);
            formData.append('status', this.from.status);
            formData.append('description', this.from.description);

            let url;
            if (this.$route.params.id) {
                url = config.apiBaseUrl + `update-milestore/${this.$route.params.id}`;
            } else {
                url = config.apiBaseUrl + `create-milestore`;
            }

            const token = localStorage.getItem('token');
            try {
                await axios.post(url, formData, {
                    headers: {
                        'Authorization': `Bearer ${token}`,
                    }
                });
                if (this.$route.params.id) {
                    this.$router.push('/milestones');
                    setTimeout(() => {
                        toast.success('Your Milestore Updated Successfully');
                    }, 500);
                } else {
                    this.$router.push('/milestones');
                    setTimeout(() => {
                        toast.success('Your Milestore Created Successfully');
                    }, 500);
                }

            } catch (error) {
                console.error("API call error:", error);
                this.loading = false;
            }
        },

        // Compare form data with the original data
        checkFormDirty() {
            this.isFormDirty = JSON.stringify(this.from) !== JSON.stringify(this.originalFrom);
        },
    },
    computed: {
        ...mapState('project', ['project', 'projectLoading']),
        ...mapState('milestone', ['singleMileStone', 'singleMileStoneLoading']),
    },
    watch: {
        singleMileStone(newDetail) {
            if (newDetail) {
                this.from.name = newDetail.name || '';
                this.from.projectId = newDetail.projectId || '';
                this.from.deadline = newDetail.deadline || '';
                this.from.status = newDetail.status || '';
                this.from.description = newDetail.description || '';
                this.originalFrom = { ...this.from }; // Store original form data
            }
        },
        // Track form changes and update the dirty status
        'from.name': 'checkFormDirty',
        'from.projectId': 'checkFormDirty',
        'from.deadline': 'checkFormDirty',
        'from.status': 'checkFormDirty',
        'from.description': 'checkFormDirty'
    },
    mounted() {
        if (this.$route.params.id) {
            this.fetchSingleMilestores(this.$route.params.id);
        }
        this.fetchAllProjects(1);

        // Save the original form data
        this.originalFrom = { ...this.from };
    },
    beforeRouteLeave(to, from, next) {
        if (this.isFormDirty) {
            const answer = window.confirm('You have unsaved changes, are you sure you want to leave?');
            if (answer) {
                next();
            } else {
                next(false); // Prevent navigation
            }
        } else {
            next(); // Proceed with navigation
        }
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
    margin: auto 6rem;
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