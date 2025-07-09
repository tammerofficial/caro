<template>
  <section
    class="collection-section home-page-section"
    :style="styleObject"
    v-if="properties[0].products.data.length"
  >
    <div class="custom-container2">
      <div class="row align-items-center">
        <div class="col-md-6">
          <section-title
            class="mb-30 section-title"
            :title="
              properties[0].category_info != null
                ? properties[0].category_info.name
                : $t(properties.title)
            "
            :titleColor="properties.title_color"
          />
        </div>
        <div
          class="col-md-6 text-md-end"
          v-if="properties.content == 'category'"
        >
          <router-link
            v-if="properties[0].category_info != null"
            class="btn btn-sm rounded-0 mb-30 section_btn"
            :style="styleObject"
            :to="`/products/category/${properties[0].category_info.slug}`"
          >
            {{
              properties.btn_title != null
                ? properties.btn_title
                : $t("View All")
            }}
          </router-link>
        </div>
      </div>
      <swiper
        v-if="properties[0].products.data.length"
        :slidesPerView="6"
        :modules="modules"
        :spaceBetween="1"
        :autoplay="{
          delay: 4000,
          disableOnInteraction: false,
          pauseOnMouseEnter: true,
        }"
        :loop="true"
        :pagination="{
          clickable: true,
        }"
        class="product-grid-slider theme-slider-dots"
        :breakpoints="{
          '0': {
            slidesPerView: 2,
          },
          '480': {
            slidesPerView: 2,
          },
          '768': {
            slidesPerView: 3,
          },
          '1024': {
            slidesPerView: 6,
          },
        }"
      >
        <swiper-slide
          v-for="(item, index) in properties[0].products.data"
          :key="`slide-${index}`"
        >
          <single-product :item="item" />
        </swiper-slide>
      </swiper>
    </div>
  </section>
</template>
<script>
import { defineAsyncComponent } from "vue";
// Import Swiper Vue.js components
import { Swiper, SwiperSlide } from "swiper/vue";
// import required modules
import { Autoplay, Pagination } from "swiper";
const SingleProduct = defineAsyncComponent(() =>
  import("../product/SingleProduct.vue")
);

export default {
  name: "CustomProductSection",
  components: {
    Swiper,
    SwiperSlide,
    SingleProduct,
  },
  setup() {
    return {
      modules: [Autoplay, Pagination],
    };
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
  data() {
    return {
      collectionDetails: {},
    };
  },
  computed: {
    styleObject() {
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
.section_btn {
  color: var(--button-color);
  background-color: var(--button-background-color);
  border: var(--button-border);
  border-color: var(--button-border-color);
}
.section_btn:hover {
  color: var(--button-hover-color);
  background-color: var(--button-hover-bg-color);
  border-color: var(--button-hover-border-color);
}
.collection-section {
  background-image: var(--section-background-image);
  background-color: var(--section-background-color);
  padding: var(--section-padding) !important;
  margin: var(--section-margin) !important;
  background-position: var(--section-background-image-position);
  background-size: var(--section-background-image-size);
  background-repeat: var(--section-background-image-repeat);
}
</style>
