<template>
  <!-- Ad Section -->
  <section class="mb-15 mt-15 ads-section home-page-section" :style="cssVars">
    <div class="custom-container2">
      <div class="row">
        <div
          v-for="(ad, index) in properties.ads"
          :key="`ad-${index}`"
          :class="`col-lg-${ad.column}`"
        >
          <a :href="ad.url" target="_blank" class="d-block mb-30 mh-294">
            <v-lazy-image class="w-100 lmh-294" :src="ad.image" :alt="index" />
          </a>
        </div>
      </div>
    </div>
  </section>
  <!-- End Ad Section -->
</template>
<script>
import VLazyImage from "v-lazy-image";
export default {
  name: "AdsSection",
  components: {
    "v-lazy-image": VLazyImage,
  },
  props: {
    content: {
      type: String,
      required: false,
    },
    properties: {
      type: Array,
      required: false,
    },
  },
  computed: {
    cssVars() {
      return {
        //Section
        "--section-background-color": this.properties.bg_color,
        "--section-background-image": `url(${this.properties.bg_image})`,
        "--section-background-image-position":
          this.properties.background_position,
        "--section-background-image-size": this.properties.background_size,
        "--section-background-image-repeat": this.properties.background_repeat,
        "--section-padding": `${
          this.properties.padding_top +
          "px " +
          this.properties.padding_right +
          "px " +
          this.properties.padding_bottom +
          "px " +
          this.properties.padding_left +
          "px"
        }`,
        "--section-margin": `${
          this.properties.margin_top +
          "px " +
          this.properties.margin_right +
          "px " +
          this.properties.margin_bottom +
          "px " +
          this.properties.margin_left +
          "px"
        }`,
        //Button
        "--button-color": this.properties.btn_color,
        "--button-background-color": this.properties.btn_bg_color,
        "--button-border":
          this.properties.btn_border != null
            ? this.properties.btn_border + "px solid"
            : 0 + "px",
        "--button-border-color": this.properties.btn_border_color,
        "--button-hover-border-color": this.properties.btn_border_hover_color,
        "--button-hover-bg-color": this.properties.btn_bg_hover_color,
        "--button-hover-color": this.properties.btn_hover_color,
      };
    },
  },
};
</script>
<style scoped>
.ads-section {
  background-image: var(--section-background-image);
  background-color: var(--section-background-color);
  padding: var(--section-padding) !important;
  margin: var(--section-margin) !important;
  background-position: var(--section-background-image-position);
  background-size: var(--section-background-image-size);
  background-repeat: var(--section-background-image-repeat);
}
.mh-294 {
  max-height: 294px;
  overflow: hidden;
}
</style>
