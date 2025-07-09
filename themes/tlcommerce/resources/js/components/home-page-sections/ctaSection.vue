<template>
  <section class="cta-section home-page-section" :style="styleObject">
    <div class="custom-container2">
      <div class="row align-items-center">
        <div
          v-if="properties.video_url"
          class="col-lg-4 d-flex justify-content-center"
        >
          <video-card
            :src="properties.video_url"
            :btn-border-color="properties.play_btn_border_color"
            :btn-icon-color="properties.play_btn_color"
          />
        </div>
        <div v-if="properties.cta_image" class="col-lg-4">
          <!-- CTA Image -->
          <div class="cta-image position-relative text-center my-50 my-lg-0">
            <img :src="properties.cta_image" alt="" />
          </div>
          <!-- End CTA Image -->
        </div>
        <div class="col-lg-4">
          <!-- CTA Content -->
          <div
            class="cta-content position-relative text-white text-center text-lg-start"
          >
            <span
              class="d-inline-block section_title"
              v-if="properties.meta_title"
            >
              {{ properties.meta_title }}
            </span>
            <h2 class="text-white section_title">{{ properties.title }}</h2>
            <p class="mb-3 section_title" v-if="properties.featured_title">
              {{ $t(properties.featured_title) }}
            </p>
            <router-link
              v-if="properties.btn_title"
              :to="`/products/${properties.product_details.permalink}`"
              class="text-white btn-underline section_btn"
            >
              {{ properties.btn_title }}
            </router-link>
          </div>
          <!-- End CTA Content -->
        </div>
      </div>
    </div>
  </section>
</template>
<script>
import { defineAsyncComponent } from "vue";
const VideoCard = defineAsyncComponent(() => import("../ui/VideoCard.vue"));
export default {
  name: "ctaSection",
  components: {
    VideoCard,
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
        //Title
        "--title-color": this.properties.title_color,
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

<style lang="scss" scoped>
@import "../../assets/sass/00-abstracts/01-variables";
.section_title {
  color: var(--title-color) !important;
}
.section_btn {
  color: var(--button-color) !important;
  background-color: var(--button-background-color) !important;
  border: var(--button-border) !important;
  border-color: var(--button-border-color) !important;
}
.section_btn:hover {
  color: var(--button-hover-color);
  background-color: var(--button-hover-bg-color);
  border-color: var(--button-hover-border-color);
}
.cta-section {
  background-image: var(--section-background-image);
  background-color: var(--section-background-color);
  padding: var(--section-padding) !important;
  margin: var(--section-margin) !important;
  background-position: var(--section-background-image-position);
  background-size: var(--section-background-image-size);
  background-repeat: var(--section-background-image-repeat);
}
.cta {
  &-section {
    padding: 134px 0;
    background-repeat: no-repeat;
    z-index: 99;
    @media (max-width: 991px) {
      padding: 50px 0;
    }
    @media (min-width: 992px) {
      background-size: cover;
      &::before {
        width: 50%;
        height: 100%;
        clip-path: polygon(0 0, 100% 0%, 100% 100%, 20% 100%);
      }
    }
  }
  &-content {
    span,
    p {
      font-size: 18px;
      line-height: 24px;
      font-weight: 500;
    }
    h2 {
      font-size: 42px;
      $lh: 1.19;
      line-height: $lh;
      margin: 6px 0;
    }
    .slide-price {
      margin-bottom: 6px;
    }
  }
  &-shape {
    opacity: 0.6;
    &.top {
      left: 55%;
      top: 0;
    }
    &.bottom {
      right: 0;
      bottom: 0;
    }
  }
}

.btn-underline {
  font-size: 24px;
  font-weight: bold;
  font-family: $title-font;
  &:hover {
    text-decoration: underline;
    opacity: 0.9;
  }
}
</style>
