<template>
    <div class="container">
        <div class="main-container">
            <router-link to="/tasks" class="add-link">
                <div class="row1">
                    <i class="fas fa-arrow-left"></i>
                    <h3 class="heading" v-if="this.$route.params.id">Edit Tasks</h3>
                    <h3 class="heading" v-else>Add Tasks</h3>
                </div>
            </router-link>
            <div class="spinner2 d-flex justify-content-center" v-if="singleTasksLoading">
                <div class="spinner-border" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
            <div class="row" v-else>
                <form @submit.prevent="CreateTasks()" novalidate>
                    <div class="col-md-10">
                        <div class="parent-accordion p-3 mb-3" id="parent-accordion">
                            <div class="mb-2">
                                <label for="businessName" class="form-label text">Tasks Name*</label>
                                <input type="text" class="form-control" v-model="from.name"
                                    :class="{ 'is-invalid': errors.includes('Your Tasks Name Is Required') }"
                                    id="businessName" placeholder="Tasks Name">
                                <span v-if="errors.includes('Your Tasks Name Is Required')"
                                    class="invalid-feedback">Your
                                    Tasks Name Is Required</span>
                            </div>
                            <div class="form-group mb-2">
                                <label for="licenseType" class="form-label text mb-1">Milestone*</label>
                                <div class="input-icon">
                                    <select class="form-control form-select" id="licenseType" v-model="from.milestoneId"
                                        :class="{ 'is-invalid': errors.includes('Your Milestone Name Is Required') }">
                                        <option value="" class="text2">Select a Milestone</option>
                                        <option :value="item.id" class="text2" v-for="item in allMileStone">{{ item.name
                                            }}</option>
                                    </select>
                                    <span v-if="errors.includes('Your Milestone Name Is Required')"
                                        class="invalid-feedback">Your Milestone Name Is Required</span>
                                </div>
                            </div>
                            <div class="form-group mb-2">
                                <label for="licenseType" class="form-label text mb-1">Assigned To*</label>
                                <div class="input-icon">
                                    <select class="form-control form-select" id="licenseType" v-model="from.userId"
                                        :class="{ 'is-invalid': errors.includes('Your Task Member Name Is Required') }">
                                        <option value="" class="text2">Select a Tasks Assigned To</option>
                                        <option :value="item.id" class="text2" v-for="item in allUser">{{ item.name }}
                                        </option>
                                    </select>
                                    <span v-if="errors.includes('Your Task Member Name Is Required')"
                                        class="invalid-feedback">Your Task Member Name Is Required</span>
                                </div>
                            </div>

                            <!-- Email field -->
                            <div class="mb-2">
                                <label for="businessName" class="form-label text">Email*</label>
                                <input type="email" class="form-control" v-model="from.email"
                                    :class="{ 'is-invalid': errors.includes('Your Email Is Required') }"
                                    id="businessName" placeholder="Email" :value="selectedUserEmail" readonly>
                            </div>

                            <div class="mb-2">
                                <label for="businessName" class="form-label text">Deadline*</label>
                                <input type="date" class="form-control" v-model="from.deadline"
                                    :class="{ 'is-invalid': errors.includes('Your Deadline Is Required') }"
                                    id="businessName" placeholder="Deadline">
                                <span v-if="errors.includes('Your Deadline Is Required')" class="invalid-feedback">Your
                                    Deadline Is Required</span>
                            </div>
                        </div>

                        <!-- password selection -->

                        <div class="parent-accordion p-3 mb-3" id="parent-accordion">
                            <div class="form-group mb-2">
                                <label for="licenseType" class="form-label text mb-1">Priority</label>
                                <div class="input-icon">
                                    <select class="form-control form-select" id="licenseType" v-model="from.priority"
                                        :class="{ 'is-invalid': errors.includes('Your Priority Selection Is Required') }">
                                        <option value="" class="text2">Select a Priority</option>
                                        <option value="urgent">Urgent-Priority</option>
                                        <option value="medium">Medium-Priority</option>
                                        <option value="lower">Lower-Priority</option>
                                    </select>
                                    <span v-if="errors.includes('Your Priority Selection Is Required')"
                                        class="invalid-feedback">Your Priority Selection Is Required</span>
                                </div>
                            </div>
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
import { mapActions, mapState } from 'vuex';
import config from '../../config';
import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';
export default {
    components: { QuillEditor },
    data() {
        return {
            from: {
                name: "",
                milestoneId: "",
                userId: "",
                deadline: "",
                priority: "",
                status: "",
                description: "",
                email: "",
                position: "",
            },
            errors: [],
            loading: false,
            originalFrom: {}, // Store the initial state
            isFormDirty: false // Track form changes
        };
    },
    methods: {
        ...mapActions('milestone', ['fetchGetAllMilestores']),
        ...mapActions('auth', ['fetchGetAllUsers']),
        ...mapActions('tasks', ['fetchSingleTasks']),
        async CreateTasks() {
            this.errors = [];
            if (!this.from.name) this.errors.push('Your Tasks Name Is Required');
            if (!this.from.milestoneId) this.errors.push('Your Milestone Name Is Required');
            if (!this.from.deadline) this.errors.push('Your Deadline Is Required');
            if (!this.from.userId) this.errors.push('Your Task Member Name Is Required');
            if (!this.from.priority) this.errors.push('Your Priority Selection Is Required');

            if (this.errors.length > 0) {
                console.log("Validation errors:", this.errors);
                return;
            }

            this.sendTasksEmail();
            // If no validation errors, proceed with the form submission
            this.loading = true;

            const formData = new FormData();
            formData.append('name', this.from.name);
            formData.append('milestoneId', this.from.milestoneId);
            formData.append('deadline', this.from.deadline);
            formData.append('userId', this.from.userId);
            formData.append('priority', this.from.priority);
            formData.append('status', this.from.status);
            formData.append('description', this.from.description);


            let url;
            if (this.$route.params.id) {
                url = config.apiBaseUrl + `update-task/${this.$route.params.id}`;
            } else {
                url = config.apiBaseUrl + `store-tasks`;
            }

            const token = localStorage.getItem('token');
            try {
                await axios.post(url, formData, {
                    headers: {
                        'Authorization': `Bearer ${token}`,
                    }
                });
                if (this.$route.params.id) {
                    setTimeout(() => {
                        toast.success('Your Task Update Successfully');
                        toast.success('Update Tasks Mail Is Send Successfully');
                    }, 500);
                } else {
                    setTimeout(() => {
                        toast.success('Your Task Created Successfully');
                        toast.success('New Tasks Mail Is Send Successfully');
                    }, 500);
                }
                this.$router.push('/tasks');
            } catch (error) {
                console.error("API call error:", error);
                this.loading = false;
            }
        },
        async sendTasksEmail() {
            const token = localStorage.getItem('token');
            try {
                const formData = new FormData();
                formData.append('name', this.from.name);
                formData.append('milestoneId', this.selectedMileStonePosition);
                formData.append('userId', this.from.userId);
                formData.append('deadline', this.from.deadline);
                formData.append('priority', this.from.priority);
                formData.append('status', this.from.status);
                formData.append('description', this.from.description);
                formData.append('email', this.selectedUserEmail);
                formData.append('userName', this.selectedUserName);  // Pass the name of the user
                formData.append('position', this.selectedUserPosition);  // Pass the position of the user

                const response = await axios.post('/api/send-task-email', formData, {
                    headers: {
                        'Authorization': `Bearer ${token}`,
                    }
                });
                console.log("Email sent successfully:", response.data.message);
                this.successMessage = response.data.message;
                this.errorMessage = '';
                this.$router.push('/tasks');
            } catch (error) {
                console.error("Error sending email:", error);
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
        ...mapState('milestone', ['allMileStone']),
        ...mapState('auth', ['allUser']),
        ...mapState('tasks', ['singleTasks', 'singleTasksLoading']),
        selectedUserEmail() {
            const selectedUser = this.allUser.find(user => user.id === this.from.userId);
            return selectedUser ? selectedUser.email : '';
        },
        selectedUserName() {
            const selectedUser = this.allUser.find(user => user.id === this.from.userId);
            return selectedUser ? selectedUser.name : '';
        },

        selectedUserPosition() {
            const selectedUser = this.allUser.find(user => user.id === this.from.userId);
            return selectedUser ? selectedUser.position : '';
        },
        selectedMileStonePosition() {
            const selectedMilestone = this.allMileStone.find(user => user.id === this.from.milestoneId);
            return selectedMilestone ? selectedMilestone.name : '';
        },
    },
    watch: {
        singleTasks(newDetail) {
            if (newDetail) {
                this.from.name = newDetail.name || '';
                this.from.userId = newDetail.userId || '';
                this.from.deadline = newDetail.deadline || '';
                this.from.milestoneId = newDetail.milestoneId || '';
                this.from.priority = newDetail.priority || '';
                this.from.status = newDetail.status || '';
                this.from.description = newDetail.description || '';
                this.from.email = newDetail.User_email || '';
            }
        },
        'from.name': 'checkFormDirty',
        'from.userId': 'checkFormDirty',
        'from.deadline': 'checkFormDirty',
        'from.milestoneId': 'checkFormDirty',
        'from.priority': 'checkFormDirty',
        'from.status': 'checkFormDirty',
        'from.description': 'checkFormDirty',
        'from.email': 'checkFormDirty',

    },

    mounted() {
        this.fetchGetAllMilestores();
        this.fetchGetAllUsers();
        if (this.$route.params.id) {
            this.fetchSingleTasks(this.$route.params.id)
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