{{-- Notification Icon --}}
<div class="lm-notification-widget" x-data="{
                                openNotif: false, 
                                notifications: JSON.parse(localStorage.getItem('notifications') || '[]'), 
                                unreadCount: JSON.parse(localStorage.getItem('unreadCount') || '0'),
                                maxNotifs: 7,
                                addNotification(notif) {
                                    this.notifications.unshift(notif);
                                    if (this.notifications.length > this.maxNotifs) this.notifications.pop();
                                    this.unreadCount++;
                                    localStorage.setItem('notifications', JSON.stringify(this.notifications));
                                    localStorage.setItem('unreadCount', JSON.stringify(this.unreadCount));
                                },
                                clearUnread() {
                                    this.unreadCount = 0;
                                    localStorage.setItem('unreadCount', JSON.stringify(this.unreadCount));
                                },
                                clearAll() {
                                    this.notifications = [];
                                    this.unreadCount = 0;
                                    localStorage.removeItem('notifications');
                                    localStorage.removeItem('unreadCount');
                                }
                            }" x-init="
                                window.addEventListener('new-notification', e => addNotification(e.detail));
                            ">
    <!-- Bell Button -->
    <button @click="openNotif = !openNotif; if (openNotif) clearUnread();"
        class="tw-relative tw-p-2 tw-rounded-full hover:tw-bg-green-100 tw-transition">
        <!-- Bell Icon -->
        <svg xmlns="http://www.w3.org/2000/svg"
            class="tw-w-7 tw-h-7 tw-text-green-600 tw-drop-shadow-[0_0_6px_rgba(66,204,122,0.3)]" viewBox="0 0 24 24"
            fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
            <path d="M12 3a6 6 0 0 0-6 6v3.5l-1.5 2A1 1 0 0 0 5 16h14a1 1 0 0 0 .5-1.5l-1.5-2V9a6 6 0 0 0-6-6z" />
            <path d="M10 19a2 2 0 0 0 4 0" />
        </svg>

        <!-- Notification Count -->
        <span x-show="unreadCount" x-text="unreadCount"
            class="tw-absolute tw-top-1 tw-right-1 tw-bg-red-500 tw-text-white tw-text-xs tw-rounded-full tw-px-1.5">
        </span>
    </button>

    <!-- Notification Dropdown -->
    <div x-show="openNotif" x-cloak @click.away="openNotif = false" x-transition
        class="tw-absolute tw-left-0 tw-mt-2 tw-bg-white tw-rounded-xl tw-shadow-lg tw-border tw-border-gray-200 tw-z-50 tw-overflow-hidden tw-min-w-[280px] tw-max-w-xs">

        <!-- Clear All Button -->
        <div class="tw-flex tw-justify-end tw-p-2 tw-border-b tw-border-gray-100">
            <button @click="clearAll()" class="tw-text-xs tw-text-gray-500 hover:tw-text-gray-700 tw-transition">Clear
                All</button>
        </div>

        <!-- Notification List -->
        <template x-if="notifications.length > 0">
            <ul>
                <template x-for="(notif, index) in notifications" :key="index">
                    <li
                        class="tw-flex tw-items-start tw-gap-2 tw-p-3 tw-border-b tw-border-gray-100 hover:tw-bg-green-50 tw-transition">
                        <!-- Icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="tw-w-5 tw-h-5 tw-text-green-600 flex-shrink-0"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M13 16h-1v-4h-1m1-4h.01M12 20c4.418 0 8-3.582 8-8s-3.582-8-8-8-8 3.582-8 8 3.582 8 8 8z" />
                        </svg>
                        <!-- Text -->
                        <div class="tw-flex-1">
                            <p class="tw-text-sm tw-text-gray-800" x-text="notif.message"></p>
                            <p class="tw-text-xs tw-text-gray-500" x-text="notif.time"></p>
                        </div>
                    </li>
                </template>
            </ul>
        </template>

        <!-- Empty State -->
        <div x-show="notifications.length === 0" class="tw-p-3 tw-text-gray-500 tw-text-sm tw-text-center">
            No notifications yet.
        </div>
    </div>
</div>