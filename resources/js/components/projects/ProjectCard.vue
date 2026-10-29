<template>
  <div
    @click="$emit('select', project.id)"
    class="group cursor-pointer rounded-xl border border-slate-800 bg-slate-900/60 p-5 hover:border-indigo-500/50 hover:bg-slate-900 transition-all duration-200 flex flex-col justify-between"
  >
    <div>
      <div class="flex items-center justify-between">
        <span class="rounded bg-indigo-500/10 px-2 py-0.5 text-xs font-bold text-indigo-400 border border-indigo-500/20">
          {{ project.key }}
        </span>
        <span
          class="text-[10px] uppercase tracking-wider font-semibold px-2 py-0.5 rounded-full"
          :class="project.status === 'active' ? 'bg-emerald-500/10 text-emerald-400' : 'bg-slate-700 text-slate-300'"
        >
          {{ project.status }}
        </span>
      </div>

      <h3 class="mt-3 text-base font-semibold text-white group-hover:text-indigo-400 transition-colors">
        {{ project.name }}
      </h3>
      <p class="mt-1 text-xs text-slate-400 line-clamp-2">
        {{ project.description || 'No description provided.' }}
      </p>
    </div>

    <div class="mt-5 border-t border-slate-800/80 pt-3 flex items-center justify-between text-xs text-slate-400">
      <div class="flex items-center gap-1.5">
        <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
        <span>{{ project.members_count }} {{ project.members_count === 1 ? 'member' : 'members' }}</span>
      </div>
      <span class="text-[11px] font-medium text-slate-500 capitalize">
        Role: <span class="text-slate-300">{{ project.current_user_role }}</span>
      </span>
    </div>
  </div>
</template>

<script setup>
defineProps({
  project: {
    type: Object,
    required: true,
  },
});
defineEmits(['select']);
</script>
