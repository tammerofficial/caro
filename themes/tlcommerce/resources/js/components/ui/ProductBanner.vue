<template>
  <div
    class="product-banner-item d-flex align-items-center justify-content-center"
  >
    <!-- Image -->
    <div class="slide-img desktop">
      <a :href="content.url">
        <img :src="content.desktop" alt="image" />
      </a>
    </div>
    <!-- End Image -->
    <!-- Image -->
    <div class="slide-img mobile">
      <a :href="content.url">
        <img :src="content.mobile" alt="image" />
      </a>
    </div>
    <!-- End Image -->
  </div>
</template>

<script>
import VLazyImage from "v-lazy-image";
export default {
  name: "ProductBanner",
  components: {
    "v-lazy-image": VLazyImage,
  },
  props: {
    content: {
      type: Object,
      required: true,
    },
  },
};
</script>

<style lang="scss" scoped>
@import "../../assets/sass/00-abstracts/01-variables";
.slide-img.desktop {
  @media (max-width: 767px) {
    display: none;
  }
}
.slide-img.mobile {
  display: none;
  @media (max-width: 767px) {
    display: block;
  }
}
</style>
