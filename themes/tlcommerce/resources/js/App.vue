<template>
  <div v-if="themeStyle">
    <component :is="layout">
      <RouterView />
    </component>
  </div>
</template>

<script>
import MainLayout from "./layouts/MainLayout.vue";
const axios = require("axios").default;
export default {
  components: {
    MainLayout,
  },
  data() {
    return {
      themeStyle: null,
    };
  },
  computed: {
    layout() {
      return this.$route.meta.layout || MainLayout;
    },
  },
  async created() {
    this.themeStyle = await axios.get(
      "/api/theme/tlcommerce/v1/get-theme-color"
    );
    let themeColor = this.themeStyle.data.themeColor.theme_primary_color;

    if (themeColor != null) {
      document.documentElement.style.setProperty("--mainC", themeColor);
    }
  },
};
</script>
