<template>
      <!-- Categories -->
  <section class="category-section home-page-section">
    <div class="px-3 px-sm-0">
      <swiper
        v-if="properties.categories.length && properties.style == 'slider'"
        :modules="modules"
        :loop="true"
        :centeredSlides="true"
        :autoplay="{
          delay: 2500,
          disableOnInteraction: false,
          pauseOnMouseEnter: true,
        }"
        :pagination="{
          clickable: true,
        }"
        class="category-slider category-full-width theme-slider-dots"
        :breakpoints="{
          '0': {
            slidesPerView: 2,
            spaceBetween: 16,
          },
          '768': {
            slidesPerView: 3,
            spaceBetween: 20,
          },
          '1024': {
            slidesPerView: 4,
            spaceBetween: 20,
          },
          '1440': {
            slidesPerView: 5,
            spaceBetween: 20,
          },
        }"
      >
        <swiper-slide
          v-for="(cat, index) in properties.categories"
          :key="`category-${index}`"
        >
          <category-card :cat="cat" />
        </swiper-slide>
      </swiper>
      <div class="row" v-else>
        <div v-for="(cat, index) in properties.categories" :key="`category-${index}`" class="col-6 col-sm-6 col-md-4 col-lg-3 col-xl-2">
            <category-card :cat="cat" />
        </div>
      </div>
    </div>
  </section>
  <!-- End Categories -->
</template>

<script>
import { defineAsyncComponent } from "vue";
import { Swiper, SwiperSlide } from "swiper/vue";
const CategoryCard = defineAsyncComponent(() =>
    import("../../ui/CategoryCard.vue")
);

import { Autoplay, Pagination } from "swiper";

export default {
    name: "CategorySlider",
    components: {
        CategoryCard,
        Swiper,
        SwiperSlide,
    },
    setup() {
        return {
            modules: [Autoplay, Pagination],
        };
    },
    props: {
        properties: {
            type: Object,
            default: {},
        },
    },
};
</script>
