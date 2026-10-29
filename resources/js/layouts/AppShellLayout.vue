<template>
  <div class="flex h-screen bg-slate-950 text-slate-100 overflow-hidden">
    <!-- Sidebar -->
    <aside class="w-64 border-r border-slate-800 bg-slate-900/60 flex flex-col justify-between p-4">
      <div class="space-y-6">
        <div class="flex items-center gap-3 px-2">
          <div class="h-8 w-8 rounded-lg bg-indigo-600 flex items-center justify-center font-bold text-white shadow-lg shadow-indigo-500/30">
            TF
          </div>
          <div>
            <h1 class="text-sm font-bold tracking-tight text-white leading-none">TaskFlow Pro</h1>
            <span class="text-[10px] text-slate-400 font-medium">Sprint & Time Tracker</span>
          </div>
        </div>

        <nav class="space-y-1">
          <router-link
            to="/dashboard"
            class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition-colors"
            :class="$route.path === '/dashboard' ? 'bg-indigo-600 text-white' : 'text-slate-400 hover:bg-slate-800 hover:text-white'"
          >
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
            Projects
          </router-link>
        </nav>
      </div>

      <!-- User Profile & Sign Out -->
      <div class="border-t border-slate-800 pt-3 flex items-center justify-between px-2">
        <div class="flex items-center gap-2 overflow-hidden">
          <img :src="authStore.user?.avatar_url" class="h-8 w-8 rounded-full border border-slate-700 object-cover" />
          <div class="overflow-hidden">
            <p class="text-xs font-semibold text-white truncate">{{ authStore.user?.name }}</p>
            <p class="text-[10px] text-slate-400 truncate">{{ authStore.user?.job_title }}</p>
          </div>
        </div>
        <button @click="logout" class="text-slate-400 hover:text-rose-400 transition-colors p-1" title="Sign out">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
        </button>
      </div>
    </aside>

    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col overflow-hidden">
      <main class="flex-1 overflow-y-auto p-8">
        <slot />
      </main>
    </div>
  </div>
</template>

<script setup>
import { useRouter } from 'vue-router';
import { useAuthStore } from '@/stores/auth';

const router = useRouter();
const authStore = useAuthStore();

async function logout() {
  await authStore.logout();
  router.push('/login');
}
</script>
