<template>
  <!-- Top Sellers -->
  <section class="top-seller-section home-page-section" :style="styleObject">
    <div class="custom-container2" v-if="!dataLoading">
      <div class="row align-items-center">
        <div class="col-md-6">
          <section-title
            class="mb-30 section-title"
            :title="properties.title"
            :titleColor="properties.title_color"
          />
        </div>
        <div class="col-md-6 text-md-end">
          <router-link
            class="btn btn-sm rounded-0 mb-30 section_btn"
            :style="styleObject"
            to="/all-shops"
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
        v-if="sellers.length"
        :slidesPerView="4"
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
            slidesPerView: 4,
          },
        }"
      >
        <swiper-slide v-for="(shop, index) in sellers" :key="`slide-${index}`">
          <single-shop
            :shop="shop"
            hasBanner
            v-if="properties.banner_option == 'with_banner'"
          ></single-shop>
          <single-shop :shop="shop" v-else></single-shop>
        </swiper-slide>
      </swiper>
    </div>
    <!--Preloader-->
    <section-preloader v-if="dataLoading"></section-preloader>
    <!--End Preloader-->
  </section>
  <!-- End Top Sellers -->
</template>
<script>
// Import Swiper Vue.js components
import { Swiper, SwiperSlide } from "swiper/vue";
// import required modules
import { Autoplay, Pagination } from "swiper";
import SingleShop from "@/components/shop/SingleShop.vue";
import sectionPreloader from "./sectionPreloader.vue";
const axios = require("axios").default;

export default {
  name: "TopSellers",
  components: {
    Swiper,
    SwiperSlide,
    SingleShop,
    sectionPreloader,
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
      sellers: [],
      dataLoading: true,
      bgImage: null,
    };
  },
  mounted() {
    this.getTopSellerLists();
  },
  methods: {
    /**
     *Seller Lists
     */
    getTopSellerLists() {
      axios
        .post("/api/v1/multivendor/top-seller-list", {
          seller_ids: this.content,
        })
        .then((response) => {
          if (response.data.success) {
            this.sellers = response.data.data;
          }
          this.dataLoading = false;
        })
        .catch((error) => {
          this.dataLoading = false;
        });
    },
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
.top-seller-section {
  background-image: var(--section-background-image);
  background-color: var(--section-background-color);
  padding: var(--section-padding) !important;
  margin: var(--section-margin) !important;
  background-position: var(--section-background-image-position);
  background-size: var(--section-background-image-size);
  background-repeat: var(--section-background-image-repeat);
}
</style>
