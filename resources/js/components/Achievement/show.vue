<template>
    <div class="container extra-class-container" style="margin: 1.5rem 0px !important">
        <div class="row">
            <div class="col-md-4 col-6 header-col">
                <h3 class="heading">Milestones</h3>
            </div>
            <div class="col-md-8 col-6">
                <div class="btn-text m-0 add-new-cat " style="display: flex; justify-content: flex-end;">
                    <router-link to="/create-milestones" class="import2 add-cc hover-cc">Add New</router-link>
                </div>
            </div>
        </div>


        <div class="parent-accordion p-3" id="parent-accordion">
            <div class="row">
                <div class="col-md-6 col-12 left-side-filttle">
                    <!-- Status Filter -->
                    <div class="status-filter d-flex">
                        <p class="text2 mr-text ml-text filter-item" @click="handleStatusChange(null)"
                            :class="{ active: activeMileStones === null }" data-filter="all" style="cursor: pointer;">
                            All
                        </p>
                        <p class="text2 mr-text filter-item" @click="handleStatusChange('complete')"
                            :class="{ active: activeMileStones === 'complete' }" data-filter="deliveries"
                            style="cursor: pointer;">
                            Complete</p>
                        <p class="text2 mr-text filter-item" @click="handleStatusChange('progress')"
                            :class="{ active: activeMileStones === 'progress' }" data-filter="deliveries"
                            style="cursor: pointer;">
                            Progress</p>
                        <p class="text2 mr-text filter-item" @click="handleStatusChange('in-complete')"
                            :class="{ active: activeMileStones === 'in-complete' }" data-filter="deliveries"
                            style="cursor: pointer;">
                            Incomplete</p>
                    </div>

                </div>
                <div class="col-md-6 col-12 right-side-search">
                    <!-- Your table or other content here -->

                    <!-- Search Input -->
                    <div class="search-input position-relative">
                        <input type="text" class="form-control" v-model="searchQuery" @input="debouncedAreaSearchWord"
                            placeholder="Search By Name and Project Name" />
                        <i class="fa fa-search position-absolute search-icon"></i>
                    </div>
                </div>


            </div>
            <hr style="margin-top: 0 !important;">
            <div class="spinner2 d-flex justify-content-center" v-if="mileStoneLoading">
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
                                <th scope="col">Name</th>
                                <th scope="col">Project</th>
                                <th scope="col">Deadline</th>
                                <th scope="col">Status</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(item, index) in mileStone">
                                <th scope="row">{{ index + 1 }}</th>
                                <td class="text2">{{ item.name }}</td>
                                <td class="text2">{{ item.project_name }}</td>
                                <td class="text2">{{ item.deadline }}</td>
                                <td class="text2" style="width: 30%;">
                                    <select class="form-select text2 role-selected" aria-label="Default select example"
                                        v-model="item.status" @change="updateMileStoneStatus(item)">
                                        <option disabled value="">Status</option>
                                        <option value="complete">Complete</option>
                                        <option value="progress">Progress</option>
                                        <option value="in-complete">Incomplete</option>
                                    </select>
                                </td>
                                <td class="text2 d-flex gap-1">
                                    <router-link :to="{ name: 'editMilestones', params: { id: item.id } }">
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
                    <!-- Pagination -->
                    <Bootstrap5Pagination v-if="!searchQuery" :show-disabled=true :limit="5" :data="currentPagination"
                        @pagination-change-page="conditionalPagination" />
                </div>
                <div v-if="mileStone && mileStone.length === 0" class="text"
                    style="text-align: center; margin: 10px 0;">
                    No MileStones Found
                </div>
            </div>

        </div>

    </div>
</template>

<script>
import { mapActions, mapState } from 'vuex/dist/vuex.cjs.js';
import { Bootstrap5Pagination } from 'laravel-vue-pagination';
import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';
import axios from 'axios';
import config from '../../config';
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
        ...mapActions('milestone', ['fetchAllMilestores', 'fetchDeleteMilestores', 'fetchMilestoresStatus', 'fetchMilestoresSearch']),
        MilestoneSearchWord() {
            if (this.searchQuery.length >= 3) {
                console.log('Search Query:', this.searchQuery, typeof this.searchQuery);
                this.fetchMilestoresSearch({
                    query: this.searchQuery,
                });
            }
        },
        debouncedAreaSearchWord: debounce(function () {
            this.MilestoneSearchWord();
        }, 500),
        async updateMileStoneStatus(item) {
            const formData = new FormData();
            formData.append('status', item.status);

            let url = `${config.apiBaseUrl}update-milestore-status/${item.id}`;

            const token = localStorage.getItem('token');
            try {
                await axios.post(url, formData, {
                    headers: {
                        'Authorization': `Bearer ${token}`,
                    }
                });
                toast.success('MileStone Status Updated Successfully');
            } catch (error) {
                console.error("API call error:", error);
                toast.error('Error updating the user role');
            }
        },
        handleStatusChange(status) {
            this.activeMileStones = status;
            this.currentMileStones = status;
            if (status === null) {
                this.fetchAllMilestores(1);
            } else {
                this.fetchMilestoresStatus({ status: status, page_number: 1 });
            }
        },
        // Conditional pagination method
        conditionalPagination(pageNumber) {
            if (this.currentMileStones) {
                this.fetchMilestoresStatus({ status: this.currentMileStones, page_number: pageNumber });
            } else {
                this.fetchAllMilestores(pageNumber);
            }
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
                    this.fetchDeleteMilestores(id).then(() => {
                        this.$swal.fire({
                            title: "Deleted!",
                            text: "MileStone is deleted successfully.",
                            icon: "success"
                        });
                    });
                    this.fetchAllMilestores(1);
                }
            });
        }

    },

    computed: {
        ...mapState('milestone', ['mileStone', 'mileStoneLoading', 'pagination']),
        filterMilestones() {
            return this.mileStone.filter(mileStone =>
                mileStone.name.toLowerCase().includes(this.searchQuery.toLowerCase())
            );
        },
        // filterMilestones() {
        //     return this.mileStone.filter(mileStone =>
        //         mileStone.name.toLowerCase().includes(this.searchQuery.toLowerCase())
        //     );
        // },
        currentPagination() {
            return this.pagination ? this.pagination : "no pagination";
        },
    },

    mounted() {
        this.fetchAllMilestores(1)
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

    .extra-class-container {
        padding: 0 0 0 0;
    }
}
</style>