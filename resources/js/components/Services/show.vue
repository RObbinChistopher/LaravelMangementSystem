<template>
    <div class="container extra-class-container" style="margin: 1.5rem 0px !important">
        <div class="row">
            <div class="col-md-4 col-12 header-col">
                <h3 class="heading">All Services</h3>
            </div>
            <div class="col-md-8 col-12 add-bth-filter">
                <div class="btn-text m-0 add-new-cat " style="display: flex; justify-content: flex-end; gap: 15px;">
                    <div class="service-detail text" v-if="currentSerivce">
                        Services Filtered By: {{ getServiceDisplayName(currentSerivce) }}
                    </div>
                    <div class="btn-group service-filtte">
                        <button type="button" class="btn btn-danger dropdown-toggle text change-btn"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Filter By Services
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item text2" href="#" value="">Select a Client Service</a></li>
                            <li><a class="dropdown-item text2" href="#" @click="handleServiceChange('web-design')"
                                    value="web-design">Web Design</a></li>
                            <li><a class="dropdown-item text2" href="#" @click="handleServiceChange('web-development')"
                                    value="web-development">Web Development</a></li>
                            <li><a class="dropdown-item text2" href="#" @click="handleServiceChange('ecommerce')"
                                    value="ecommerce">E-commerce Development</a>
                            </li>
                            <li><a class="dropdown-item text2" href="#" @click="handleServiceChange('seo')"
                                    value="seo">SEO Services</a></li>
                            <li><a class="dropdown-item text2" href="#" @click="handleServiceChange('ui-ux-design')"
                                    value="ui-ux-design">UI/UX Design</a></li>
                            <li><a class="dropdown-item text2" href="#" @click="handleServiceChange('maintenance')"
                                    value="maintenance">Website Maintenance</a></li>
                            <li><a class="dropdown-item text2" href="#"
                                    @click="handleServiceChange('digital-marketing')" value="digital-marketing">Digital
                                    Marketing</a>
                            </li>
                            <li><a class="dropdown-item text2" href="#" @click="handleServiceChange('cms-development')"
                                    value="cms-development">CMS Development</a></li>
                            <li><a class="dropdown-item text2" href="#" @click="handleServiceChange('api-integration')"
                                    value="api-integration">API Integration</a></li>
                            <li><a class="dropdown-item text2" href="#" @click="handleServiceChange('hosting-service')"
                                    value="hosting-services">Hosting Services</a>
                            </li>
                        </ul>
                    </div>

                    <router-link to="/create-service" class="import2 add-cc hover-cc">Add New</router-link>
                </div>
            </div>
        </div>


        <div class="parent-accordion p-3" id="parent-accordion">
            <div class="row">
                <div class="col-md-6 col-12 left-side-filttle">
                    <!-- Status Filter -->
                    <div class="status-filter d-flex">
                        <p class="text2 mr-text ml-text filter-item" data-filter="all"
                            @click="handleServiceStatusChange(null)" :class="{ active: activeStatus === null }"
                            style="cursor: pointer;">
                            All
                        </p>
                        <p class="text2 mr-text filter-item" data-filter="deliveries"
                            @click="handleServiceStatusChange('pending')"
                            :class="{ active: activeStatus === 'pending' }" style="cursor: pointer;">
                            Pending&nbsp;Payment
                        </p>
                        <p class="text2 mr-text filter-item" data-filter="deliveries"
                            @click="handleServiceStatusChange('complete')"
                            :class="{ active: activeStatus === 'complete' }" style="cursor: pointer;">
                            Complete&nbsp;Payment
                        </p>
                    </div>

                </div>
                <div class="col-md-6 col-12 right-side-search mb-2">
                    <div class="search-input position-relative">
                        <input type="text" class="form-control"
                            placeholder="Search by Client Name or Email, Package, Srevices" v-model="searchQuery"
                            @input="debouncedAreaSearchWord" />
                        <i class="fa fa-search position-absolute search-icon"></i>
                    </div>
                </div>
            </div>
            <hr style="margin-top: 0 !important;">
            <!-- Loading Spinner -->
            <div class="spinner2 d-flex justify-content-center" v-if="servicesLoading">
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
                                <th scope="col">Client Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Services</th>
                                <th scope="col">Package</th>
                                <th scope="col">Total Payment</th>
                                <th scope="col">Initial Payment</th>
                                <th scope="col">Remaining Payment</th>
                                <th scope="col">Starting Date</th>
                                <th scope="col">Ending Date</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(item, index) in filterServices">
                                <th scope="row">{{ index + 1 }}</th>
                                <td class="text2">{{ item.client_name }}</td>
                                <td class="text2">{{ item.email }}</td>
                                <td class="text2">{{ item.service }}</td>
                                <td class="text2">{{ item.package }}</td>
                                <td class="text2">{{ item.total_payment }}</td>
                                <td class="text2">{{ item.initial_payment }}</td>
                                <td class="text2">{{ item.remaining_payment }}</td>
                                <td class="text2">{{ item.starting_date }}</td>
                                <td class="text2">{{ item.ending_date }}</td>
                                <td class="text2 d-flex gap-0">
                                    <router-link :to="{ name: 'invoice', params: { id: item.id } }">
                                        <button class="import2 add-cc btn-cc-dd hover-cc">
                                            <i class="fa-solid fa-file-invoice"></i>
                                        </button>
                                    </router-link>
                                    <router-link :to="{ name: 'editService', params: { id: item.id } }">
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
                <div v-if="service && service.length === 0" class="text" style="text-align: center; margin: 10px 0;">
                    No Services Found
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
            activeService: null,
            currentSerivce: null,
            activeStatus: null,
            currentStatus: null,
            serviceNames: {
                'web-design': 'Web Design',
                'web-development': 'Web Development',
                'ecommerce': 'E-commerce Development',
                'seo': 'SEO Services',
                'ui-ux-design': 'UI/UX Design',
                'maintenance': 'Website Maintenance',
                'digital-marketing': 'Digital Marketing',
                'cms-development': 'CMS Development',
                'api-integration': 'API Integration',
                'hosting-service': 'Hosting Services',
            }
        };
    },
    methods: {
        ...mapActions('service', ['fetchAllServices', 'fetchdeleteServices', 'fetchFilttleByServices', 'fetchFilttleByServicesStatus',
            'fetchFilttleByServicesSearch']),
        ServiceSearchWord() {
            if (this.searchQuery.length >= 3) {
                this.fetchFilttleByServicesSearch({
                    query: this.searchQuery,
                });
            }
        },
        debouncedAreaSearchWord: debounce(function () {
            this.ServiceSearchWord();
        }, 500),
        getServiceDisplayName(serviceValue) {
            return this.serviceNames[serviceValue] || serviceValue;
        },
        handleServiceStatusChange(status) {
            this.activeStatus = status;
            this.currentStatus = status;
            if (status === null) {
                this.fetchAllServices(1);
            } else {
                this.fetchFilttleByServicesStatus({ status: status, page_number: 1 });
            }
        },
        handleServiceChange(service) {
            this.activeService = service;
            this.currentSerivce = service;
            if (service === null) {
                this.fetchAllServices(1);
            } else {
                this.fetchFilttleByServices({ service: service, page_number: 1 });
            }
        },
        conditionalPagination(pageNumber) {
            if (this.currentSerivce) {
                this.fetchFilttleByServices({ service: this.currentSerivce, page_number: pageNumber });
            } else if (this.currentStatus) {
                this.fetchFilttleByServices({ status: this.currentStatus, page_number: pageNumber });
            } else {
                this.fetchAllServices(pageNumber);
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
                    this.fetchdeleteServices(id).then(() => {
                        this.$swal.fire({
                            title: "Deleted!",
                            text: "Services is deleted successfully.",
                            icon: "success"
                        });
                    });
                    this.fetchAllServices(1);
                }
            });
        }
    },

    computed: {
        ...mapState('service', ['service', 'servicesLoading', 'pagination']),
        currentPagination() {
            return this.pagination ? this.pagination : "no pagination";
        },
        filterServices() {
            return this.service.filter(service =>
                service.email.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
                service.client_name.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
                service.service.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
                service.package.toLowerCase().includes(this.searchQuery.toLowerCase())
            );
        }
    },

    mounted() {
        this.fetchAllServices(1)
    }

}
</script>

<style scoped>
.service-detail {
    background: #e9edf1;
    padding: 4px 10px;
    border-radius: 5px;
}

.service-filtte {
    height: 34px;
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

.change-btn {
    background: #99519e;
    border-color: #99519e;
    height: 35px;
    color: white !important;
    box-shadow: none;
    font-size: 13px;
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
        margin-bottom: 1rem;
    }

    .add-bth-filter {
        margin-bottom: 1rem;
    }

    .extra-class-container {
        padding: 0 0 0 0;
    }
}
</style>