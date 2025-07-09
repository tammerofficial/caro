<template>
  <li
    :class="[
      { 'active-menu-parent': openGroup },
      { 'menu-group-opened': isOpen },
    ]"
  >
    <router-link :to="item.url ? item.url : 'javascript:void(0);'">
      <span :class="this.headerMenuStyle.custom_menu == 1 ? 'custom-menu' : ''">
        {{ item.name }}
      </span>
      <span class="submenu-button ml-2">
        <i class="fa fa-angle-down"></i>
      </span>
    </router-link>

    <span
      class="
        submenu-button
        d-lg-none
        ml-2
        d-inline-flex
        align-items-center
        justify-content-center
      "
      :class="{ open: computedClass }"
      @click="submenuClick"
    >
      <i class="fa" :class="computedClass ? 'fa-angle-up' : 'fa-angle-down'">
      </i>
    </span>

    <ul v-if="isShow" class="submenu">
      <template v-for="(subitem, subindex) in item.submenu">
        <menu-dropdown
          v-if="subitem.submenu && subitem.submenu.length > 0"
          :key="`subitem-${subindex}`"
          :item="subitem"
          :open-group="openGroup"
          :header-menu-style="this.headerMenuStyle"
        />

        <menu-item
          v-else
          :key="`subitem-${subindex}`"
          :item="subitem"
          :header-menu-style="this.headerMenuStyle"
        />
      </template>
    </ul>
  </li>
</template>

<script>
import MenuItem from "./MenuItem.vue";
export default {
  name: "MenuDropdown",
  components: {
    MenuItem,
  },
  props: {
    item: {
      type: Object,
      required: true,
    },
    openGroup: { type: Boolean, default: false },
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
      isActive: false,
      isOpen: false,
      isShow: false,
    };
  },
  computed: {
    computedClass() {
      return this.isActive || this.isOpen;
    },
  },
  watch: {
    $route() {
      if (!this.openGroup) {
        this.isActive = false;
      } else {
        this.isActive = true;
      }
    },
  },
  mounted() {
    if (this.openGroup) {
      this.isActive = true;
      this.isShow = true;
      this.isOpen = true;
    }

    if (window.innerWidth > 991) {
      this.isActive = false;
      this.isShow = true;
      this.isOpen = false;
    }
  },
  methods: {
    submenuClick() {
      this.isActive = !this.isActive;
      this.isOpen = !this.isOpen;
      this.isShow = !this.isShow;
    },
  },
};
</script>
<style scoped>
</style>