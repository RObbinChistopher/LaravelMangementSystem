<template>
    <div class="container">
        <div class="main-container">
            <router-link :to="{ name: 'TeamMemberName', params: { teamId: this.$route.params.teamId } }"
                class="add-link">
                <div class="row1">
                    <i class="fas fa-arrow-left"></i>
                    <h3 class="heading" v-if="this.$route.params.teamId && this.$route.params.id">Edit Team Members</h3>
                    <h3 class="heading" v-else>Add Team Members</h3>
                </div>
            </router-link>
            <!-- Loading Spinner -->
            <div class="spinner2 d-flex justify-content-center" v-if="singleTeamMemberLoading">
                <div class="spinner-border" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
            <div class="row" v-else>
                <form @submit.prevent="CreateTeamMembers()" novalidate>
                    <div class="col-md-10">
                        <div class="parent-accordion p-3 mb-3" id="parent-accordion">
                            <div class="form-group mb-2">
                                <label for="licenseType" class="form-label text mb-1">Team Name*</label>
                                <div class="input-icon">
                                    <input type="text" class="form-control" id="businessName" placeholder="Team Name"
                                        v-model="from.team_id" readonly>
                                </div>
                            </div>
                            <div class="form-group mb-2">
                                <label for="licenseType" class="form-label text mb-1">Member Name*</label>
                                <div class="input-icon">
                                    <select class="form-control form-select" id="licenseType" v-model="from.member_id"
                                        :class="{ 'is-invalid': errors.includes('Your Member Name Is Required') }">
                                        <option value="" class="text2">Select a Member Name</option>
                                        <option :value="item.id" class="text2" v-for="item in allUser">{{ item.name }}
                                        </option>
                                    </select>
                                    <span v-if="errors.includes('Your Member Name Is Required')"
                                        class="invalid-feedback">Your
                                        Member Name Is Required</span>
                                </div>
                            </div>
                            <div class="form-group mb-2">
                                <label for="licenseType" class="form-label text mb-1">Projects Name*</label>
                                <div class="input-icon">
                                    <select class="form-control form-select" id="licenseType" v-model="from.project_id"
                                        :class="{ 'is-invalid': errors.includes('Your Projects Name Is Required') }">
                                        <option value="" class="text2">Select a Projects Name</option>
                                        <option :value="item.id" class="text2" v-for="item in allProject">{{ item.name
                                            }}</option>
                                    </select>
                                    <span v-if="errors.includes('Your Projects Name Is Required')"
                                        class="invalid-feedback">Your
                                        Projects Name Is Required</span>
                                </div>
                            </div>
                        </div>
                        <div class="parent-accordion p-3 mb-3">
                            <div class="mb-2">
                                <label for="businessName" class="form-label text">Assigned Date*</label>
                                <input type="date" class="form-control" id="businessName" placeholder="Assigned Date"
                                    v-model="from.assigned_date"
                                    :class="{ 'is-invalid': errors.includes('Your Assigned Date Is Required') }">
                                <span v-if="errors.includes('Your Assigned Date Is Required')"
                                    class="invalid-feedback">Your
                                    Assigned Date Is Required</span>
                            </div>
                        </div>

                        <button type="submit" class="save-btn text">
                            <span>Save </span>
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
import { mapActions, mapState } from 'vuex';
import config from '../../../config';
import axios from 'axios';
export default {
    data() {
        return {
            from: {
                team_id: "",
                member_id: "",
                project_id: "",
                assigned_date: "",
            },
            errors: [],
            loading: false,
            originalFrom: {},
            isFormDirty: false,
        };
    },
    methods: {
        ...mapActions('team', ['showAllTeams', 'fetchSingleTeamMember', 'fetchSingleTeam']),
        ...mapActions('auth', ['fetchGetAllUsers']),
        ...mapActions('project', ['fetchGetAllProjects']),
        async CreateTeamMembers() {
            this.errors = [];
            if (!this.from.member_id) this.errors.push('Your Member Name Is Required');
            if (!this.from.project_id) this.errors.push('Your Projects Name Is Required');
            if (!this.from.assigned_date) this.errors.push('Your Assigned Date Is Required');

            if (this.errors.length > 0) {
                console.log("Validation errors:", this.errors);
                return;
            }

            // If no validation errors, proceed with the form submission
            this.loading = true;

            const formData = new FormData();
            formData.append('team_id', this.singleTeam.id);
            formData.append('member_id', this.from.member_id);
            formData.append('project_id', this.from.project_id);
            formData.append('assigned_date', this.from.assigned_date);
            let url;
            if (this.$route.params.teamId && this.$route.params.id) {
                url = config.apiBaseUrl + `update-team-membrs/${this.$route.params.id}`;
            } else {
                url = config.apiBaseUrl + `store-team-members`;
            }

            const token = localStorage.getItem('token');
            try {
                await axios.post(url, formData, {
                    headers: {
                        'Authorization': `Bearer ${token}`,
                    }
                });
                if (this.$route.params.teamId && this.$route.params.id) {
                    this.$router.push(`/team-members/${this.$route.params.teamId}`);
                    setTimeout(() => {
                        toast.success('Team Member Update Successfully');
                    }, 500);
                } else {
                    this.$router.push(`/team-members/${this.$route.params.teamId}`);
                    setTimeout(() => {
                        toast.success('Team Member Created Successfully');
                    }, 500);
                }

            } catch (error) {
                console.error("API call error:", error);
                this.loading = false;
            }
        },
    },
    watch: {
        singleTeamMember(newDetail) {
            if (newDetail) {
                this.from.team_id = newDetail.team || '';
                this.from.member_id = newDetail.member_id || '';
                this.from.project_id = newDetail.project_id || '';
                this.from.assigned_date = newDetail.assigned_date || '';
            }
        },
    },

    computed: {
        ...mapState('team', ['allTeams', 'allTeamloading', 'singleTeamMember', 'singleTeamMemberLoading', 'singleTeam', 'singleTeamloading']),
        ...mapState('auth', ['allUser']),
        ...mapState('project', ['allProject']),
    },

    mounted() {
        this.showAllTeams();
        this.fetchGetAllUsers();
        this.fetchGetAllProjects();
        if (this.$route.params.teamId) {
            this.fetchSingleTeam(this.$route.params.teamId)
        }
        if (this.$route.params.id) {
            this.fetchSingleTeamMember(this.$route.params.id)
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