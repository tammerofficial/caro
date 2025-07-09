<template>
  <!-- Widget Nav Menu -->
  <div class="widget widget_nav_menu">
    <template v-if="footer_right_menu != null">
      <h3
        :class="
          this.footerStyle.custom_footer == 1
            ? 'custom-title-style'
            : 'widget-title'
        "
      >
        {{ footer_right_menu.widget_title }}
      </h3>

      <ul v-if="footer_right_menu.footer_right_menu">
        <li
          v-for="(item, index) in footer_right_menu.footer_right_menu"
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
  name: "footer_right_menu",
  props: {
    footer_right_menu: {
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

