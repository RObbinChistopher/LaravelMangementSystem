<template>
    <div class="container extra-class-container" style="margin: 1.5rem 0px !important">
        <div class="row">
            <div class="col-md-4 col-6 header-col">
                <h3 class="heading">My Clients</h3>
            </div>
            <div class="col-md-8 col-6">
                <div class="btn-text m-0 add-new-cat " style="display: flex; justify-content: flex-end;">
                    <!-- <router-link to="/team-name" class="import2 add-cc hover-cc">Back</router-link> -->
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
                    <div class="search-input position-relative">
                        <input type="text" class="form-control" placeholder="Search Name, Email and Phone Number"
                            v-model="searchQuery" @input="debouncedAreaSearchWord" />
                        <i class="fa fa-search position-absolute search-icon"></i>
                    </div>
                </div>
            </div>
            <hr style="margin-top: 0 !important;">
            <div class="spinner2 d-flex justify-content-center" v-if="userAgentLoading">
                <div class="spinner-border" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
            <div v-else>
                <div class="table-responsive">
                    <table class="table table-striped table-responsive">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Client Name</th>
                                <th scope="col">Client Email</th>
                                <th scope="col">Client Phone</th>
                                <th scope="col">Client Payment Status</th>
                                <th scope="col">Client Estimated Budget</th>
                                <th scope="col">Client Launch Date</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(item, index) in userAgent">
                                <th scope="row">{{ index + 1 }}</th>
                                <td class="text2">{{ item.name }}</td>
                                <td class="text2">{{ item.email }}</td>
                                <td class="text2">{{ item.phone }}</td>
                                <td class="text2">
                                    <select class="form-select" aria-label="Default select example" disabled
                                        v-model="item.status">
                                        <option value="pending">Pending</option>
                                        <option value="payed">Payed</option>
                                    </select>
                                </td>
                                <td class="text2">{{ item.website_estimated_budget }} $</td>
                                <td class="text2">{{ item.website_desired_launch_date }}</td>
                                <td class="text2 d-flex gap-1">
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
                    <!-- Pagination -->
                    <Bootstrap5Pagination v-if="!searchQuery" :show-disabled=true :limit="5" :data="currentPagination"
                        @pagination-change-page="fetchUserAffiliateClient" />
                </div>
                <div v-if="userAgent && userAgent.length === 0" class="text"
                    style="text-align: center; margin: 10px 0;">
                    No Client Found
                </div>
            </div>
        </div>

    </div>
</template>
<script>
import { mapActions, mapState } from 'vuex';
import { Bootstrap5Pagination } from 'laravel-vue-pagination';
function debounce(func, wait) {
    let timeout;
    return function (...args) {
        const context = this;
        clearTimeout(timeout);
        timeout = setTimeout(() => func.apply(context, args), wait);
    };
}
export default {
    components: { Bootstrap5Pagination },
    data() {
        return {
            searchQuery: '',
            activeMileStones: null,
            currentMileStones: null,
        };
    },
    methods: {
        ...mapActions('agent', ['fetchUserAffiliateClient', 'fetchdDeleteAffiliateClientAdmin', 'fetchAffiliateClientAdminSearch']),
        UsersSearchWord() {
            if (this.searchQuery.length >= 3) {
                this.fetchAffiliateClientAdminSearch({
                    query: this.searchQuery,
                });
            }
        },
        debouncedAreaSearchWord: debounce(function () {
            this.UsersSearchWord();
        }, 500),
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
                    this.fetchdDeleteAffiliateClientAdmin(id).then(() => {
                        this.$swal.fire({
                            title: "Deleted!",
                            text: "Affiliate Client Information is deleted successfully.",
                            icon: "success"
                        });
                    });
                    this.fetchUserAffiliateClient(1);
                }
            });
        }

    },
    computed: {
        ...mapState('agent', ['userAgent', 'userAgentLoading', 'pagination']),
        currentPagination() {
            return this.pagination ? this.pagination : "no pagination";
        },
        filterUsers() {
            return this.agent.filter(user =>
                user.name.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
                user.email.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
                user.phone.toLowerCase().includes(this.searchQuery.toLowerCase())
            );
        }
    },
    mounted() {
        this.fetchUserAffiliateClient(1);
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