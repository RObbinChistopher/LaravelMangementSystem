<template>
    <div class="container extra-class-container" style="margin: 1.5rem 0px !important">
        <div class="row">
            <div class="col-md-4 col-6 header-col">
                <h3 class="heading">All Projects</h3>
            </div>
            <div class="col-md-8 col-6">
                <div class="btn-text m-0 add-new-cat " style="display: flex; justify-content: flex-end;" v-if="profile.role !== 'Team-Member'">
                    <router-link to="/create-project" class="import2 add-cc hover-cc">Add New</router-link>
                </div>
            </div>
        </div>


        <div class="parent-accordion p-3" id="parent-accordion">
            <div class="row">
                <div class="col-md-6 col-12 left-side-filttle">
                    <!-- Status Filter -->
                    <div class="status-filter d-flex" v-if="profile.role !== 'Team-Member'">
                        <p class="text2 mr-text ml-text filter-item" data-filter="all"
                            @click="handlePercentageChange(null)" :class="{ active: activePercentage === null }"
                            style="cursor: pointer;">
                            All
                        </p>
                        <p class="text2 mr-text filter-item" data-filter="deliveries"
                            @click="handlePercentageChange(100)" :class="{ active: activePercentage === 100 }"
                            style="cursor: pointer;">
                            Brainstorming
                        </p>
                        <p class="text2 mr-text filter-item" data-filter="deliveries"
                            @click="handlePercentageChange(70)" :class="{ active: activePercentage === 70 }"
                            style="cursor: pointer;">Planning
                        </p>
                        <p class="text2 mr-text filter-item" data-filter="deliveries"
                            @click="handlePercentageChange(50)" :class="{ active: activePercentage === 50 }"
                            style="cursor: pointer;">
                            Progress
                        </p>
                        <p class="text2 mr-text filter-item" data-filter="deliveries"
                            @click="handlePercentageChange(10)" :class="{ active: activePercentage === 10 }"
                            style="cursor: pointer;">
                            Testing
                        </p>
                    </div>

                </div>
                <div class="col-md-6 col-12 right-side-search">
                    <div class="search-input position-relative mb-2">
                        <input type="text" class="form-control" placeholder="Search by Client or Project Name"
                            v-model="searchQuery" @input="debouncedAreaSearchWord" />
                        <i class="fa fa-search position-absolute search-icon"></i>
                    </div>
                </div>
            </div>
            <hr style="margin-top: 0 !important;">
            <!-- Loading Spinner -->
            <div class="spinner2 d-flex justify-content-center" v-if="projectLoading">
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
                                <th scope="col">Client Name</th>
                                <th scope="col">Deadline</th>
                                <th scope="col">Status</th>
                                <th scope="col">Created By</th>
                                <th scope="col" v-if="profile.role !== 'Team-Member'">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(item, index) in filterproject">
                                <th scope="row">{{ index + 1 }}</th>
                                <td class="text2">{{ item.name }}</td>
                                <td class="text2">{{ item.client_name }}</td>
                                <td class="text2">{{ item.deadline }}</td>
                                <td class="text2" style="width: 30%;">
                                    <select class="form-control form-select text2 role-selected" id="licenseType"
                                        v-model="item.percentage" @change="updateProjectPecentage(item)"
                                        :disabled="profile.role === 'Team-Member'">
                                        <option value="" class="text2">Select a Status</option>
                                        <option value="100" class="text2">Brainstorming &nbsp; 100%</option>
                                        <option value="70" class="text2">Planning &nbsp; 70%</option>
                                        <option value="50" class="text2">In Progress &nbsp; 50%</option>
                                        <option value="10" class="text2">Testing &nbsp; 10%</option>
                                        <option value="0" class="text2">Finalize &nbsp; 0%</option>
                                    </select>
                                </td>
                                <td class="text2">{{ item.created_at }}</td>
                                <td class="text2 d-flex gap-1" v-if="profile.role !== 'Team-Member'">
                                    <router-link :to="{ name: 'editProject', params: { id: item.id } }">
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
                    <Bootstrap5Pagination :show-disabled=true :limit="5" :data="currentPagination"
                        @pagination-change-page="conditionalPagination" />
                </div>
                <div v-if="project && project.length === 0" class="text" style="text-align: center; margin: 10px 0;">
                    No Projects Found
                </div>
            </div>


        </div>

    </div>
</template>

<script>
import { mapActions, mapState } from 'vuex';
import { Bootstrap5Pagination } from 'laravel-vue-pagination';
import config from '../../config';
import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';
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
            activePercentage: null,
            currentPercentage: null,
        };
    },
    methods: {
        ...mapActions('project', ['fetchAllProjects', 'deleteProject', 'fetchFilterProjects', 'fetchProjectSearch']),
        ProjectSearchWord() {
            if (this.searchQuery.length >= 3) {
                this.fetchProjectSearch({
                    query: this.searchQuery,
                });
            }
        },
        debouncedAreaSearchWord: debounce(function () {
            this.ProjectSearchWord();
        }, 500),
        handlePercentageChange(percentage) {
            this.activePercentage = percentage;
            this.currentPercentage = percentage;
            if (percentage === null) {
                this.fetchAllProjects(1);
            } else {
                this.fetchFilterProjects({ percentage: percentage, page_number: 1 });
            }
        },
        // Conditional pagination method
        conditionalPagination(pageNumber) {
            if (this.currentPercentage) {
                this.fetchAllBusinessByAdvanceFilttle({ percentage: this.currentPercentage, page_number: pageNumber });
            } else {
                this.fetchAllProjects(pageNumber);
            }
        },
        async updateProjectPecentage(item) {
            const formData = new FormData();
            formData.append('percentage', item.percentage);

            let url = `${config.apiBaseUrl}update-percentage/${item.id}`;

            const token = localStorage.getItem('token');
            try {
                await axios.post(url, formData, {
                    headers: {
                        'Authorization': `Bearer ${token}`,
                    }
                });
                toast.success('Project Status Updated Successfully');
            } catch (error) {
                console.error("API call error:", error);
                toast.error('Error updating the user role');
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
                    this.deleteProject(id).then(() => {
                        this.$swal.fire({
                            title: "Deleted!",
                            text: "Project is deleted successfully.",
                            icon: "success"
                        });
                    });
                    this.fetchAllProjects(1);
                }
            });
        }

    },

    computed: {
        ...mapState('project', ['project', 'projectLoading', 'pagination']),
        ...mapState('auth', ['profile', 'profileLoading']),
        currentPagination() {
            return this.pagination ? this.pagination : "no pagination";
        },
        filterproject() {
            return this.project.filter(project =>
                project.name.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
                project.client_name.toLowerCase().includes(this.searchQuery.toLowerCase())
            );
        }
    },

    mounted() {
        this.fetchAllProjects(1)
    }
}

</script>


<style scoped>
.status-filter {
    overflow-x: auto; /* Enables horizontal scrolling */
    white-space: nowrap; /* Prevents items from wrapping to the next line */
    display: flex; /* Keeps items aligned in a row */
    gap: 10px; /* Optional: Adds spacing between items */
    scrollbar-width: thin; /* Optional: Makes the scrollbar thinner (Firefox) */
    width: 100%;
}

.status-filter::-webkit-scrollbar {
    height: 8px; /* Optional: Adjust scrollbar height */
}

.status-filter::-webkit-scrollbar-thumb {
    background-color: #ccc; /* Optional: Style scrollbar thumb */
    border-radius: 4px; /* Optional: Round scrollbar thumb edges */
}

.status-filter::-webkit-scrollbar-track {
    background-color: #f1f1f1; /* Optional: Style scrollbar track */
}
.extra-class-container {
    padding: 0 0 0 15px;
}

.role-selected {
    width: 60%;
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