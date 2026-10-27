<template>
  <div class="flex min-h-screen items-center justify-center bg-slate-950 px-4 py-12">
    <div class="w-full max-w-md rounded-2xl border border-slate-800 bg-slate-900/70 p-8 shadow-xl backdrop-blur-sm">
      <div class="text-center">
        <span class="rounded-full bg-indigo-500/10 px-3 py-1 text-xs font-semibold text-indigo-400 ring-1 ring-indigo-500/30">
          TaskFlow Pro
        </span>
        <h2 class="mt-4 text-2xl font-bold text-white">Welcome back</h2>
        <p class="mt-1 text-sm text-slate-400">Sign in to manage your agile sprints</p>
      </div>

      <div v-if="authStore.errorMessage" class="mt-4 rounded-lg bg-rose-500/10 p-3 text-sm text-rose-400 border border-rose-500/20">
        {{ authStore.errorMessage }}
      </div>

      <form @submit.prevent="handleLogin" class="mt-6 space-y-4">
        <div>
          <label class="block text-xs font-medium text-slate-300">Email Address</label>
          <input
            v-model="form.email"
            type="email"
            required
            class="mt-1 w-full rounded-lg border border-slate-700 bg-slate-800 px-3 py-2 text-sm text-white focus:border-indigo-500 focus:outline-none"
            placeholder="developer@example.com"
          />
        </div>

        <div>
          <label class="block text-xs font-medium text-slate-300">Password</label>
          <input
            v-model="form.password"
            type="password"
            required
            class="mt-1 w-full rounded-lg border border-slate-700 bg-slate-800 px-3 py-2 text-sm text-white focus:border-indigo-500 focus:outline-none"
            placeholder="••••••••"
          />
        </div>

        <button
          type="submit"
          :disabled="authStore.isLoading"
          class="w-full rounded-lg bg-indigo-600 py-2.5 text-sm font-semibold text-white hover:bg-indigo-500 disabled:opacity-50 transition-colors"
        >
          <span v-if="authStore.isLoading">Signing in...</span>
          <span v-else>Sign In</span>
        </button>
      </form>

      <p class="mt-6 text-center text-xs text-slate-400">
        Don't have an account?
        <router-link to="/register" class="text-indigo-400 hover:text-indigo-300 font-medium">Create one</router-link>
      </p>
    </div>
  </div>
</template>

<script setup>
import { reactive } from 'vue';
import { useRouter } from 'vue-router';
import { useAuthStore } from '@/stores/auth';

const router = useRouter();
const authStore = useAuthStore();

const form = reactive({
  email: '',
  password: '',
});

async function handleLogin() {
  try {
    await authStore.login(form);
    router.push('/dashboard');
  } catch (error) {
    // Handled in store
  }
}
</script>
