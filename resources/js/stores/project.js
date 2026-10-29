import { defineStore } from "pinia";
import api from "@/services/api";

export const useProjectStore = defineStore("project", {
    state: () => ({
        projects: [],
        currentProject: null,
        members: [],
        isLoading: false,
        errorMessage: null,
    }),

    actions: {
        async fetchProjects() {
            this.isLoading = true;
            try {
                const response = await api.get("/projects");
                this.projects = response.data.data;
            } catch (error) {
                this.errorMessage =
                    error.response?.data?.message || "Failed to load projects";
            } finally {
                this.isLoading = false;
            }
        },

        async fetchProject(id) {
            this.isLoading = true;
            try {
                const response = await api.get(`/projects/${id}`);
                this.currentProject = response.data.data;
            } catch (error) {
                this.errorMessage =
                    error.response?.data?.message || "Failed to load project";
            } finally {
                this.isLoading = false;
            }
        },

        async createProject(payload) {
            const response = await api.post("/projects", payload);
            this.projects.unshift(response.data.project);
            return response.data;
        },

        async updateProject(id, payload) {
            const response = await api.put(`/projects/${id}`, payload);
            const index = this.projects.findIndex((p) => p.id === id);
            if (index !== -1) this.projects[index] = response.data.project;
            if (this.currentProject?.id === id)
                this.currentProject = response.data.project;
            return response.data;
        },

        async archiveProject(id) {
            await api.post(`/projects/${id}/archive`);
            this.projects = this.projects.filter((p) => p.id !== id);
        },

        async fetchMembers(projectId) {
            const response = await api.get(`/projects/${projectId}/members`);
            this.members = response.data.members;
        },

        async addMember(projectId, payload) {
            const response = await api.post(
                `/projects/${projectId}/members`,
                payload,
            );
            await this.fetchMembers(projectId);
            return response.data;
        },

        async removeMember(projectId, userId) {
            await api.delete(`/projects/${projectId}/members/${userId}`);
            this.members = this.members.filter((m) => m.user.id !== userId);
        },
    },
});
