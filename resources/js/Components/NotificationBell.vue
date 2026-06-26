<script setup>
import { ref, computed } from 'vue'
import { usePage } from '@inertiajs/vue3'

const page = usePage()
const open = ref(false)

const notifications = computed(() => {
    return page.props.notifications?.items ?? []
})

const unreadCount = computed(() => {
    return page.props.notifications?.unread_count ?? 0
})

const toggleDropdown = () => {
    open.value = !open.value
}

const goToPost = (notification) => {
    router.post(`/notifications/${notification.id}/read`, {}, {
        preserveScroll: true,
        onSuccess: () => {
            open.value = false

            if (notification.data?.post_uuid) {
                router.visit(`/posts/${notification.data.post_uuid}`)
            }

            if (notification.post_uuid) {
                router.visit(`/posts/${notification.post_uuid}`)
            }
        },
    })
}
</script>

<template>
    <div class="relative">
        <!-- Bell Button -->
        <button type="button" @click="toggleDropdown"
            class="relative inline-flex items-center rounded-md bg-white px-3 py-2 text-sm text-gray-500 hover:text-gray-700 focus:outline-none">
            <span class="text-xl leading-none">🔔</span>

            <span v-if="unreadCount > 0"
                class="absolute -right-1 -top-1 inline-flex h-5 min-w-5 items-center justify-center rounded-full bg-red-600 px-1 text-xs font-bold text-white">
                {{ unreadCount }}
            </span>
        </button>

        <!-- Dropdown -->
        <div v-if="open"
            class="absolute right-0 z-50 mt-2 w-80 overflow-hidden rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5">
            <div class="border-b border-gray-200 px-4 py-3 font-semibold text-gray-700">
                Notifications
            </div>

            <div class="max-h-80 overflow-y-auto">
                <button v-for="notification in notifications" :key="notification.id" type="button"
                    @click="goToPost(notification)"
                    class="block w-full border-b border-gray-100 px-4 py-3 text-left hover:bg-gray-50">
                    <div class="text-sm font-medium text-gray-800">
                        {{ notification.user_name ?? 'New notification' }}
                    </div>

                    <div class="mt-1 text-sm text-gray-500">
                        {{ notification.data?.message ?? notification.message ?? 'You have a new notification.' }}
                    </div>
                </button>

                <div v-if="notifications.length === 0" class="px-4 py-6 text-center text-sm text-gray-500">
                    No notifications
                </div>
            </div>
        </div>
    </div>
</template>
