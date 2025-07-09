<template>
  <div
    v-if="gdpr_status == 1"
    :class="[
      properties.gdpr_position_class == 'right'
        ? 'gdpr-content right'
        : 'gdpr-content left',
    ]"
    :style="styleObject"
  >
    <div class="content" v-html="properties.gdpr_message"></div>
    <button class="btn" @click.prevent="agreeGdpr()">
      {{ properties.gdpr_btn_label }}
    </button>
  </div>
</template>
<script>
export default {
  name: "Gdpr",
  props: {
    properties: {
      type: Object,
      default: null,
    },
  },
  computed: {
    styleObject() {
      return {
        "--background-color":
          this.properties.gdpr_bg_color != null
            ? this.properties.gdpr_bg_color
            : "#222",
      };
    },
    gdpr_status() {
      let cooke_value = null;
      const cookies = document.cookie.split("; ");
      for (const cookie of cookies) {
        const [name, value] = cookie.split("=");
        if (name === "acceptCookies") {
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
    agreeGdpr() {
      const now = new Date();
      const expires = new Date(now.getTime() + 24 * 60 * 60 * 1000);
      document.cookie = `acceptCookies=1; expires=${expires.toUTCString()}; path=/`;
      this.properties.gdpr_status = 0;
    },
  },
};
</script>
<style scoped>
.gdpr-content {
  position: fixed;
  bottom: 20px;
  color: white;
  background-color: var(--background-color);
  padding: 20px;
  z-index: 9999;
  border-radius: 5px;
  width: 300px;
}
.gdpr-content .content {
  margin-bottom: 15px;
}
.left {
  left: 20px;
}
.right {
  right: 20px;
}
</style>