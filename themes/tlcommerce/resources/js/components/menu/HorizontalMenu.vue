<template>
    <nav class="nav d-flex align-items-center">
        <div
            class="d-lg-none hamburger"
            :class="{ active: isMenuActive }"
            @click="isMenuActive = !isMenuActive"
        >
            <span></span>
            <span></span>
            <span></span>
        </div>
        <ul class="nav-horizontal" :class="{ active: isMenuActive }">
            <template v-for="(item, index) in menuItems">
                <template v-if="item.submenu">
                    <template v-if="item.submenu && item.submenu.length < 1">
                        <menu-item
                        :key="`item-${index}`"
                        :item="item"
                        :header-menu-style="this.headerMenuStyle" 
                    />
                    </template>
                    <template  v-else>
                        <menu-dropdown
                        :key="`group-${index}`"
                        :item="item"
                        :open-group="isGroupActive(item, $route.fullPath)"
                        :header-menu-style="this.headerMenuStyle" 
                    />
                    </template>
                </template>
                <template v-else>
                    <menu-item :key="`item-${index}`" :item="item" :header-menu-style="this.headerMenuStyle" />
                </template>
            </template>
        </ul>
    </nav>
</template>

<script>
import MenuItem from "./MenuItem.vue";
import MenuDropdown from "./MenuDropdown.vue";
export default {
    name: "HorizontalMenu",
    components: {
        MenuItem,
        MenuDropdown,
    },
    props: {
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
    },
    data() {
        return {
            isMenuActive: false,
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
};
</script>
