<template>
    <div class="container header-container">
        <header
            class="d-flex flex-wrap align-items-center justify-content-between justify-content-md-between py-3 border-bottom">
            <a href="/"
                class="d-flex align-items-center col-md-3 mb-2 mb-md-0 text-dark text-decoration-none desktop-logo">
                <img src="/images/logo.png" class="logo" alt="">
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
                    <img src="/images/logo.png" class="logo" alt="">

                    <ul class="nav col-12 col-md-auto justify-content-center mb-md-0 search-input mb-3 mt-3">
                        <div class="input-group flex-nowrap">
                            <input type="text" class="form-control search-gobal text" placeholder="Search"
                                aria-label="Username" aria-describedby="addon-wrapping">
                        </div>
                    </ul>
                    <ul class="nav nav-pills flex-column mb-auto mt-3">
                        <li class="nav-item">
                            <router-link to="/dashboard" aria-current="page"
                                :class="{ 'nav-link link-dark text': true, 'active': isActive('/dashboard') }"
                                active-class="active">
                                <i class="fa-solid fa-house common-icon"></i>
                                Dashboard
                            </router-link>
                        </li>
                        <li class="nav-item">
                            <router-link to="/users" aria-current="page"
                                :class="{ 'nav-link link-dark text': true, 'active': isActive('/users') || isActive('/create-users') }"
                                active-class="active">
                                <i class="fa-solid fa-user common-icon"></i>
                                Users
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
                        <li>
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
                <div class="input-group flex-nowrap">
                    <input type="text" class="form-control search-gobal text" placeholder="Search" aria-label="Username"
                        aria-describedby="addon-wrapping">
                </div>
            </ul>

            <div class="col-md-3 text-end mt-2" style="margin-right: 14px;">
                <div class="btn-group">
                    <button type="button" class="btn btn-danger dropdown-toggle text change-btn"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        christopher
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Action</a></li>
                    </ul>
                </div>
            </div>
        </header>
    </div>
</template>

<script>
export default {
    methods: {
        isActive(route) {
            const path = this.$route.path;
            const basePath = route.split('/').filter(part => !part.startsWith(':')).join('/');
            console.log(`Checking if ${path} starts with ${basePath}`);
            return path.startsWith(basePath);
        },
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
    }
}
</script>

<style scoped>
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
