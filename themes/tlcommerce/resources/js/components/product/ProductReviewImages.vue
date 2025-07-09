<template>
  <div class="review-images">
    <FsLightbox :toggler="toggler" :sources="images" />
    <img
      v-for="(image, index) in images"
      :src="image"
      alt="image"
      :key="index"
      @click="toggler = !toggler"
    />
  </div>
</template>
<script>
import FsLightbox from "fslightbox-vue/v3";
export default {
  name: "ProductReviewImages",
  components: {
    FsLightbox,
  },
  props: {
    images: {
      type: Array,
      required: false,
    },
  },
  data() {
    return {
      toggler: true,
    };
  },
};
</script>

