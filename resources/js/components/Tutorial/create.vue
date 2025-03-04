<template>
    <div class="container">
        <div class="main-container">
            <router-link to="/tutorial" class="add-link">
                <div class="row1">
                    <i class="fas fa-arrow-left"></i>
                    <h3 class="heading" v-if="this.$route.params.id">Edit Tutorial</h3>
                    <h3 class="heading" v-else>Add Tutorial</h3>
                </div>
            </router-link>

            <div class="row">
                <div class="col-md-12">
                    <form @submit.prevent="CreateProject()" novalidate>
                        <div class="parent-accordion p-3 mb-3" id="parent-accordion">
                            <div class="mb-2">
                                <label for="businessName" class="form-label text">Urdu Tutorial*</label>
                                <input type="text" class="form-control" id="clientName" v-model="from.urdu_link"
                                    placeholder="Urdu Tutorial">
                            </div>
                            <div class="mb-2">
                                <label for="businessName" class="form-label text">English Tutorial*</label>
                                <input type="text" class="form-control" id="clientName" v-model="from.english_link"
                                    placeholder="English Tutorial">
                            </div>
                        </div>
                        <button type="submit" class="save-btn text">
                            <span v-if="!loading">Save</span>
                            <span v-else class="spinner-border spinner-border-sm" role="status"
                                aria-hidden="true"></span>
                            <span class="visually-hidden">Loading...</span>
                        </button>
                    </form>
                </div>
                <div class="col-md-6">
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';
import { mapActions, mapState } from 'vuex';
import config from '../../config';
export default {
    data() {
        return {
            from: {
                urdu_link: "",
                english_link: "",
            },
            errors: [],
            loading: false,
        };
    },
    methods: {
        ...mapActions('tutorial', ['fetchSingleTutorial']),
        async CreateProject() {
            this.errors = [];

            if (this.errors.length > 0) {
                console.log("Validation errors:", this.errors);
                return;
            }
            this.loading = true;

            const formData = new FormData();
            formData.append('urdu_link', this.from.urdu_link);
            formData.append('english_link', this.from.english_link);


            let url;
            if (this.$route.params.id) {
                url = config.apiBaseUrl + `update-tutorial/${this.$route.params.id}`;
            } else {
                url = config.apiBaseUrl + `create-tutorial`;
            }

            const token = localStorage.getItem('token');
            try {
                await axios.post(url, formData, {
                    headers: {
                        'Authorization': `Bearer ${token}`,
                    }
                });
                if (this.$route.params.id) {
                    this.$router.push('/tutorial');
                    setTimeout(() => {
                        toast.success('Your Tutorial Link Update Successfully');
                    }, 500);
                } else {
                    this.$router.push('/tutorial');
                    setTimeout(() => {
                        toast.success('Your Tutorial Link Created Successfully');
                    }, 500);
                }

            } catch (error) {
                console.error("API call error:", error);
                this.loading = false;
            }
        },
    },
    computed: {
        ...mapState('tutorial', ['singleUrl', 'singleUrlLoading']),
    },
    watch: {
        singleUrl(newDetail) {
            if (newDetail) {
                this.from.urdu_link = newDetail.urdu_link || '';
                this.from.english_link = newDetail.english_link || '';
            }
        },
    },
    mounted() {
        if (this.$route.params.id) {
            this.fetchSingleTutorial(this.$route.params.id);
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