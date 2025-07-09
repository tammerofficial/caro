<template>
  <div class="product-image-gallery">
    <FsLightbox :toggler="toggler" :sources="zoomImages" :slide="slide" />
    <div class="carousel-wrapper">
      <swiper
        :style="{
          '--swiper-navigation-color': '#fff',
          '--swiper-pagination-color': '#fff',
        }"
        :spaceBetween="10"
        :navigation="true"
        :thumbs="{ swiper: thumbsSwiper }"
        :modules="modules"
        class="mySwiper2"
      >
        <swiper-slide
          v-for="(image, imageIndex) in galleryImages"
          :key="imageIndex"
          class="gallery-image"
        >
          <!--Image Thumbnail-->
          <div
            v-if="image.type === 'image'"
            @click="
              () => {
                slide = imageIndex + 1;
                toggler = !toggler;
              }
            "
          >
            <v-lazy-image :src="image.regular" />
          </div>
          <!--End Image Thumbnail-->
          <!--Video Thumbnail-->
          <div
            v-if="image.type === 'video'"
            class="video-thumb"
            :style="{
              backgroundImage: `url(${image.thumbnail})`,
              backgroundColor: '#f7f8fa',
            }"
            :key="imageIndex"
            @click="
              () => {
                slide = imageIndex + 1;
                toggler = !toggler;
              }
            "
          >
            <img
              src="/public/themes/tlcommerce/assets/img/play-big.png"
              class="play-icon gallery-preview-panel__video-player"
              alt="video"
            />
          </div>
          <!--End Video thumbnail-->
        </swiper-slide>
      </swiper>
      <swiper
        @swiper="setThumbsSwiper"
        :spaceBetween="10"
        :slidesPerView="5"
        :freeMode="true"
        :watchSlidesProgress="true"
        :modules="modules"
        class="mySwiper mt-10"
      >
        <swiper-slide
          v-for="(image, imageIndex) in galleryImages"
          :key="imageIndex"
          class="gallery-image"
        >
          <img :src="image.regular" v-if="image.type === 'image'" />
          <div class="item-gallery__image-wrapper" v-else>
            <img
              class="item-gallery__video-icon"
              src="/public/themes/tlcommerce/assets/img/play-show.png"
              :alt="`product-gallery-image-${imageIndex}`"
            />
          </div>
        </swiper-slide>
      </swiper>
    </div>
    <!--Coupon collect area-->
    <div
      class="mt-30 d-flex flex-column align-items-center"
      v-if="voucherList.length > 0"
    >
      <div class="coupon-wrap w-100">
        <div
          class="coupon p-2 text-center text-white"
          @click="showVoucherList = !showVoucherList"
        >
          <h5 class="mb-0 text-white">
            {{ $t("Get The coupon Code Now") }}
          </h5>
          <p class="widget-collapse-toggle fz-12">
            <span>
              {{ $t("Available Offers") }}
            </span>
            <span class="material-icons fz-12"> expand_more </span>
          </p>
        </div>
        <ul v-if="showVoucherList" class="voucher-list list-unstyled">
          <li v-for="(voucher, index) in voucherList" :key="index">
            <div class="voucher-left">
              <div class="voucher-amount">
                <sup v-if="voucher.discount_type == config.amount_type.flat"
                  >$</sup
                >{{ voucher.discount_amount
                }}<sup
                  v-if="voucher.discount_type == config.amount_type.percent"
                  >%</sup
                >
              </div>
              <div class="voucher-info">
                <h6 v-if="voucher.minimum_spend_amount">
                  Orders over ${{ voucher.minimum_spend_amount }}
                </h6>
                <p>Expires: {{ voucher.expire_date }}</p>
              </div>
            </div>
            <div>
              <button
                class="btn btn-sm collect-btn"
                @click.prevent="collectCouponCode(voucher)"
              >
                {{ $t("Collect") }}
              </button>
            </div>
          </li>
        </ul>
      </div>
    </div>
    <!--End coupon collect area-->
    <!--Social media share options-->
    <ul class="nav share-list justify-content-center my-3">
      <li
        class="social-link"
        v-for="network in networks"
        :key="network.network"
        :title="network.network"
      >
        <ShareNetwork
          :network="network.network"
          :key="network.network"
          :url="url"
          :title="productName"
          :description="summary"
        >
          <img
            class="rounded"
            :src="`/public/themes/tlcommerce/assets/img/social/${network.icon}`"
            :alt="network.name"
          />
        </ShareNetwork>
      </li>
    </ul>
    <!--End social media share options-->
  </div>
</template>

<script>
import { Swiper, SwiperSlide } from "swiper/vue";
import VLazyImage from "v-lazy-image";
// import required modules
import { FreeMode, Navigation, Thumbs } from "swiper";
import config from "../../config.js";
// Import Swiper styles
import "swiper/css";
import FsLightbox from "fslightbox-vue/v3";
import "swiper/css/free-mode";
import "swiper/css/navigation";
import "swiper/css/thumbs";
export default {
  name: "DetailsGallery",
  components: {
    "v-lazy-image": VLazyImage,
    FsLightbox,
    Swiper,
    SwiperSlide,
  },
  setup() {
    return {
      modules: [FreeMode, Navigation, Thumbs],
    };
  },
  props: {
    galleryImages: {
      type: Array,
      required: true,
    },
    voucherList: {
      type: Array,
      required: false,
    },
    productName: {
      type: String,
      default: "",
    },
    summary: {
      type: String,
      default: "",
    },
    url: {
      type: String,
      default: "",
    },
    networks: {
      type: Array,
      required: false,
    },
  },
  computed: {
    zoomImages() {
      let images = [];
      for (let i = 0; i < this.galleryImages.length; i++) {
        if (this.galleryImages[i].type == "image") {
          images.push(this.galleryImages[i].zoom);
        } else {
          images.push(this.galleryImages[i].video_link);
        }
      }
      return images;
    },
  },
  data() {
    return {
      slide: 1,
      toggler: false,
      config,
      index: null,
      showVoucherList: false,
      thumbsSwiper: null,
    };
  },

  methods: {
    /**
     * Collect coupon code
     */
    async collectCouponCode(item) {
      let text = item.code;
      var input = document.createElement("input");
      input.setAttribute("value", text);
      document.body.appendChild(input);
      input.select();
      var result = document.execCommand("copy");
      document.body.removeChild(input);
      this.$toast.success(this.$t("Coupon collected successfully"));
      return result;
    },
    /**
     * downloads gallery image of a product
     */
    setThumbsSwiper(swiper) {
      this.thumbsSwiper = swiper;
    },
  },
};
</script>

<style lang="scss" scoped>
@import "../../assets/sass/00-abstracts/01-variables";

.navSlider {
  padding: 0 10px;
  .gallery-image {
    padding: 5px;
    img {
      margin: auto;
      width: 60px;
      height: 70px;
      background-image: linear-gradient(gray 100%, transparent 0);
      object-fit: cover;
    }
  }
}
.slider-custom-nav {
  button {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    height: 24px;
    width: 24px;
    opacity: 0.5;
    transition: 0.3s ease-in;
    &:hover {
      opacity: 1;
    }
    + button {
      left: auto;
      right: 0;
    }
  }
}

//Coupon Area
.coupon-wrap {
  background-color: #fff;
  box-shadow: 3px 3px 30px rgb(0 0 0 / 3%);
  position: relative;
}

.coupon {
  cursor: pointer;
  width: 100%;
  height: 60px;
  background-color: $c1;
}
.voucher-list {
  padding: 5px 30px;
  border: 1px solid #f7f8fa;
  position: absolute;
  left: 0;
  background: #fff;
  width: 100%;
  z-index: 9;
  li {
    padding: 8px 0 5px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    &:not(:last-child) {
      border-bottom: 1px solid #e6e6e6;
    }
  }
  .voucher-left {
    display: flex;
    align-items: center;
  }
  .voucher-amount {
    margin-right: 20px;
    font-size: 30px;
    font-weight: 800;
    font-family: $title-font;
    color: #3b3b3b;
    sup {
      font-weight: 300;
    }
  }
  .voucher-info {
    h6 {
      font-weight: 500;
      font-size: 16px;
      margin-bottom: 0px;
    }
    p {
      font-size: 13px;
      color: #666666;
    }
  }
}
.mySwiper2 img {
  width: 100%;
}
.video-thumb {
  position: relative;
  min-height: 380px;
  width: auto;
  background-size: cover;
  background-position: center;
}
.gallery-preview-panel__video-player {
  position: absolute;
  width: 63px !important;
  height: 48px;
  font-size: 42px;
  top: calc(50% - 21px);
  left: calc(50% - 21px);
  color: #fff;
  cursor: pointer;
}
.item-gallery__image-wrapper {
  width: 90px;
  height: 90px;
  display: table-cell;
  vertical-align: middle;
  margin: auto;
  -webkit-box-sizing: border-box;
  box-sizing: border-box;
  border: 1px solid #dadada;
  border-radius: 2px;
  text-align: center;
  @media (max-width: 767px) {
    height: 48px;
    width: 48px;
  }
}
.item-gallery__video-icon {
  display: inline-block !important;
  width: 40px;
  height: 29px;
}

.social-link {
  cursor: pointer;
  border-color: red($color: #000000);
}
.share-list {
  a {
    width: 30px;
    height: 30px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    color: #aaaaaa;
    transition: 0.3s ease-in;
    margin: 2px;
    border: 1px solid #8b8b8b;

    &:hover {
      border-color: $c1;
    }
    img {
      width: 14px;
      height: 14px;
    }
  }
}
</style>
