import { createRouter, createWebHistory } from "vue-router";
import { useAuthStore } from "@/stores/auth";

const routes = [
    {
        path: "/",
        name: "home",
        component: () => import("@/views/LandingView.vue"),
        meta: { guestOnly: true },
    },
    {
        path: "/login",
        name: "login",
        component: () => import("@/views/auth/LoginView.vue"),
        meta: { guestOnly: true },
    },
    {
        path: "/register",
        name: "register",
        component: () => import("@/views/auth/RegisterView.vue"),
        meta: { guestOnly: true },
    },
    {
        path: "/dashboard",
        name: "dashboard",
        component: () => import("@/views/DashboardView.vue"),
        meta: { requiresAuth: true },
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

router.beforeEach(async (to, from, next) => {
    const authStore = useAuthStore();

    // If token exists but user profile not loaded, fetch user once
    if (authStore.isAuthenticated && !authStore.user) {
        await authStore.fetchCurrentUser();
    }

    if (to.meta.requiresAuth && !authStore.isAuthenticated) {
        return next({ name: "login" });
    }

    if (to.meta.guestOnly && authStore.isAuthenticated) {
        return next({ name: "dashboard" });
    }

    next();
});

export default router;
