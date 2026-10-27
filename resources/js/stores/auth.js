import { defineStore } from "pinia";
import api from "@/services/api";

export const useAuthStore = defineStore("auth", {
    state: () => ({
        user: null,
        token: localStorage.getItem("tfp_token") || null,
        isLoading: false,
        errorMessage: null,
    }),

    getters: {
        isAuthenticated: (state) => !!state.token,
    },

    actions: {
        async register(payload) {
            this.isLoading = true;
            this.errorMessage = null;
            try {
                const response = await api.post("/auth/register", payload);
                this.setAuthData(response.data.token, response.data.user);
                return response.data;
            } catch (error) {
                this.errorMessage =
                    error.response?.data?.message || "Registration failed";
                throw error;
            } finally {
                this.isLoading = false;
            }
        },

        async login(credentials) {
            this.isLoading = true;
            this.errorMessage = null;
            try {
                const response = await api.post("/auth/login", credentials);
                this.setAuthData(response.data.token, response.data.user);
                return response.data;
            } catch (error) {
                this.errorMessage =
                    error.response?.data?.message || "Invalid credentials";
                throw error;
            } finally {
                this.isLoading = false;
            }
        },

        async fetchCurrentUser() {
            if (!this.token) return null;
            try {
                const response = await api.get("/auth/me");
                this.user = response.data.user;
                return this.user;
            } catch (error) {
                this.logout();
                return null;
            }
        },

        setAuthData(token, user) {
            this.token = token;
            this.user = user;
            localStorage.setItem("tfp_token", token);
        },

        async logout() {
            try {
                if (this.token) {
                    await api.post("/auth/logout");
                }
            } catch (e) {
                // Ignored on client logout
            } finally {
                this.user = null;
                this.token = null;
                localStorage.removeItem("tfp_token");
            }
        },
    },
});
