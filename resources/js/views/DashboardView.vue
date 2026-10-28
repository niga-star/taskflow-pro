<template>
  <div class="min-h-screen bg-slate-950 p-8 text-white">
    <div class="mx-auto max-w-4xl rounded-xl border border-slate-800 bg-slate-900 p-6">
      <div class="flex items-center justify-between">
        <div>
          <h1 class="text-2xl font-bold">Workspace Dashboard</h1>
          <p class="text-sm text-slate-400">Logged in as {{ authStore.user?.name }} ({{ authStore.user?.email }})</p>
        </div>
        <button
          @click="handleLogout"
          class="rounded-lg bg-rose-600 px-4 py-2 text-xs font-semibold hover:bg-rose-500 transition-colors"
        >
          Sign Out
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { onMounted } from 'vue';
import { useRouter } from 'vue-router';
import { useAuthStore } from '@/stores/auth';

const router = useRouter();
const authStore = useAuthStore();

onMounted(async () => {
  if (!authStore.user) {
    await authStore.fetchCurrentUser();
  }
});

async function handleLogout() {
  await authStore.logout();
  router.push('/login');
}
</script>

