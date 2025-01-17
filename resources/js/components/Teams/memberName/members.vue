<template>
    <div class="container extra-class-container" style="margin: 1.5rem 0px !important">
        <div class="row">
            <div class="col-md-4 col-6 header-col">
                <h3 class="heading">Team Members</h3>
            </div>
            <div class="col-md-8 col-6">
                <div class="btn-text m-0 add-new-cat " style="display: flex; justify-content: flex-end;">
                    <router-link to="/team-name" class="import2 add-cc hover-cc">Back</router-link>
                    <router-link :to="{ name: 'TeamMemberNameCreate', params: { teamId: this.$route.params.teamId } }"
                        class="import2 add-cc hover-cc">Add new</router-link>
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
                        <input type="text" class="form-control" placeholder="Search..." />
                        <i class="fa fa-search position-absolute search-icon"></i>
                    </div>
                </div>
            </div>
            <hr style="margin-top: 0 !important;">
            <!-- Loading Spinner -->
            <div class="spinner2 d-flex justify-content-center" v-if="teamMemberLoading">
                <div class="spinner-border" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
            <div v-else>
                <table class="table table-striped table-responsive">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">User Position</th>
                            <th scope="col">Team</th>
                            <th scope="col">Project</th>
                            <th scope="col">Project Deadline</th>
                            <th scope="col">Assigned Date</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(item, index) in teamMember">
                            <th scope="row">{{ index + 1 }}</th>
                            <td class="text2">{{ item.users }}</td>
                            <td class="text2">{{ item.user_position }}</td>
                            <td class="text2">{{ item.team }}</td>
                            <td class="text2">{{ item.project }}</td>
                            <td class="text2">{{ item.deadline }}</td>
                            <td class="text2">{{ item.assigned_date }}</td>
                            <td class="text2 d-flex gap-1">
                                <router-link
                                    :to="{ name: 'TeamMemberNameEdit', params: { teamId: this.$route.params.id, id: item.id } }">
                                    <button class="import2 add-cc btn-cc-dd hover-cc" data-type="confirm"
                                        title="Delete">
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
                    @pagination-change-page="fetchAllTeams" />
                <div v-if="teamMember && teamMember.length === 0" class="text"
                    style="text-align: center; margin: 10px 0;">
                    No Team Member Found
                </div>
            </div>

        </div>
    </div>
</template>
<script>
import { Bootstrap5Pagination } from 'laravel-vue-pagination';
import { mapActions, mapState } from 'vuex';
export default {
    components: { Bootstrap5Pagination },
    methods: {
        ...mapActions('team', ['fetchAllTeamMembers', 'deleteSingleTeamMember']),
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
                    this.deleteSingleTeamMember(id).then(() => {
                        this.$swal.fire({
                            title: "Deleted!",
                            text: "Services is deleted successfully.",
                            icon: "success"
                        });
                    });
                    this.fetchAllTeamMembers({
                        id: this.$route.params.teamId,
                        page_number: 1
                    })
                }
            });
        }
    },
    computed: {
        ...mapState('team', ['teamMember', 'teamMemberLoading', 'pagination']),
        currentPagination() {
            return this.pagination ? this.pagination : "no pagination";
        },
    },
    mounted() {
        this.fetchAllTeamMembers({
            id: this.$route.params.teamId,
            page_number: 1
        })
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