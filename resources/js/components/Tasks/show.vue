<template>
    <div class="container extra-class-container" style="margin: 1.5rem 0px !important">
        <div class="row">
            <div class="col-md-4 col-6 header-col">
                <h3 class="heading">All Tasks</h3>
            </div>
            <div class="col-md-8 col-6" v-if="profile.role !== 'Team-Member'">
                <div class="btn-text m-0 add-new-cat " style="display: flex; justify-content: flex-end;">
                    <router-link to="/create-tasks" class="import2 add-cc hover-cc">Add New</router-link>
                </div>
            </div>
        </div>


        <div class="parent-accordion p-3" id="parent-accordion">
            <div class="row">
                <div class="col-md-6 col-12 left-side-filttle">
                    <!-- Status Filter -->
                    <div class="status-filter d-flex" v-if="profile.role !== 'Team-Member'">
                        <p class="text2 mr-text ml-text filter-item" @click="handleFilttleTasks(null)"
                            :class="{ active: activeTask === null }" data-filter="all" style="cursor: pointer;">
                            All
                        </p>
                        <p class="text2 mr-text filter-item" @click="handleFilttleTasks('urgent')"
                            :class="{ active: activeTask === 'urgent' }" data-filter="urgent" style="cursor: pointer;">
                            Urgent&nbsp;Tasks
                        </p>
                        <p class="text2 mr-text filter-item" @click="handleFilttleTasks('medium')"
                            :class="{ active: activeTask === 'medium' }" data-filter="medium" style="cursor: pointer;">
                            Medium&nbsp;Tasks
                        </p>
                        <p class="text2 mr-text filter-item" @click="handleFilttleTasks('lower')"
                            :class="{ active: activeTask === 'lower' }" data-filter="low" style="cursor: pointer;">
                            Lower&nbsp;Tasks</p>
                    </div>
                </div>
                <div class="col-md-6 col-12 right-side-search mb-2">
                    <!-- Search Input -->
                    <div class="search-input position-relative">
                        <input type="text" class="form-control" v-model="searchQuery" @input="debouncedAreaSearchWord"
                            placeholder="Search by Task Name or Assigned Member" />
                        <i class="fa fa-search position-absolute search-icon"></i>
                    </div>
                </div>
            </div>
            <hr style="margin-top: 0 !important;">
            <!-- Loading Spinner -->
            <div class="spinner2 d-flex justify-content-center" v-if="tasksLoading">
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
                                <th scope="col">Milestone</th>
                                <th scope="col">Assigned</th>
                                <th scope="col">Deadline</th>
                                <th scope="col">Priority</th>
                                <th scope="col">Status</th>
                                <th scope="col" v-if="profile.role !== 'Team-Member'">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(item, index) in tasks">
                                <th scope="row">{{ index + 1 }}</th>
                                <td class="text2">{{ item.name }}</td>
                                <td class="text2">{{ item.milestones_name }}</td>
                                <td class="text2">{{ item.User_name }}</td>
                                <td class="text2">{{ item.deadline }}</td>
                                <td class="text2" style="width: 21%;">
                                    <select class="form-select text2 role-selected2" aria-label="Default select example"
                                        v-model="item.priority" @change="updateTasksStatus(item)"
                                        :disabled="profile.role === 'Team-Member'">
                                        <option disabled value="">Priority</option>
                                        <option value="urgent">Urgent Priority</option>
                                        <option value="medium">Medium Priority</option>
                                        <option value="lower">Lower Priority</option>
                                    </select>
                                </td>
                                <td class="text2" style="width: 25%;">
                                    <select class="form-select text2 role-selected" aria-label="Default select example"
                                        v-model="item.status" @change="updateTasksStatus(item)">
                                        <option disabled value="">Status</option>
                                        <option value="complete">Complete</option>
                                        <option value="progress">Progress</option>
                                        <option value="incomplete">Incomplete</option>
                                    </select>
                                </td>
                                <td class="text2 d-flex gap-1" style="height: 70px;" v-if="profile.role !== 'Team-Member'">
                                    <router-link :to="{ name: 'editTasks', params: { id: item.id } }">
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
                <div v-if="tasks && tasks.length === 0" class="text" style="text-align: center; margin: 10px 0;">
                    No Tasks For You Yet
                </div>
            </div>

        </div>
    </div>
</template>

<script>
import { mapActions, mapState } from 'vuex';
import { Bootstrap5Pagination } from 'laravel-vue-pagination';
import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';
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
            activeTask: null,
            currentTask: null,
            userRole: localStorage.getItem('role'),
        };
    },
    methods: {
        ...mapActions('tasks', ['fetchAllTasks', 'fetchSingleTasksDelete', 'fetchFilttleTasks', 'fetchTasksSearch']),
        TasksSearchWord() {
            if (this.searchQuery.length >= 3) {
                this.fetchTasksSearch({
                    query: this.searchQuery,
                });
            }
        },
        debouncedAreaSearchWord: debounce(function () {
            this.TasksSearchWord();
        }, 500),
        handleFilttleTasks(tasks) {
            this.activeTask = tasks;
            this.currentTask = tasks;
            if (tasks === null) {
                this.fetchAllTasks(1);
            } else {
                this.fetchFilttleTasks({ tasks: tasks, page_number: 1 });
            }
        },
        // Conditional pagination method
        conditionalPagination(pageNumber) {
            if (this.currentTask) {
                this.fetchFilttleTasks({ tasks: this.currentTask, page_number: pageNumber });
            } else {
                this.fetchAllTasks(pageNumber);
            }
        },
        async updateTasksStatus(item) {
            const formData = new FormData();
            formData.append('status', item.status);
            formData.append('priority', item.priority);

            let url = `${config.apiBaseUrl}update-task-status/${item.id}`;

            const token = localStorage.getItem('token');
            try {
                await axios.post(url, formData, {
                    headers: {
                        'Authorization': `Bearer ${token}`,
                    }
                });
                toast.success('Task Updated Successfully');
            } catch (error) {
                console.error("API call error:", error);
                toast.error('Error updating task status');
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
                    this.fetchSingleTasksDelete(id).then(() => {
                        this.$swal.fire({
                            title: "Deleted!",
                            text: "Tasks is deleted successfully.",
                            icon: "success"
                        });
                    });
                    this.fetchAllTasks(1);
                }
            });
        }
    },
    computed: {
        ...mapState('tasks', ['tasks', 'tasksLoading', 'pagination']),
        ...mapState('auth', ['profile', 'profileLoading']),
        currentPagination() {
            return this.pagination ? this.pagination : "no pagination";
        },
        filterTasks() {
            return this.tasks.filter(task => {
                const taskName = task.name ? task.name.toLowerCase() : '';
                const userName = task.user_name ? task.user_name.toLowerCase() : '';

                return taskName.includes(this.searchQuery.toLowerCase()) || userName.includes(this.searchQuery.toLowerCase());
            });
        },
    },

    mounted() {
        this.fetchAllTasks(1);
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

.role-selected2 {
    width: 76%;
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