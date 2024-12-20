import { createRouter, createWebHistory } from 'vue-router';
import routes from './routes.js';

const router = createRouter({
    history: createWebHistory(),
    routes,
});

router.beforeEach((to, from, next) => {
    const token = localStorage.getItem('token');
    const userRole = localStorage.getItem('role'); // Get the user's role from localStorage

    // Check if the route requires authentication
    if (to.matched.some(record => record.meta.requiresAuth)) {
        if (!token) {
            // Redirect to login if no token is found
            next({
                path: '/',
                query: { redirect: to.fullPath },
            });
        } else {
            // Check if the route requires specific roles
            if (to.meta.requiresRole) {
                if (!to.meta.requiresRole.includes(userRole)) {
                    // Redirect to a "not authorized" page if the role doesn't match
                    next('/Unauthorized'); // Or redirect to another page
                } else {
                    // Proceed if the role matches
                    next();
                }
            } else {
                // Proceed if no specific role is required
                next();
            }
        }
    } else {
        // Proceed if the route doesn't require authentication
        next();
    }
});


export default router;
