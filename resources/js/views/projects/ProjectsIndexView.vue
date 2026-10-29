<template>
  <AppShellLayout>
    <div class="max-w-6xl mx-auto space-y-6">
      <div class="flex items-center justify-between">
        <div>
          <h1 class="text-2xl font-bold text-white tracking-tight">Engineering Projects</h1>
          <p class="text-sm text-slate-400">Select a project workspace or create a new one</p>
        </div>
        <button
          @click="showCreateModal = true"
          class="rounded-lg bg-indigo-600 px-4 py-2 text-xs font-semibold text-white hover:bg-indigo-500 transition-colors shadow-lg shadow-indigo-600/20 flex items-center gap-2"
        >
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
          New Project
        </button>
      </div>

      <!-- Filter & Search Toolbar -->
      <div class="flex items-center justify-between gap-4">
        <div class="relative flex-1 max-w-sm">
          <input
            v-model="searchQuery"
            type="text"
            placeholder="Search projects by name or key..."
            class="w-full rounded-lg border border-slate-800 bg-slate-900 px-3 py-2 pl-9 text-xs text-white focus:border-indigo-500 focus:outline-none"
          />
          <svg class="w-4 h-4 text-slate-500 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
        </div>

        <div class="flex rounded-lg bg-slate-900 p-1 border border-slate-800 text-xs font-medium">
          <button
            v-for="tab in ['active', 'archived', 'all']"
            :key="tab"
            @click="activeTab = tab"
            class="px-3 py-1 rounded capitalize transition-colors"
            :class="activeTab === tab ? 'bg-indigo-600 text-white' : 'text-slate-400 hover:text-white'"
          >
            {{ tab }}
          </button>
        </div>
      </div>

      <!-- Project Grid -->
      <div v-if="filteredProjects.length > 0" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        <ProjectCard
          v-for="project in filteredProjects"
          :key="project.id"
          :project="project"
          @select="openProject"
        />
      </div>

      <div v-else class="rounded-xl border border-dashed border-slate-800 p-12 text-center">
        <p class="text-sm text-slate-400">No projects found matching your criteria.</p>
      </div>

      <CreateProjectModal
        v-if="showCreateModal"
        @close="showCreateModal = false"
        @created="showCreateModal = false"
      />
    </div>
  </AppShellLayout>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import { useRouter } from 'vue-router';
import AppShellLayout from '@/layouts/AppShellLayout.vue';
import ProjectCard from '@/components/projects/ProjectCard.vue';
import CreateProjectModal from '@/components/projects/CreateProjectModal.vue';
import { useProjectStore } from '@/stores/project';

const router = useRouter();
const projectStore = useProjectStore();

const searchQuery = ref('');
const activeTab = ref('active');
const showCreateModal = ref(false);

onMounted(() => {
  projectStore.fetchProjects();
});

const filteredProjects = computed(() => {
  return projectStore.projects.filter(project => {
    const matchesSearch = project.name.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
                          project.key.toLowerCase().includes(searchQuery.value.toLowerCase());
    const matchesTab = activeTab.value === 'all' || project.status === activeTab.value;
    return matchesSearch && matchesTab;
  });
});

function openProject(id) {
  router.push(`/projects/${id}`);
}
</script>
