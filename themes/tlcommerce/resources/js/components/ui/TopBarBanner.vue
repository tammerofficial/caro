<template>
  <div class="top-bar-banner" v-if="banner_status == 1">
    <a :href="properties.topbar_banner_link" class="top-bar-banner_link">
      <img :src="properties.topbar_banner_image" />
      <button
        class="top-bar-banner_close_btn btn-circle size-35"
        @click.prevent="closeBanner()"
      >
        <base-icon-svg name="close" :width="10" :height="10" />
      </button>
    </a>
  </div>
</template>
<script>
export default {
  name: "TopBarBanner",
  props: {
    properties: {
      type: Object,
      default: null,
    },
  },
  computed: {
    banner_status() {
      let cooke_value = null;
      const cookies = document.cookie.split("; ");
      for (const cookie of cookies) {
        const [name, value] = cookie.split("=");
        if (name === "top_bar_banner") {
          cooke_value = value;
        }
      }
      if (cooke_value != null && cooke_value == 1) {
        return 0;
      }

      return 1;
    },
  },
  methods: {
    closeBanner() {
      const now = new Date();
      const expires = new Date(now.getTime() + 2 * 60 * 60 * 1000);
      document.cookie = `top_bar_banner=1; expires=${expires.toUTCString()}; path=/`;
      this.properties.topbar_banner_status = 0;
    },
  },
};
</script>
<style scoped>
.top-bar-banner {
  top: 0px;
}

.top-bar-banner img {
  min-height: 36px;
}

.top-bar-banner_link {
  display: inline-block;
  position: relative;
}

.top-bar-banner_close_btn {
  position: absolute;
  border: none;
  top: 50%;
  right: 20px;
  transform: translateY(-50%);
}
</style>