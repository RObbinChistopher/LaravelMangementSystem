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
const routes = [
    { path: '/', component: Login, name: 'Login', meta: { showHeader: false, showSlideBar: false, meta: { requiresAuth: false } } },
    // users
    { path: '/users', component: users, name: 'users' },
    { path: '/create-users', component: createUsers, name: 'createUsers' },
    { path: '/edit-users/:id', component: createUsers, name: 'editUsers' },

    // project 
    { path: '/projects', component: showProject, name: 'showProject' },
    { path: '/create-project', component: createProject, name: 'createProject' },
    { path: '/edit-project/:id', component: createProject, name: 'editProject' },

    //  Milestones 
    { path: '/milestones', component: showMilestones, name: 'showMilestones' },
    { path: '/create-milestones', component: createMilestones, name: 'createMilestones' },
    { path: '/edit-milestones/:id', component: createMilestones, name: 'editMilestones' },

    // tasks
    { path: '/tasks', component: showTasks, name: 'showTasks' },
    { path: '/create-tasks', component: createTasks, name: 'createTasks' },
    { path: '/edit-tasks/:id', component: createTasks, name: 'editTasks' },

    // Notification 
    { path: '/notification', component: showNotification, name: 'showNotification' },
    { path: '/create-notification', component: createNotification, name: 'createNotification' },
    { path: '/edit-notificatio/:id', component: createNotification, name: 'editNotification' },

    // profile
    { path: '/profile-user', component: profile, name: 'profile' },

    // dashboard
    { path: '/dashboard', component: dashboard, name: 'dashboard' },


    // service
    { path: '/service', component: service, name: 'service' },
    { path: '/create-service', component: createService, name: 'createService' },
    { path: '/edit-service/:id', component: createService, name: 'editService' },
    { path: '/download-service-invoice/:id', component: invoice, name: 'invoice' },
];


export default routes;