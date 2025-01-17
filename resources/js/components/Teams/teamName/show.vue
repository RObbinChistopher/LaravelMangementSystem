<template>
    <div class="container extra-class-container" style="margin: 1.5rem 0px !important">
        <div class="row">
            <div class="col-md-4 col-6 header-col">
                <h3 class="heading">Teams Name</h3>
            </div>
            <div class="col-md-8 col-6">
                <div class="btn-text m-0 add-new-cat " style="display: flex; justify-content: flex-end;">
                    <router-link to="/team-create" class="import2 add-cc hover-cc">Add New</router-link>
                </div>
            </div>
        </div>
        <!-- Loading Spinner -->
        <div class="spinner2 d-flex justify-content-center" v-if="teamLoading">
            <div class="spinner-border" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
        <div class="row" v-else>
            <div class="col-md-3 col-lg-4 mb-3" v-for="item in teams">
                <div class="parent-accordion p-3" id="parent-accordion">
                    <div class="team-name">
                        <p class="team-name-title mb-2">{{ item.team_name }}</p>
                        <div class="edit-delete-icon">
                            <router-link :to="{ name: 'TeamMemberName', params: { teamId: item.id } }" class="items-link">
                                <p class="team-name-member import2 add-cc hover-cc"><i class="fa-solid fa-eye"></i>
                                </p>
                            </router-link>
                            <router-link :to="{ name: 'TeamEdit', params: { id: item.id } }" class="items-link">
                                <p class="team-name-member import2 add-cc hover-cc"><i class="fa fa-edit"></i>
                                </p>
                            </router-link>
                            <a @click="confirmDelete(item.id)" class="items-link">
                                <p class="team-name-member import2 add-cc hover-cc"><i class="fas fa-trash"></i>
                                </p>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div style="margin-bottom: 2rem;">
                <!-- Pagination -->
                <Bootstrap5Pagination :show-disabled=true :limit="5" :data="currentPagination"
                    @pagination-change-page="fetchAllTeams" />
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
        ...mapActions('team', ['fetchAllTeams', 'deleteSingleTeam']),
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
                    this.deleteSingleTeam(id).then(() => {
                        this.$swal.fire({
                            title: "Deleted!",
                            text: "Services is deleted successfully.",
                            icon: "success"
                        });
                    });
                    this.fetchAllTeams(1);
                }
            });
        }
    },

    computed: {
        ...mapState('team', ['pagination', 'teams', 'teamLoading']),
        currentPagination() {
            return this.pagination ? this.pagination : "no pagination";
        },
    },

    mounted() {
        this.fetchAllTeams(1)
    }
}
</script>

<style scoped>
.edit-delete-icon {
    display: flex;
    align-items: center;
}

.items-link {
    text-decoration: none;
}

.team-name-title {
    font-size: 1.6rem;
    font-weight: 700;
}

.team-name-member {
    font-size: 0.8rem;
    font-weight: 500;
}

.team-name {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
}

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