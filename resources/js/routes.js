import Login from './components/Auth/Login.vue';

// users 
import users from './components/users/show.vue'
import createUsers from './components/Users/create.vue'

// project 
import showProject from "./components/Project/show.vue";
import createProject from './components/Project/create.vue'


//  Milestones 
import showMilestones from './components/Achievement/show.vue'
import createMilestones from './components/Achievement/create.vue'

// tasks
import showTasks from './components/Tasks/show.vue'
import createTasks from './components/Tasks/create.vue'

//  Notifications
import showNotification from './components/Notification/show.vue'
import createNotification from './components/Notification/create.vue'


// profile 
import profile from './components/Profile/show.vue'


// dashboard
import dashboard from './components/Dashboard/show.vue'

// Services
import service from './components/Services/show.vue'
import createService from './components/Services/create.vue';
import invoice from './components/Services/invoice.vue';

// unauthorized
import showUnauthorized from './components/unauthoriz/show.vue'



const routes = [
    { path: '/', component: Login, name: 'Login', meta: { showHeader: false, showSlideBar: false, meta: { requiresAuth: false } } },
    // users
    { path: '/users', component: users, name: 'users', meta: { requiresAuth: true, requiresRole: 'Admin' } },
    { path: '/create-users', component: createUsers, name: 'createUsers', meta: { requiresAuth: true, requiresRole: 'Admin' } },
    { path: '/edit-users/:id', component: createUsers, name: 'editUsers', meta: { requiresAuth: true, requiresRole: 'Admin' } },

    // project 
    { path: '/projects', component: showProject, name: 'showProject', meta: { requiresAuth: true, } },
    { path: '/create-project', component: createProject, name: 'createProject', meta: { requiresAuth: true, requiresRoles: ['Admin', 'Project-Manager'] } },
    { path: '/edit-project/:id', component: createProject, name: 'editProject', meta: { requiresAuth: true, requiresRoles: ['Admin', 'Project-Manager'] } },

    //  Milestones 
    { path: '/milestones', component: showMilestones, name: 'showMilestones',  meta: { requiresAuth: true, requiresRole: ['Project-Manager', 'Admin']} },
    { path: '/create-milestones', component: createMilestones, name: 'createMilestones', meta: { requiresAuth: true, requiresRole: ['Project-Manager', 'Admin']} },
    { path: '/edit-milestones/:id', component: createMilestones, name: 'editMilestones', meta: { requiresAuth: true, requiresRole: ['Project-Manager', 'Admin']} },

    // tasks
    { path: '/tasks', component: showTasks, name: 'showTasks', meta: { requiresAuth: true, } },
    { path: '/create-tasks', component: createTasks, name: 'createTasks', meta: { requiresAuth: true, requiresRole: ['Project-Manager', 'Admin']} },
    { path: '/edit-tasks/:id', component: createTasks, name: 'editTasks', meta: { requiresAuth: true, requiresRole: ['Project-Manager', 'Admin']} },

    // Notification 
    { path: '/notification', component: showNotification, name: 'showNotification', meta: { requiresAuth: true, } },
    { path: '/create-notification', component: createNotification, name: 'createNotification', meta: { requiresAuth: true, requiresRole: ['Project-Manager', 'Admin']} },
    { path: '/edit-notification/:id', component: createNotification, name: 'editNotification', meta: { requiresAuth: true, requiresRole: ['Project-Manager', 'Admin']} },

    // profile
    { path: '/profile-user', component: profile, name: 'profile', meta: { requiresAuth: true, } },

    // dashboard
    { path: '/dashboard', component: dashboard, name: 'dashboard', meta: { requiresAuth: true } },


    // service
    { path: '/service', component: service, name: 'service', meta: { requiresAuth: true, requiresRole: 'Admin' } },
    { path: '/create-service', component: createService, name: 'createService', meta: { requiresAuth: true, requiresRole: 'Admin' } },
    { path: '/edit-service/:id', component: createService, name: 'editService', meta: { requiresAuth: true, requiresRole: 'Admin' } },
    { path: '/download-service-invoice/:id', component: invoice, name: 'invoice', meta: { requiresAuth: true, requiresRole: 'Admin' } },




    { path: '/Unauthorized', component: showUnauthorized, name: 'showUnauthorized', meta: { showHeader: false, showSlideBar: false, requiresAuth: true } },


];


export default routes;