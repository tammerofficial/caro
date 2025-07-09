<template>
    <!-- Widget Nav Menu -->
    <div class="widget widget_nav_menu">
        <h3 :class="this.footerStyle.custom_footer==1?'custom-title-style':'widget-title'">
            {{ title }}
        </h3>

        <ul v-if="menus">
            <li v-for="(item, index) in menus" :key="`menu-${index}`">
                <a :href="item.url">{{ item.name }}</a>
            </li>
        </ul>
    </div>
    <!-- End Widget Nav Menu -->
</template>

<script>
export default {
    name: "WidgetNavMenu",
    props: {
        title: {
            type: String,
            default: "Menu",
        },
        menus: {
            type: Array,
            default: () => {},
        },
        titleStyleThree: {
            type: Boolean,
            default: false,
        },
        footerStyle: {
            type: Object,
            required: false,
            default: () => {
                return {};
            },
        },
        footerStyle: {
            type: Object,
            required: false,
            default: () => {
                return {};
            },
        },
    },
};
</script>

<style lang="scss" scoped>
</style>
