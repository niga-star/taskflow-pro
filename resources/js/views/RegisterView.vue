<template>
  <div class="flex min-h-screen items-center justify-center bg-slate-950 px-4 py-12">
    <div class="w-full max-w-md rounded-2xl border border-slate-800 bg-slate-900/70 p-8 shadow-xl backdrop-blur-sm">
      <div class="text-center">
        <span class="rounded-full bg-indigo-500/10 px-3 py-1 text-xs font-semibold text-indigo-400 ring-1 ring-indigo-500/30">
          TaskFlow Pro
        </span>
        <h2 class="mt-4 text-2xl font-bold text-white">Create an account</h2>
        <p class="mt-1 text-sm text-slate-400">Join your engineering workspace</p>
      </div>

      <div v-if="authStore.errorMessage" class="mt-4 rounded-lg bg-rose-500/10 p-3 text-sm text-rose-400 border border-rose-500/20">
        {{ authStore.errorMessage }}
      </div>

      <form @submit.prevent="handleRegister" class="mt-6 space-y-4">
        <div>
          <label class="block text-xs font-medium text-slate-300">Full Name</label>
          <input
            v-model="form.name"
            type="text"
            required
            class="mt-1 w-full rounded-lg border border-slate-700 bg-slate-800 px-3 py-2 text-sm text-white focus:border-indigo-500 focus:outline-none"
            placeholder="Alex Mercer"
          />
        </div>

        <div>
          <label class="block text-xs font-medium text-slate-300">Job Title</label>
          <input
            v-model="form.job_title"
            type="text"
            class="mt-1 w-full rounded-lg border border-slate-700 bg-slate-800 px-3 py-2 text-sm text-white focus:border-indigo-500 focus:outline-none"
            placeholder="Full Stack Developer"
          />
        </div>

        <div>
          <label class="block text-xs font-medium text-slate-300">Email Address</label>
          <input
            v-model="form.email"
            type="email"
            required
            class="mt-1 w-full rounded-lg border border-slate-700 bg-slate-800 px-3 py-2 text-sm text-white focus:border-indigo-500 focus:outline-none"
            placeholder="alex@taskflow.dev"
          />
        </div>

        <div>
          <label class="block text-xs font-medium text-slate-300">Password</label>
          <input
            v-model="form.password"
            type="password"
            required
            minlength="8"
            class="mt-1 w-full rounded-lg border border-slate-700 bg-slate-800 px-3 py-2 text-sm text-white focus:border-indigo-500 focus:outline-none"
            placeholder="Min. 8 characters"
          />
        </div>

        <div>
          <label class="block text-xs font-medium text-slate-300">Confirm Password</label>
          <input
            v-model="form.password_confirmation"
            type="password"
            required
            class="mt-1 w-full rounded-lg border border-slate-700 bg-slate-800 px-3 py-2 text-sm text-white focus:border-indigo-500 focus:outline-none"
            placeholder="Re-enter password"
          />
        </div>

        <button
          type="submit"
          :disabled="authStore.isLoading"
          class="w-full rounded-lg bg-indigo-600 py-2.5 text-sm font-semibold text-white hover:bg-indigo-500 disabled:opacity-50 transition-colors"
        >
          <span v-if="authStore.isLoading">Creating account...</span>
          <span v-else>Register & Get Started</span>
        </button>
      </form>

      <p class="mt-6 text-center text-xs text-slate-400">
        Already have an account?
        <router-link to="/login" class="text-indigo-400 hover:text-indigo-300 font-medium">Sign in</router-link>
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
  name: '',
  job_title: '',
  email: '',
  password: '',
  password_confirmation: '',
});

async function handleRegister() {
  try {
    await authStore.register(form);
    router.push('/dashboard');
  } catch (error) {
    // Handled in store
  }
}
</script>
