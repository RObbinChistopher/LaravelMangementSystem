<template>
    <div class="container">
        <div class="main-container">
            <router-link to="/team-name" class="add-link">
                <div class="row1">
                    <i class="fas fa-arrow-left"></i>
                    <h3 class="heading" v-if="this.$route.params.id">Edit Team Name</h3>
                    <h3 class="heading" v-else>Add Team Name</h3>
                </div>
            </router-link>
            <!-- Loading Spinner -->
            <div class="spinner2 d-flex justify-content-center" v-if="singleTeamloading">
                <div class="spinner-border" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
            <div class="row" v-else>
                <form @submit.prevent="CreateTeam()" novalidate>
                    <div class="col-md-10">
                        <div class="parent-accordion p-3 mb-3" id="parent-accordion">
                            <div class="mb-2">
                                <label for="businessName" class="form-label text">Team Name*</label>
                                <input type="text" class="form-control" id="businessName" placeholder="Team Name"
                                    v-model="from.team_name"
                                    :class="{ 'is-invalid': errors.includes('Your Team Name Is Required') }">
                                <span v-if="errors.includes('Your Team Name Is Required')" class="invalid-feedback">Your
                                    Team Name Is Required</span>
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
import { mapActions, mapState } from 'vuex/dist/vuex.cjs.js';
import config from '../../../config';
import axios from 'axios';
export default {
    data() {
        return {
            from: {
                team_name: "",
            },
            errors: [],
            loading: false,
            originalFrom: {}, // Store the initial state
            isFormDirty: false, // Track form changes
        };
    },
    methods: {
        ...mapActions('team', ['fetchSingleTeam']),
        async CreateTeam() {
            this.errors = [];
            if (!this.from.team_name) this.errors.push('Your Team Name Is Required');

            if (this.errors.length > 0) {
                console.log("Validation errors:", this.errors);
                return;
            }

            // If no validation errors, proceed with the form submission
            this.loading = true;

            const formData = new FormData();
            formData.append('team_name', this.from.team_name);
            let url;
            if (this.$route.params.id) {
                url = config.apiBaseUrl + `update-team/${this.$route.params.id}`;
            } else {
                url = config.apiBaseUrl + `store-team`;
            }

            const token = localStorage.getItem('token');
            try {
                await axios.post(url, formData, {
                    headers: {
                        'Authorization': `Bearer ${token}`,
                    }
                });
                if (this.$route.params.id) {
                    this.$router.push('/team-name');
                    setTimeout(() => {
                        toast.success('Team Name Update Successfully');
                    }, 500);
                } else {
                    this.$router.push('/team-name');
                    setTimeout(() => {
                        toast.success('Team Name Created Successfully');
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
        ...mapState('team', ['singleTeam', 'singleTeamloading']),
    },
    watch: {
        singleTeam(newDetail) {
            if (newDetail) {
                this.from.team_name = newDetail.team_name || '';
            }
        },
        // Track form changes and update the dirty status
        'from.client_name': 'checkFormDirty',

    },
    mounted() {
        if (this.$route.params.id) {
            this.fetchSingleTeam(this.$route.params.id)
        }
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