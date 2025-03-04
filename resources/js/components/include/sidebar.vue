<template>
    <div class="d-flex flex-column flex-shrink-0 p-3 bg-light sidebar">
        <ul class="nav nav-pills flex-column mb-auto">
            <li class="nav-item">
                <router-link to="/dashboard" aria-current="page" v-if="profile.role !== 'Affiliate'"
                    :class="{ 'nav-link link-dark text': true, 'active': isActive('/dashboard') }"
                    active-class="active">
                    <i class="fa-solid fa-house common-icon"></i>
                    Dashboard
                </router-link>
            </li>
            <li class="nav-item" v-if="profile.role === 'Affiliate'">
                <router-link to="/my-dashboard" aria-current="page"
                    :class="{ 'nav-link link-dark text': true, 'active': isActive('/my-dashboard') }"
                    active-class="active">
                    <i class="fa-solid fa-house common-icon"></i>
                    My Dashboard
                </router-link>
            </li>
            <li class="nav-item" v-if="profile.role === 'Admin'">
                <router-link to="/users" aria-current="page"
                    :class="{ 'nav-link link-dark text': true, 'active': isActive('/users') || isActive('/create-users') || isActive('/user-edit') }"
                    active-class="active">
                    <i class="fa-solid fa-user common-icon"></i>
                    Users
                </router-link>
            </li>
            <li class="nav-item" v-if="profile.role === 'Admin'">
                <router-link to="/affiliate" aria-current="page"
                    :class="{ 'nav-link link-dark text': true, 'active': isActive('/affiliate') || isActive('/affiliate-create') || isActive('/affiliate-edit') }"
                    active-class="active">
                    <i class="fa-solid fa-user-tie common-icon"></i>
                    Affiliate Members
                </router-link>
            </li>
            <li class="nav-item" v-if="profile.role === 'Admin'">
                <router-link to="/client-affiliate" aria-current="page"
                    :class="{ 'nav-link link-dark text position-relative': true, 'active': isActive('/client-affiliate') }"
                    active-class="active">
                    <i class="fa-solid fa-users-rectangle common-icon"></i>
                    Affiliate Client
                    <span v-if="userAgent" class="admin-dot">{{ userAgent }}</span>
                </router-link>
            </li>
            <li class="nav-item" v-if="profile.role === 'Affiliate'">
                <router-link to="/my-clients" aria-current="page"
                    :class="{ 'nav-link link-dark text': true, 'active': isActive('/my-clients') }"
                    active-class="active">
                    <i class="fa-solid fa-users-rectangle common-icon"></i>
                    My Client
                </router-link>
            </li>
            <li class="nav-item" v-if="profile.role === 'Affiliate'">
                <router-link to="/tutorial" aria-current="page"
                    :class="{ 'nav-link link-dark text': true, 'active': isActive('/tutorial') }" active-class="active">
                    <i class="fa-brands fa-tumblr common-icon"></i>
                    Tutorial
                </router-link>
            </li>
            <li class="nav-item" v-if="profile.role === 'Admin'">
                <router-link to="/in-voice" aria-current="page" :class="{
                    'nav-link link-dark text': true, 'active': isActive('/in-voice') ||
                        isActive('/create-invoice') || isActive('/edit-invoice') || isActive('/download-invoice') ||
                        isActive('/service') || isActive('/create-service') || isActive('/edit-service')
                }" active-class="active">
                    <i class="fa-solid fa-file-invoice common-icon"></i>
                    Invoice
                </router-link>
            </li>
            <li class="nav-item" v-if="profile.role === 'Admin'">
                <router-link to="/team-name" aria-current="page" :class="{
                    'nav-link link-dark text': true, 'active': isActive('/team-name') || isActive('/team-create') || isActive('/team-edit')
                        || isActive('/team-members') || isActive('/team-members-create') || isActive('/team-members-edit')
                }" active-class="active">
                    <i class="fa-solid fa-users common-icon"></i>
                    Teams
                </router-link>
            </li>
            <li>
                <router-link to="/projects" v-if="profile.role !== 'Affiliate'"
                    :class="{ 'nav-link link-dark text': true, 'active': isActive('/projects') || isActive('/create-project') || isActive('/edit-project') }"
                    active-class="active">
                    <i class="fas fa-project-diagram common-icon"></i>
                    Projects
                </router-link>
            </li>
            <li v-if="profile.role !== 'Team-Member' && profile.role !== 'Affiliate'">
                <router-link to="/milestones"
                    :class="{ 'nav-link link-dark text': true, 'active': isActive('/milestones') || isActive('/create-milestones') || isActive('/edit-milestones') }"
                    active-class="active">
                    <i class="fa-solid fa-file-lines common-icon"></i>
                    Milestones
                </router-link>
            </li>
            <li>
                <router-link to="/tasks" v-if="profile.role !== 'Affiliate'"
                    :class="{ 'nav-link link-dark text': true, 'active': isActive('/tasks') || isActive('/create-tasks') || isActive('/edit-tasks') }"
                    active-class="active">
                    <i class="fa-solid fa-list-check common-icon"></i>
                    Tasks
                </router-link>
            </li>
            <li>
                <router-link to="/notification" v-if="profile.role !== 'Affiliate'"
                    :class="{ 'nav-link link-dark text': true, 'active': isActive('/notification') || isActive('/create-notification') || isActive('/edit-notification') }"
                    active-class="active">
                    <i class="fa-solid fa-bell common-icon"></i>
                    Notifications
                </router-link>
            </li>
            <li>
                <router-link to="/support" v-if="profile.role === 'Affiliate'"
                    :class="{ 'nav-link link-dark text position-relative': true, 'active': isActive('/support') || isActive('/support-chat') }"
                    active-class="active">
                    <i class="fa-solid fa-message common-icon"></i>
                    Admin Support
                    <!-- <span v-if="ticketStatus && ticketStatus.admin_message !== 'no admin suppor'" class="red-dot" style="left: 142px !important;"></span> -->
                    <span v-if="ticketStatus && ticketStatus.admin_message !== 'no admin support'" class="red-dot"
                        style="left: 142px !important;"></span>
                </router-link>
            </li>
            <li>
                <router-link to="/profile-user"
                    :class="{ 'nav-link link-dark text': true, 'active': isActive('/profile-user') }"
                    active-class="active">
                    <i class="fa-solid fa-address-card common-icon"></i>
                    Profile
                </router-link>
            </li>
            <li>
                <router-link to="/admin-support" v-if="profile.role === 'Admin'"
                    :class="{ 'nav-link link-dark text position-relative': true, 'active': isActive('/admin-support') || isActive('/support-chat') }"
                    active-class="active">
                    <i class="fa-solid fa-message common-icon"></i>
                    Support
                    <span v-if="ticketStatus && ticketStatus.message !== 'no support'" class="red-dot"></span>
                </router-link>
            </li>
            <li>
                <a href="#" class="nav-link link-dark text" @click="logoutUser">
                    <i class="fa-solid fa-right-from-bracket common-icon"></i>
                    Logout
                </a>
            </li>
        </ul>
        <!-- <hr> -->
        <!-- <div class="dropdown">
            <a href="#" class="d-flex align-items-center link-dark text-decoration-none dropdown-toggle"
                id="dropdownUser2" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="https://github.com/mdo.png" alt="" width="32" height="32" class="rounded-circle me-2">
                <strong>mdo</strong>
            </a>
            <ul class="dropdown-menu text-small shadow" aria-labelledby="dropdownUser2">
                <li><a class="dropdown-item" href="#">New project...</a></li>
                <li><a class="dropdown-item" href="#">Settings</a></li>
                <li><a class="dropdown-item" href="#">Profile</a></li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item" href="#" @click="logoutUser">Sign out</a></li>
            </ul>
        </div> -->
    </div>
</template>

<script>
import { mapActions, mapState } from 'vuex';
export default {
    methods: {
        ...mapActions('auth', ['logout', 'fetchloginUser']),
        ...mapActions('support', ['ticketStatusByAdmin']),
        ...mapActions('agent', ['fetchBusinessInformationForAdmin']),
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
    },

    computed: {
        ...mapState('auth', ['profile', 'profileLoading']),
        ...mapState('support', ['ticketStatus']),
        ...mapState('agent', ['userAgent']),
    },

    mounted() {
        this.fetchloginUser();
        this.ticketStatusByAdmin();
        this.fetchBusinessInformationForAdmin();
    }
}
</script>

<style scoped>
.admin-dot {
    position: absolute;
    top: 0px;
    width: 20px;
    height: 20px;
    background-color: #16c60c;
    border-radius: 50%;
    color: white;
    text-align: center;
}

.red-dot {
    position: absolute;
    top: 5px;
    left: 94px;
    width: 10px;
    height: 10px;
    background-color: #16c60c;
    border-radius: 50%;
}

.text {
    color: #303030;
    font-size: 0.9rem;
    font-weight: 700;
}

.sidebar {
    height: 91vh;
    width: 100%;
    background-color: #e9edf1 !important;
}

.common-icon {
    width: 20px;
}

.active {
    background-color: #99519e !important;
    /* margin-bottom: 7px !important; */
}

.active:hover {
    background-color: #7654a2 !important;
}
</style>