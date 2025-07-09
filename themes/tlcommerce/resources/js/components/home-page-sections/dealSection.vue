<template>
  <section
    class="pt-15 pb-15 deals-section home-page-section"
    :style="styleObject"
  >
    <div class="custom-container2" v-if="success && !dataLoading">
      <div class="row align-items-center my-3">
        <div class="col-md-6 mb-2 mb-md-0">
          <section-title
            class="section-title"
            :title="dealDetails.title"
            :titleColor="properties.title_color"
          />
        </div>
        <div class="col-md-6">
          <countdown
            class="justify-content-md-end"
            :deadline="dealDetails.deadline"
            :titleColor="properties.title_color"
          />
        </div>
      </div>
      <swiper
        v-if="dealProducts.length"
        :slidesPerView="6"
        :modules="modules"
        :spaceBetween="1"
        :autoplay="{
          delay: 2500,
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
          '768': {
            slidesPerView: 3,
          },
          '1024': {
            slidesPerView: 6,
          },
        }"
      >
        <swiper-slide
          v-for="(item, index) in dealProducts"
          :key="`slide-${index}`"
        >
          <single-product :item="item" />
        </swiper-slide>
      </swiper>
      <div class="col-md-12 text-center mt-20">
        <router-link
          class="btn btn-sm rounded-0 mb-30 section_btn"
          :style="styleObject"
          :to="`/deals/${dealDetails.permalink}`"
        >
          {{
            properties.btn_title != null ? properties.btn_title : $t("View All")
          }}
        </router-link>
      </div>
    </div>
  </section>
</template>

<script>
import { defineAsyncComponent } from "vue";
import { Swiper, SwiperSlide } from "swiper/vue";
import { Autoplay, Pagination } from "swiper";
const SingleProduct = defineAsyncComponent(() =>
  import("../product/SingleProduct.vue")
);
const Countdown = defineAsyncComponent(() => import("../ui/Countdown.vue"));
import sectionPreloader from "./sectionPreloader.vue";
const axios = require("axios").default;
export default {
  name: "DealSection",
  components: {
    Swiper,
    SwiperSlide,
    SingleProduct,
    Countdown,
    sectionPreloader,
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
  setup() {
    return {
      modules: [Autoplay, Pagination],
    };
  },
  data() {
    return {
      dealDetails: {},
      dealProducts: [],
      success: false,
      dataLoading: true,
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
  mounted() {
    this.getDealDetails();
  },
  methods: {
    /**
     * Deals Details
     */
    getDealDetails() {
      axios
        .post("/api/theme/tlcommerce/v1/deal-details", {
          id: this.content,
        })
        .then((response) => {
          if (response.data.success) {
            this.dealDetails = response.data.dealsDetails;
            this.dealProducts = response.data.products.data;
            this.success = true;
            this.dataLoading = false;
          }
        })
        .catch((error) => {
          this.success = false;
          this.dataLoading = false;
        });
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
.deals-section {
  background-image: var(--section-background-image);
  background-color: var(--section-background-color);
  padding: var(--section-padding) !important;
  margin: var(--section-margin) !important;
  background-position: var(--section-background-image-position);
  background-size: var(--section-background-image-size);
  background-repeat: var(--section-background-image-repeat);
}
</style>