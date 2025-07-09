<template>
  <div class="widget widget-style-1 widget_best_seller mb-4">
    <h5 v-if="widgetTitle">
      <span>{{ $t("Shop") }}</span>
      <span
        @click="shoSellerWidgetTitle = !shoSellerWidgetTitle"
        class="widget-collapse-toggle"
        ><span class="material-icons"> expand_more </span>
      </span>
    </h5>
    <div class="seller-info" v-if="shoSellerWidgetTitle">
      <div class="seller-banner" v-if="hasBanner">
        <router-link :to="`/shop/${shop.slug}`">
          <img :src="shop.shop_banner" :alt="shop.name" class="img-h-70" />
        </router-link>
      </div>
      <div class="best_seller">
        <div class="seller-feedback d-flex align-items-center">
          <div class="seller-badge">
            <router-link :to="`/shop/${shop.slug}`">
              <img :src="shop.logo" :alt="shop.name" class="img-70" />
            </router-link>
          </div>
          <div class="seller-feedback-content">
            <h6 class="seller-name mb-0">
              <router-link :to="`/shop/${shop.slug}`">{{
                shop.name
              }}</router-link>
            </h6>
            <div class="star-rating">
              <div class="product-rating-wrapper">
                <i :data-star="shop.avg_rating" :title="shop.avg_rating"></i>
              </div>
            </div>
          </div>
        </div>
        <div class="seller-info">
          <p class="positive-feedback" v-if="shop.positive_rating > 0">
            {{ shop.positive_rating }}% {{ $t("Positive feedback") }}
          </p>
          <p class="positive-feedback" v-else>
            {{ $t("No feedback") }}
          </p>
          <h6 class="seller-product">
            {{ shop.total_product }}
            {{ shop.total_product > 1 ? $t("Products") : $t("Product") }}
          </h6>
        </div>
        <div class="seller-links justify-content-between">
          <button class="btn" @click.prevent="storeFollower()">
            {{ $t("Follow") }}
          </button>
          <router-link :to="`/shop/${shop.slug}`" class="btn_underline">{{
            $t("Visit Store")
          }}</router-link>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import { mapState } from "vuex";
export default {
  name: "SingleShop",
  props: {
    shop: {
      type: Number,
      required: true,
    },
    hasBanner: {
      type: Boolean,
      required: false,
    },
    widgetTitle: {
      type: Boolean,
      required: false,
    },
  },
  computed: mapState({
    customerToken: (state) => state.customerToken,
    isCustomerLogin: (state) => state.isCustomerLogin,
  }),
  data() {
    return {
      shoSellerWidgetTitle: true,
    };
  },

  methods: {
    /**
     * Will store new follower
     */
    storeFollower() {
      if (this.isCustomerLogin) {
        axios
          .post(
            "/api/v1/multivendor/store-shop-follower",
            {
              slug: this.shop.slug,
            },
            {
              headers: {
                Authorization: `Bearer ${this.customerToken}`,
              },
            }
          )
          .then((response) => {
            if (response.data.success) {
              if (response.data.duplicate) {
                this.$toast.info(this.$t("Already follow the seller"));
              } else {
                this.$toast.success(this.$t("Shop followed successfully"));
              }
            } else {
              this.$toast.error(
                this.$t("Something went wrong. Please try again")
              );
            }
          })
          .catch((error) => {
            this.$toast.error(this.$t("Something went wrong"));
          });
      } else {
        this.$toast.error("Please login");
        this.$router.push("/login");
      }
    },
  },
};
</script>
<style lang="scss" scoped>
.seller-links {
  display: flex;
  align-items: center;
  flex-wrap: wrap;
}
.img-h-70 {
  height: 150px;
  object-fit: cover;
}
.btn-circle {
  .material-icons {
    font-size: 22px;
  }
}
</style>
