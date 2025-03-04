<template>
    <div class="container extra-class-container" style="margin: 1.5rem 0px !important; padding: 0 1rem;">
        <div class="row">
            <div class="col-md-4 col-6 header-col">
                <h3 class="heading">Tutorial</h3>
            </div>
            <div class="col-md-8 col-6">
                <div class="btn-text m-0 add-new-cat " style="display: flex; justify-content: flex-end;">
                    <router-link to="/tutorial-create" class="import2 add-cc hover-cc"  v-if="profile.role === 'Admin'">Add</router-link>
                </div>
            </div>
        </div>


        <div class="parent-accordion p-3" id="parent-accordion">
            <div class="row">
                <div class="col-md-6 col-12 left-side-filttle">
                    <!-- Status Filter -->
                    <div class="status-filter d-flex">
                    </div>

                </div>
                <div class="col-md-6 col-12 right-side-search mb-2">
                    <!-- <div class="search-input position-relative">
                        <input type="text" class="form-control" placeholder="Search..." />
                        <i class="fa fa-search position-absolute search-icon"></i>
                    </div> -->
                </div>
            </div>
            <hr style="margin-top: 0 !important;">
            <!-- Loading Spinner -->
            <div class="spinner2 d-flex justify-content-center" v-if="urlLoading">
                <div class="spinner-border" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
            <div v-else>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Urdu Tutorial Link</th>
                                <th scope="col">English Tutorial Link</th>
                                <th scope="col" v-if="profile.role === 'Admin'">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(item, index) in url">
                                <th scope="row">{{ index + 1 }}</th>
                                <td class="text2">
                                    <a :href="item.urdu_link" target="_blank">
                                        {{ shortenUrl(item.urdu_link) }}
                                    </a>
                                </td>
                                <td class="text2">
                                    <a :href="item.english_link" target="_blank">
                                        {{ shortenUrl(item.english_link) }}
                                    </a>
                                </td>
                                <td class="text2 d-flex gap-1" v-if="profile.role === 'Admin'">
                                    <router-link :to="{ name: 'TutorialEdit', params: { id: item.id } }">
                                        <button class="import2 add-cc btn-cc-dd hover-cc">
                                            <i class="fa fa-edit"></i>
                                        </button>
                                    </router-link>
                                    <a @click="confirmDelete(item.id)">
                                        <button class="import2 add-cc btn-cc-dd hover-cc" data-type="confirm"
                                            title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div v-if="url && url.length === 0" class="text" style="text-align: center; margin: 10px 0;">
                    No Url Found Yet
                </div>
            </div>
        </div>

    </div>
</template>

<script>
import { mapActions, mapState } from 'vuex';
import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';
export default {
    methods: {
        ...mapActions('tutorial', ['fetchTutorial', 'fetchDeleteTutorial']),
        shortenUrl(url) {
            if (!url) return '';
            const maxLength = 30; // Adjust as needed
            return url.length > maxLength ? url.substring(0, maxLength) + '...' : url;
        },
        confirmDelete(id) {
            if (!id || typeof id !== 'number' && typeof id !== 'string') {
                console.error("Invalid ID passed to delete operation");
                return;
            }

            this.$swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.fetchDeleteTutorial(id).then(() => {
                        this.$swal.fire({
                            title: "Deleted!",
                            text: "Links is deleted successfully.",
                            icon: "success"
                        });
                    });
                    this.fetchTutorial();
                }
            });
        }
    },
    computed: {
        ...mapState('tutorial', ['url', 'urlLoading']),
        ...mapState('auth', ['profile', 'profileLoading',])
    },
    mounted() {
        this.fetchTutorial();
    }
}

</script>

<style scoped>
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