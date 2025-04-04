<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800"
            >
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div
                    class="overflow-hidden bg-white shadow-sm sm:rounded-lg"
                >
                    <div class="p-6 text-gray-900">
                        You're logged in!
                    </div>

                  <div class="p-6 text-gray-900" v-if="isSupervisor">
                    <Link
                        href="/supervisor/action"
                        method="post"
                        class="text-sm text-gray-700 dark:text-gray-500 hover:underline"
                    >
                        Action Import
                    </Link>
                  </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { Link } from '@inertiajs/vue3';

export default {
  name: 'Dashboard',
  components: {
    AuthenticatedLayout,
    Head,
    Link
  },
  props: {
    isSupervisor: {
      type: Boolean,
      default: false
    }
  }
}
</script>
