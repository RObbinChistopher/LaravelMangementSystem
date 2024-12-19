<template>
    <div class="container extra-class-container" style="margin: 1.5rem 0px !important">
        <div class="row">
            <div class="col-md-4 col-6 header-col">
                <h3 class="heading">All Users</h3>
            </div>
            <div class="col-md-8 col-6">
                <div class="btn-text m-0 add-new-cat " style="display: flex; justify-content: flex-end;">
                    <router-link to="/create-users" class="import2 add-cc hover-cc">Add New</router-link>
                </div>
            </div>
        </div>

        <div class="parent-accordion p-3" id="parent-accordion">
            <div class="row">
                <div class="col-md-6 col-12 left-side-filttle">
                    <div class="status-filter d-flex">
                        <p class="text2 mr-text ml-text filter-item" data-filter="all" @click="handleStatusChange(null)"
                            :class="{ active: activerole === null }" style="cursor: pointer;">
                            All
                        </p>
                        <p class="text2 mr-text filter-item" data-filter="deliveries" style="cursor: pointer;"
                            @click="handleStatusChange('Admin')" :class="{ active: activerole === 'Admin' }">Admin</p>
                        <p class="text2 mr-text filter-item" data-filter="deliveries"
                            @click="handleStatusChange('Project-Manager')"
                            :class="{ active: activerole === 'Project-Manager' }" style="cursor: pointer;">Project
                            Manager</p>
                        <p class="text2 mr-text filter-item" data-filter="deliveries"
                            @click="handleStatusChange('Team-Member')" :class="{ active: activerole === 'Team-Member' }"
                            style="cursor: pointer;">Team
                            Member
                        </p>
                    </div>
                </div>
                <div class="col-md-6 col-12 right-side-search">
                    <!-- Your table or other content here -->

                    <!-- Search Input -->
                    <div class="search-input position-relative">
                        <input type="text" class="form-control" placeholder="Search by Name or Email" v-model="searchQuery"
                            @input="debouncedAreaSearchWord" />
                        <i class="fa fa-search position-absolute search-icon"></i>
                    </div>
                </div>
            </div>
            <hr style="margin-top: 0 !important;">
            <!-- Loading Spinner -->
            <div class="spinner2 d-flex justify-content-center" v-if="isAuthenticated">
                <div class="spinner-border" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
            <div v-else>
                <div class="table-responsive">
                    <table class="table table-striped ">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Role</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            <tr v-for="(items, index) in user">
                                <th scope="row">{{ index + 1 }}</th>
                                <td class="text2">{{ items.name }}</td>
                                <td class="text2">{{ items.email }}</td>
                                <td class="text2" style="width: 30%;">
                                    <select class="form-select text2 role-selected" aria-label="Default select example"
                                        v-model="items.role" @change="FilterOfUserRole(items)">
                                        <option disabled value="">Select Role</option>
                                        <option value="Admin">Admin</option>
                                        <option value="Project-Manager">Project Manager</option>
                                        <option value="Team-Member">Team Member</option>
                                    </select>
                                </td>

                                <td class="text2">
                                    <router-link :to="{ name: 'editUsers', params: { id: items.id } }">
                                        <button class="import2 add-cc btn-cc-dd hover-cc">
                                            <i class="fa fa-edit"></i>
                                        </button>
                                    </router-link>
                                    <a @click="confirmDelete(items.id)">
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
                <div v-if="user && user.length === 0" class="text" style="text-align: center; margin: 10px 0;">
                    No Users Found
                </div>
            </div>

        </div>
    </div>
</template>

<script>
import { mapState, mapActions } from 'vuex';
import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';
import { Bootstrap5Pagination } from 'laravel-vue-pagination';
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
            from: {
                role: "",
            },
            searchQuery: '',
            activerole: null,
            currentrole: null,
        };
    },
    methods: {
        ...mapActions('auth', ['fetchAllUsers', 'deleteUsers', 'fetchUserSearch', 'FilterByUserRole']),
        UsersSearchWord() {
            if (this.searchQuery.length >= 3) {
                this.fetchUserSearch({
                    query: this.searchQuery,
                });
            }
        },
        debouncedAreaSearchWord: debounce(function () {
            this.UsersSearchWord();
        }, 500),
        handleStatusChange(role) {
            this.activerole = role;
            this.currentrole = role;
            if (role === null) {
                this.fetchAllUsers(1);
            } else {
                this.FilterByUserRole({ role: role, page_number: 1 });
            }
        },
        // Conditional pagination method
        conditionalPagination(pageNumber) {
            if (this.currentrole) {
                this.fetchAllBusinessByAdvanceFilttle({ role: this.currentrole, page_number: pageNumber });
            } else {
                this.fetchAllBusiness(pageNumber);
            }
        },
        async FilterOfUserRole(items) {
            const formData = new FormData();
            formData.append('role', items.role);

            let url = `${config.apiBaseUrl}filter-role/${items.id}`;

            const token = localStorage.getItem('token');
            try {
                await axios.post(url, formData, {
                    headers: {
                        'Authorization': `Bearer ${token}`,
                    }
                });
                toast.success('User Role Updated Successfully');
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
                    this.deleteUsers(id).then(() => {
                        this.$swal.fire({
                            title: "Deleted!",
                            text: "User is deleted successfully.",
                            icon: "success"
                        });
                    });
                    this.fetchAllUsers(1);
                }
            });
        }

    },
    computed: {
        ...mapState('auth', ['user', 'isAuthenticated', 'pagination']),
        currentPagination() {
            return this.pagination ? this.pagination : "no pagination";
        },
        filterUsers() {
            return this.user.filter(user =>
                user.name.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
                user.email.toLowerCase().includes(this.searchQuery.toLowerCase())
            );
        }

    },
    mounted() {
        this.fetchAllUsers(1);
    },
};
</script>

<style scoped>
.extra-class-container {
    padding: 0 0 0 15px;
}

.role-selected {
    width: 46%;
    height: 35px !important;
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

.status-filter {
    width: 100%;
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
        padding-left: 5px;
    }

    .extra-class-container {
        padding: 0 0 0 0;
    }

}

/* gobal */
</style>