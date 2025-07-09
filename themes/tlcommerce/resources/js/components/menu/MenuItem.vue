<template>
    <li>
        <a
            v-if="item.href"
            :href="item.href"
            :class="this.headerMenuStyle.custom_menu == 1 ? 'custom-menu' : ''"
        >
            <span v-if="offCanvas">
                {{ $t(item.name) }}
            </span>
            <span v-else>
            {{ item.name }}
          </span>
        </a>
        <a v-else :href="item.url">
          <span :class="this.headerMenuStyle.custom_menu == 1 ? 'custom-menu' : ''">
            <span v-if="offCanvas">
                {{ $t(item.name) }}
            </span>
            <span v-else>
                {{ item.name }}
          </span>
          </span>
        </a>
    </li>
</template>

<script>
export default {
    name: "MenuItem",
    props: {
        item: {
            type: Object,
            required: true,
        },
         offCanvas: {
            type: Boolean,
            required: false,
            default:false
        },
        headerMenuStyle: {
            type: Object,
            required: false,
            default: () => {
                return {};
            },
        },
    },
};
</script>

<style scoped>
</style>
