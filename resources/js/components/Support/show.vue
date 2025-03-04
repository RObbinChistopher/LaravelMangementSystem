<template>
    <div class="container extra-class-container" style="margin: 1.5rem 0px !important; padding: 0 1rem;">
        <div class="row">
            <div class="col-md-4 col-6 header-col">
                <h3 class="heading">Support System</h3>
            </div>
            <div class="col-md-8 col-6">
                <div class="btn-text m-0 add-new-cat " style="display: flex; justify-content: flex-end;">
                    <router-link to="/support-create" class="import2 add-cc hover-cc">Add Tickets</router-link>
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
            <div class="spinner2 d-flex justify-content-center" v-if="ticketsLoading">
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
                                <th scope="col">Subject</th>
                                <th scope="col">Status</th>
                                <th scope="col">Create at</th>
                                <th scope="col">Update at</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(items, index) in tickets" :key="index">
                                <th scope="row">{{ index + 1 }}</th>
                                <td class="text2">{{ items.subject }}</td>
                                <td class="text2 status-cell">
                                   <span :class="getStatusClass(items.status)"> {{ items.status }} </span>
                                </td>

                                <td class="text2">{{ items.created_at }}</td>
                                <td class="text2">{{ items.updated_at }}</td>
                                <td class="text2 d-flex gap-1">
                                    <router-link :to="{ name: 'supportChat', params: { id: items.id } }">
                                        <button class="import2 add-cc btn-cc-dd hover-cc">
                                            <i class="fa-solid fa-eye"></i>
                                        </button>
                                    </router-link>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <!-- Pagination -->
                    <Bootstrap5Pagination :show-disabled=true :limit="5" :data="currentPagination"
                        @pagination-change-page="fetchShowTickets" />
                </div>
                <div v-if="tickets && tickets.length === 0" class="text" style="text-align: center; margin: 10px 0;">
                    No Chat Found
                </div>
            </div>
        </div>
    </div>
</template>


<script>
import { mapActions, mapState } from 'vuex';


export default {
    methods: {
        ...mapActions('support', ['fetchShowTickets']),
        getStatusClass(status) {
            switch (status.toLowerCase()) {
                case "open":
                    return "bg-green";
                case "closed":
                    return "bg-red";
                case "pending":
                    return "bg-purple";
                default:
                    return ""; // No specific background for unknown statuses
            }
        },
    },
    computed: {
        ...mapState('support', ['tickets', 'ticketsLoading', 'pagination']),
        currentPagination() {
            return this.pagination ? this.pagination : "no pagination";
        },
    },
    mounted() {
        this.fetchShowTickets(1);
    }
}
</script>

<style scoped>
/* Background colors */
.bg-green {
    background-color: #99519e;
    padding: 3px 15px;
    border-radius: 20px;
    color: white;
}

.bg-red {
    background-color: #99519e;
    padding: 3px 15px;
    border-radius: 20px;
    color: white;
}

.bg-purple {
    background-color: #99519e;
    padding: 3px 15px;
    border-radius: 20px;
    color: white;
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