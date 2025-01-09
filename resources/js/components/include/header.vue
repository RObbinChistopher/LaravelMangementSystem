<template>
    <div class="container header-container">
        <header
            class="d-flex flex-wrap align-items-center justify-content-between justify-content-md-between py-3 border-bottom">
            <a href="/"
                class="d-flex align-items-center col-md-3 mb-2 mb-md-0 text-dark text-decoration-none desktop-logo">
                <img src="/Images/logo.png" class="logo" alt="">
            </a>

            <!-- Menu Toggle -->
            <div class="mobile-logo">
                <div>
                    <span class="menu-toggle">☰</span>
                </div>

                <!-- Overlay for clicking outside sidebar -->
                <div class="overlay"></div>

                <!-- Sidebar -->
                <div class="sidebar">
                    <button class="close-btn">✕</button>
                    <img src="/Images/logo.png" class="logo" alt="">
                    <ul class="nav nav-pills flex-column mb-auto mt-3">
                        <li>
                            <router-link to="/dashboard" aria-current="page"
                                :class="{ 'nav-link link-dark text': true, 'active': isActive('/dashboard') }"
                                active-class="active">
                                <i class="fa-solid fa-house common-icon"></i>
                                Dashboard
                            </router-link>
                        </li>
                        <li>
                            <router-link to="/users" aria-current="page" v-if="profile.role === 'Admin'"
                                :class="{ 'nav-link link-dark text': true, 'active': isActive('/users') || isActive('/create-users') }"
                                active-class="active">
                                <i class="fa-solid fa-user common-icon"></i>
                                Team Member
                            </router-link>
                        </li>
                        <li >
                            <router-link to="/service" aria-current="page" v-if="profile.role === 'Admin'"
                                :class="{ 'nav-link link-dark text': true, 'active': isActive('/service') || isActive('/create-service') }"
                                active-class="active">
                                <i class="fa-solid fa-bell-concierge common-icon"></i>
                                Services
                            </router-link>
                        </li>
                        <li>
                            <router-link to="/projects"
                                :class="{ 'nav-link link-dark text': true, 'active': isActive('/projects') || isActive('/create-project') }"
                                active-class="active">
                                <i class="fas fa-project-diagram common-icon"></i>
                                Projects
                            </router-link>
                        </li>
                        <li v-if="profile.role !== 'Team-Member'">
                            <router-link to="/milestones" 
                                :class="{ 'nav-link link-dark text': true, 'active': isActive('/milestones') || isActive('/create-milestones') }"
                                active-class="active">
                                <i class="fa-solid fa-file-lines common-icon"></i>
                                Milestones
                            </router-link>
                        </li>
                        <li>
                            <router-link to="/tasks"
                                :class="{ 'nav-link link-dark text': true, 'active': isActive('/tasks') || isActive('/create-tasks') }"
                                active-class="active">
                                <i class="fa-solid fa-list-check common-icon"></i>
                                Tasks
                            </router-link>
                        </li>
                        <li>
                            <router-link to="/notification"
                                :class="{ 'nav-link link-dark text': true, 'active': isActive('/notification') || isActive('/create-notification') }"
                                active-class="active">
                                <i class="fa-solid fa-bell common-icon"></i>
                                Notifications
                            </router-link>
                        </li>
                        <li>
                            <router-link to="/profile"
                                :class="{ 'nav-link link-dark text': true, 'active': isActive('/profile') }"
                                active-class="active">
                                <i class="fa-solid fa-address-card common-icon"></i>
                                Profile
                            </router-link>
                        </li>
                        <li>
                            <a href="#" class="nav-link link-dark text">
                                <i class="fa-solid fa-right-from-bracket common-icon"></i>
                                Logout
                            </a>
                        </li>
                    </ul>
                    <hr>
                </div>
            </div>


            <ul class="nav col-12 col-md-auto mb-2 justify-content-center mb-md-0 search-input desktop-logo">
                <div class="searchbar-wrapper" style="position: relative; width: 100%;">
                    <div class="search-icon">
                    </div>
                    <input v-model="searchQuery" class="form-control search-gobal text" type="search" name="search"
                        id="search" placeholder="Search" autocomplete="off" aria-label="Search" />

                    <!-- Search Results Dropdown -->
                    <div class="parent-accordion searchbar-wrapper2 " id="parent-accordion"
                        v-if="searchQuery && filteredItems.length > 0">
                        <ul class="search-results">
                            <li v-for="item in filteredItems" :key="item" class="search-result-item"
                                @click="navigateToPage(item)">
                                {{ item }}
                            </li>
                        </ul>
                        <p v-if="searchQuery && filteredItems.length === 0">No results found</p>
                    </div>
                </div>
            </ul>



            <div class="col-md-3 text-end mt-2" style="margin-right: 14px;">
                <div class="dropdown profile-dropdown">
                    <a href="#" class="d-flex align-items-center link-dark text-decoration-none dropdown-toggle"
                        id="dropdownUser2" data-bs-toggle="dropdown" aria-expanded="false">
                        <img :src="profile.profile ? profile.profile : '/images/ViceTech.png'" alt="" width="32"
                            height="32" class="rounded-circle me-2" />
                        <strong>{{ profile.name }}</strong>
                    </a>
                    <ul class="dropdown-menu text-small shadow header-dropDown" aria-labelledby="dropdownUser2">
                        <li><router-link to="/profile-user" class="dropdown-item text" href="#"> <i
                                    class="fa-solid fa-address-card profile-icon"></i>Profile</router-link></li>
                        <li>
                            <hr class="dropdown-divider profile-hr">
                        </li>
                        <li>
                            <a class="dropdown-item d-flex flex-column text" href="#">
                                <div class="d-flex"> <strong>{{ profile.name }} <span class="profile-email">({{
                                    profile.role
                                            }})</span></strong></div>
                                <span class="profile-email">{{ profile.email }}</span>

                            </a>
                        </li>

                        <li>
                            <hr class="dropdown-divider profile-hr">
                        </li>
                        <li><a class="dropdown-item text" href="#" @click="logoutUser">
                                <i class="fa-solid fa-right-from-bracket profile-icon"></i>Logout</a></li>
                    </ul>
                </div>

            </div>

        </header>
    </div>
</template>

<script>
import { mapActions, mapState } from 'vuex';
export default {
    data() {
        return {
            searchQuery: '',
            items: ['Dashboard', 'Project', 'Team Member', 'Services', 'Milestones', 'Tasks', 'Notification', 'Pofile'],
        };
    },
    methods: {
        ...mapActions('auth', ['logout']),
        isActive(route) {
            const path = this.$route.path;
            const basePath = route.split('/').filter(part => !part.startsWith(':')).join('/');
            console.log(`Checking if ${path} starts with ${basePath}`);
            return path.startsWith(basePath);
        },
        logoutUser() {
            this.logout();
            this.$router.push('/');
        },
        navigateToPage(item) {
            switch (item) {
                case 'Dashboard':
                    this.$router.push('/dashboard');
                    break;
                case 'Project':
                    this.$router.push('/projects');
                    break;
                case 'Team Member':
                    this.$router.push('/users');
                    break;
                case 'Services':
                    this.$router.push('/service');
                    break;
                case 'Milestones':
                    this.$router.push('/milestones');
                    break;
                case 'Tasks':
                    this.$router.push('/tasks');
                    break;
                case 'Notification':
                    this.$router.push('/notification');
                    break;
                case 'Pofile':
                    this.$router.push('/profile-user');
                    break;
                default:
                    // Handle unknown item or route
                    console.error('Unknown item:', item);
                    break;
            }
            // Clear search query and hide the sidebar
            this.searchQuery = '';
            this.showSidebar = false;
        },
    },
    computed: {
        ...mapState('auth', ['profile', 'profileLoading']),
        filteredItems() {
            return this.items.filter(item =>
                item.toLowerCase().includes(this.searchQuery.toLowerCase())
            );
        }
    },
    mounted() {
        const menuToggle = document.querySelector('.menu-toggle');
        const sidebar = document.querySelector('.sidebar');
        const closeBtn = document.querySelector('.close-btn');
        const overlay = document.querySelector('.overlay');
        const sidebarLinks = document.querySelectorAll('.sidebar a');

        // Open sidebar
        menuToggle.addEventListener('click', () => {
            sidebar.classList.add('open');
            overlay.classList.add('active');
        });

        // Close sidebar when clicking close button
        closeBtn.addEventListener('click', () => {
            sidebar.classList.remove('open');
            overlay.classList.remove('active');
        });

        // Close sidebar when clicking outside of it
        overlay.addEventListener('click', () => {
            sidebar.classList.remove('open');
            overlay.classList.remove('active');
        });

        // Close sidebar when clicking a link
        sidebarLinks.forEach(link => {
            link.addEventListener('click', () => {
                sidebar.classList.remove('open');
                overlay.classList.remove('active');
            });
        });
    },

}
</script>

<style scoped>
.searchbar-wrapper2 {
    position: absolute;
    top: 2.8rem;
    left: 0;
    width: 100%;
    padding: 0.5rem 1rem;
    background-color: white;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
    z-index: 1000;
}

.search-result-item {
    padding: 0.5rem 0;
    cursor: pointer;
}

.search-results {
    list-style: none;
    padding: 0;
    margin: 0;
    font-weight: 500;
}

.profile-icon {
    font-size: 11px;
    width: 18px;
    color: #505050;
}

.profile-hr {
    color: #fafcff;
    margin: 0;
}

.profile-email {
    font-size: 10px;
    color: #9a9a9a;
}

.header-dropDown {
    position: absolute;
    inset: 0px auto auto 0px;
    margin: 0px;
    transform: translate(218px, 34px) !important;
}

.profile-dropdown {
    display: flex;
    justify-content: end;
}

.logo {
    width: 35%;
}

.header-container {
    background: #e9edf1;
}

.dropdown-toggle-btn1 {
    background: #99519e;
    color: white !important;
    border: none;
    box-shadow: none;
}

.search-gobal {
    background: #f8f9fa;
    border-color: #dee2e6 !important;
    box-shadow: none;
}

.search-input {
    width: 30%;
    box-shadow: none;
}

.search-gobal::placeholder {
    color: #9e9d9d !important;
    font-size: 0.8rem;
    font-weight: 500;
}

.text {
    color: #303030;
    font-size: .8125rem;
    font-weight: 550;
}

/* Sidebar */
.sidebar {
    width: 250px;
    background-color: #e9edf1;
    color: black;
    padding: 20px;
    position: fixed;
    top: 0;
    left: 0;
    height: 100%;
    overflow-y: auto;
    transform: translateX(-100%);
    transition: transform 0.3s;
    z-index: 1000;
}

.sidebar.open {
    transform: translateX(0);
}

.sidebar .close-btn {
    background: none;
    border: none;
    color: black;
    font-size: 20px;
    cursor: pointer;
    position: absolute;
    top: 25px;
    right: 15px;
}

.sidebar a {
    display: block;
    color: black;
    text-decoration: none;
    padding: 10px 3px;
    border-radius: 4px;
    margin-bottom: 5px;
    transition: background 0.3s;
}

.sidebar a:hover {
    background-color: #34495e;
}

/* Overlay */
.overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    z-index: 999;
    display: none;
}

.overlay.active {
    display: block;
}

/* Content */
.content {
    margin-left: 0;
    padding: 20px;
    flex-grow: 1;
    width: 100%;
}

.menu-toggle {
    display: block;
    margin: 10px 0;
    cursor: pointer;
    font-size: 20px;
    color: #2c3e50;
    background-color: var(--viseTech);
    color: var(--white);
    padding: 1px 10px;
    border-radius: 5px;
}

.change-btn {
    background: #99519e;
    border-color: #99519e;
    height: 35px;
    color: white !important;
    box-shadow: none;
    font-size: 13px;
}

@media (max-width: 767px) {
    .desktop-logo {
        display: none !important;
    }
}

@media screen and (min-width: 768px) {
    .sidebar {
        transform: translateX(0);
    }

    .content {
        margin-left: 250px;
    }

    .menu-toggle {
        display: none;
    }

    .overlay {
        display: none;
    }

    .mobile-logo {
        display: none;
    }

    .header-container[data-v-602706df] {
        background: #e9edf1;
        height: 78px;
    }
}

@media screen and (max-width: 600px) {
    .header-dropDown{
        transform: translate3d(-32px, 34px, 0px) !important;
    }
    .common-icon {
        width: 20px !important;
    }

    .logo[data-v-602706df] {
        width: 60%;
    }

    .nav-pills .nav-link.active,
    .nav-pills .show>.nav-link {
        background-color: #99519e;
    }

    .search-input {
        width: 100%;
        box-shadow: none;
    }

}
</style>
