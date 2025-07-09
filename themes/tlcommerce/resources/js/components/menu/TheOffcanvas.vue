<template>
    <!-- Offcanvas -->
    <div class="offcanvas-container d-flex">
        <!-- Offcanvas Trigger -->
        <button
            class="hamburger"
            :class="{ active: isOffcanvasOpened }"
            @click="toggleOffcanvas"
        >
            <span class="bg-white"></span>
            <span class="bg-white"></span>
            <span class="bg-white"></span>
        </button>
        <!-- End Offcanvas Trigger -->

        <div class="offcanvas-wrapper" :class="{ open: isOffcanvasOpened }">
            <div :class="this.headerStyle.custom_header==1?'offcanvas-panel custom-offcanvas-panel w-100 h-100 bg-white':'offcanvas-panel w-100 h-100 bg-white'">
                <div :class="this.headerStyle.custom_header==1?'custom-offcanvas-header offcanvas-header position-relative':'offcanvas-header position-relative'">
                    <!-- Offcanvas Close -->
                    <span
                        class="offcanvas-close d-inline-flex align-items-center justify-content-center position-absolute text-white"
                        @click="toggleOffcanvas"
                    >
                        <base-icon-svg name="close" />
                    </span>
                    <!-- End Offcanvas Close -->

                    <!-- User Info -->
                    <div v-if="userInfo.name" class="user-info">
                        <div class="user-avatar mb-10">
                            <img
                                class="rounded-circle"
                                :src="userInfo.image"
                                :alt="userInfo.name"
                                width="70"
                                height="70"
                            />
                        </div>
                        <h4 class="mb-0">{{ userInfo.name }}</h4>
                    </div>
                    <!-- End User Info -->

                    <!-- Login Register -->
                    <div v-else class="login-register mt-15">
                        <a href="/login">
                            {{ $t("Login") }}</a
                        >
                        |
                        <a href="/register">
                            {{ $t("Registration") }}
                        </a>
                    </div>
                    <!-- End Login Register -->
                </div>

                <div class="offcanvas-content bg-white">
                    <div class="offcanvas-menu">
                        <ul class="list-unstyled mb-0">
                            <template v-for="(item, index) in menuItems">
                                <menu-item
                                    v-if="!item.submenu"
                                    :key="`item-${index}`"
                                    :item="item"
                                    off-canvas
                                    :header-menu-style="headerMenuStyle"
                                />

                                <menu-dropdown
                                    v-else
                                    :key="`group-${index}`"
                                    :item="item"
                                    off-canvas
                                    :open-group="
                                        isGroupActive(item, $route.fullPath)
                                    "
                                    :header-menu-style="headerMenuStyle"
                                />
                            </template>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Offcanvas -->
</template>

<script>
import MenuItem from "./MenuItem.vue";
import MenuDropdown from "./MenuDropdown.vue";
export default {
    components: {
        MenuItem,
        MenuDropdown,
    },
    props: {
        userInfo: {
            type: Object,
            default: null,
        },
        menuItems: {
            type: Array,
            required: true,
        },
        headerMenuStyle: {
            type: Object,
            required: false,
            default: () => {
                return {};
            },
        },
        headerStyle: {
            type: Object,
            required: false,
            default: () => {
                return {};
            },
        },
    },
    data() {
        return {
            isOffcanvasOpened: false,
        };
    },
    computed: {
        isGroupActive() {
            return (item, path) => {
                let openGroup = false;
                const func = (item) => {
                    if (item.submenu) {
                        item.submenu.forEach((item) => {
                            if (path === item.url) {
                                openGroup = true;
                            } else if (item.submenu) {
                                func(item);
                            }
                        });
                    }
                };
                func(item, path);
                return openGroup;
            };
        },
    },
    methods: {
        toggleOffcanvas() {
            this.isOffcanvasOpened = !this.isOffcanvasOpened;
            document.body.classList.toggle("offcanvas-oppened");
        },
    },
};
</script>

<style lang="scss" scoped>
</style>
