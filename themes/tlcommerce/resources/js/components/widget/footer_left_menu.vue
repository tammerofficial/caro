<template>
  <!-- Widget Nav Menu -->
  <div class="widget widget_nav_menu">
    <template v-if="footer_left_menu != null">
      <h3
        :class="
          this.footerStyle.custom_footer == 1
            ? 'custom-title-style'
            : 'widget-title'
        "
      >
        {{ footer_left_menu.widget_title }}
      </h3>

      <ul v-if="footer_left_menu.footer_left_menu">
        <li
          v-for="(item, index) in footer_left_menu.footer_left_menu"
          :key="`menu-${index}`"
        >
          <a :href="item.url">{{ item.name }}</a>
        </li>
      </ul>
    </template>
  </div>
  <!-- End Widget Nav Menu -->
</template>

<script>
export default {
  name: "footer_left_menu",
  props: {
    title: {
      type: String,
      default: "Menu",
    },
    footer_left_menu: {
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
