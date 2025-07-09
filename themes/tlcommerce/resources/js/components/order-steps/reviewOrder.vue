<template>
  <div class="shadow-card mb-30">
    <template v-if="!loading">
      <div
        class="d-flex flex-wrap align-items-center justify-content-between mb-3"
      >
        <h3 class="checkout-title">{{ $t("Review Order") }}</h3>
      </div>
      <!--Shipping Options-->
      <div class="row mb-4">
        <div
          class="col-12 mb-2 mt-2 single-package border-bottom"
          v-for="(shipping_package, index2) in shippingPackages"
          :key="index2"
        >
          <div class="row product-content mb-2">
            <div class="image col-4 col-lg-3">
              <router-link
                :to="`/products/${shipping_package.product.permalink}`"
                class="product-img"
              >
                <img
                  :src="shipping_package.product.image"
                  :alt="shipping_package.product.name"
                  class="cart-image-review"
                />
              </router-link>
            </div>
            <div class="description col-8 col-lg-9">
              <router-link
                :to="`/products/${shipping_package.product.permalink}`"
              >
                <h5 class="product_name text-capitalize fz-sm-14">
                  {{ shipping_package.product.name }}
                </h5>
              </router-link>
              <p
                class="product-variant mb-1 fz-sm-12"
                v-if="shipping_package.product.variant"
              >
                <product-variant
                  :variant="shipping_package.product.variant"
                ></product-variant>
              </p>
              <p class="mb-1 fz-sm-12">
                {{ $t("Qty") }}: {{ shipping_package.product.quantity }}
              </p>
              <p class="mb-1 product-price fz-sm-14 c1">
                <the-currency :amount="shipping_package.product.unitPrice">
                </the-currency>
              </p>
              <div
                class="extra-addons-wrap d-flex flex-wrap"
                v-if="
                  shipping_package.product.shop_name != null &&
                  shipping_package.product.shop_slug
                "
              >
                <p class="product-shop fz-12">
                  {{ $t("Sold By") }}
                  <router-link
                    :to="`/shop/${shipping_package.product.shop_slug}`"
                    target="_blank"
                    class="c1"
                  >
                    {{ shipping_package.product.shop_name }}
                  </router-link>
                </p>
              </div>
            </div>
          </div>
          <div
            v-if="
              isActiveHomeDelivery &&
              !isActivePickupPoint &&
              config.shipping_option == 3
            "
            class="row shipping-content"
            @click.prevent="openShippingOptionPopup(shipping_package.id)"
          >
            <div class="pl-shipping large">
              <div class="pl-shipping-left">
                <div class="pl-shipping-left-title">
                  {{ $t("Shipping") }}:
                  <the-currency
                    :amount="shipping_package.default_option.shipping_cost"
                  ></the-currency>
                </div>
                <div class="pl-shipping-left-cost">
                  {{ $t("Estimated Delivery Time") }}:
                  {{ shipping_package.default_option.shipping_time }}
                </div>
                <div class="pl-shipping-left-tags"></div>
              </div>
              <div class="pl-shipping-right">
                <span class="material-icons"> arrow_forward_ios </span>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!--End Shipping Options-->
      <!--Action area-->
      <div class="row">
        <div class="col-12 d-flex flex-wrap justify-content-between">
          <button
            type="button"
            class="btn btn_border mb-10 m-w-100 justify-content-center"
            @click.prevent="goPreviousStep"
          >
            <span class="material-icons me-2"> arrow_back </span>
            {{ $t("Previous") }}
          </button>
          <button
            type="button"
            class="btn btn_fill mb-10 m-w-100 justify-content-center"
            :disabled="deliveryNotAvailable"
            @click.prevent="goNextStep"
          >
            {{ $t("Continue") }}
            <span class="material-icons ms-2"> arrow_forward </span>
          </button>
        </div>
      </div>
      <!--End Action Area-->
    </template>
    <div class="row mb-4" v-if="loading">
      <skeleton
        class="col-12 mb-20 single-package border-bottom"
        height="70px"
      ></skeleton>
      <skeleton
        class="col-12 mb-2 mt-2 single-package border-bottom"
        height="150px"
      ></skeleton>
      <skeleton
        class="col-12 mb-2 mt-2 single-package border-bottom"
        height="150px"
      ></skeleton>
    </div>

    <!--Shipping Address picker -->
    <CModal
      :visible="visibleShippingOptionPicker"
      size="md"
      @close="
        () => {
          visibleShippingOptionPicker = false;
        }
      "
    >
      <CModalHeader>
        <CModalTitle>{{ $t("Shipping Options") }}</CModalTitle>
        <button
          class="btn-circle bg-black size-35"
          @click.prevent="
            () => {
              visibleShippingOptionPicker = false;
            }
          "
        >
          <base-icon-svg name="close" :width="10" :height="10" />
        </button>
      </CModalHeader>
      <CModalBody>
        <div class="row save-adderss">
          <div
            class="col-lg-12 mb-4"
            v-for="(option, index) in shippingOptions.options.data"
            :key="index"
          >
            <span
              class="custom-radio-btn"
              ref="optionRadio"
              :class="{
                active: option.id == shippingOptions.default_option.id,
              }"
            >
              <label class="radio-label">
                <input
                  name="shippingOption"
                  type="radio"
                  :value="option"
                  v-model="shippingOptions.default_option"
                  :checked="option.id == shippingOptions.default_option.id"
                  @change.prevent="changeShippingOption"
                />
                <span class="radio-text">
                  <span class="font-weight-bold"> {{ option.title }} </span>
                  <small class="m-2" v-if="option.by"
                    >{{ $t("via") }} {{ option.by }}</small
                  >
                  <br />
                  <span>
                    {{ $t("Shipping Cost") }}:
                    <the-currency
                      :amount="option.shipping_cost"
                      class="ml-1"
                    ></the-currency
                  ></span>
                  <br />
                  <span>
                    From {{ option.shipping_from }} to
                    {{ customerShippingInfo.city.name }},
                    {{ customerShippingInfo.state.name }},
                    {{ customerShippingInfo.country.name }}.
                  </span>
                  <br />
                  <span v-if="option.shipping_time"
                    >{{ $t("Estimated Delivery:") }}
                    {{ option.shipping_time }}</span
                  >
                </span>
              </label>
            </span>
          </div>
        </div>
      </CModalBody>
    </CModal>
    <!-- End Shipping option picker -->
  </div>
</template>
<script>
import ProductVariant from "../ui/ProductVariant.vue";
import axios from "axios";
import {
  CModal,
  CButton,
  CModalHeader,
  CModalTitle,
  CModalBody,
} from "@coreui/vue";
export default {
  name: "ReviewOrder",
  components: {
    ProductVariant,
    CModal,
    CButton,
    CModalHeader,
    CModalTitle,
    CModalBody,
  },
  emits: ["next-step", "previous-step"],
  props: {
    config: {
      type: Object,
      required: true,
    },
    enums: {
      type: Object,
      required: true,
    },
    isCustomerLogin: {
      type: Boolean,
      required: false,
      default: false,
    },
  },
  data() {
    return {
      loading: true,
      isActiveHomeDelivery: true,
      isActivePickupPoint: false,
      visibleShippingOptionPicker: false,
      shippingPackages: [],
      shippingOptions: [],
      selectedPickupPoint: "",
      customerShippingInfo: {},
      deliveryNotAvailable: false,
      city_id: null,
      post_code: null,
      errors: [],
    };
  },
  mounted() {
    this.getPreviousData();
  },
  methods: {
    /**
     * Will get previously save data
     */
    getPreviousData() {
      let emptyShippingData = {
        name: "",
        email: "",
        phone_code: "",
        phone: "",
        postal_code: "",
        address: "",
        country: this.$t("Select Country"),
      };
      this.customerShippingInfo =
        this.$store.state.shippingDetails != null
          ? this.$store.state.shippingDetails
          : emptyShippingData;

      this.isActivePickupPoint = this.$store.state.isActivePickupPoint;
      this.isActiveHomeDelivery = this.$store.state.isActiveHomeDelivery;
      this.selectedPickupPoint =
        this.$store.state.pickupPoint != null
          ? this.$store.state.pickupPoint
          : {
              id: "",
              name: "",
              location: "",
              phone: "",
              zone_id: null,
              zone_name: "",
            };
      if (this.isActiveHomeDelivery) {
        this.city_id =
          this.customerShippingInfo.city != null
            ? this.customerShippingInfo.city.id
            : null;
        this.post_code = this.customerShippingInfo.postal_code;
      }
      this.getShippingOptions();
    },
    /**
     * Calculate shipping cost
     */
    getShippingOptions() {
      axios
        .post("/api/v1/ecommerce-core/get-shipping-options", {
          location: this.isActiveHomeDelivery ? this.city_id : null,
          shipping_type: this.isActiveHomeDelivery
            ? "home_delivery"
            : "pickup_delivery",
          post_code: this.post_code,
          products: JSON.stringify(this.$store.state.checkoutItems),
          coupons: JSON.stringify(this.$store.state.couponDiscount),
          zone_id:
            this.isActivePickupPoint && this.selectedPickupPoint.zone_id != null
              ? this.selectedPickupPoint.zone_id
              : null,
        })
        .then((response) => {
          if (response.data.success && response.data.shipping_available) {
            this.shippingPackages = response.data.options;
            this.calculateShippingCostAndTax();
            this.deliveryNotAvailable = false;
            this.isActiveDeliveryOptions = true;
          } else {
            this.$store.dispatch("setFinalShippingCost", 0);
            this.goPreviousStep();
          }
          this.loading = false;
        })
        .catch((error) => {
          this.loading = false;
          this.$store.dispatch("setFinalShippingCost", 0);
          this.goPreviousStep();
        });
    },
    /**
     * Open shipping option popup
     * @param {*} id
     */
    openShippingOptionPopup(id) {
      let option = this.shippingPackages.find((item) => item.id === id);
      if (option) {
        this.shippingOptions = option;
        this.visibleShippingOptionPicker = true;
      }
    },
    /**
     * Change Shipping option
     * @param {*} e
     */
    changeShippingOption(e) {
      this.$refs.optionRadio.forEach((element) => {
        element.classList.remove("active");
      });
      e.target.parentElement.parentElement.classList.add("active");
      this.calculateShippingCostAndTax();
    },
    /**
     * Calculate shipping cost
     *
     * Calculate tax
     *
     */
    calculateShippingCostAndTax() {
      //Calculate shipping cost
      let total_shipping_cost = 0;
      total_shipping_cost = this.shippingPackages.reduce((accum, item) => {
        return (
          parseFloat(accum) + parseFloat(item.default_option.shipping_cost)
        );
      }, 0.0);
      this.$store.dispatch(
        "setFinalShippingCost",
        this.isActiveHomeDelivery ? total_shipping_cost : 0
      );
      //calculate tax
      let total_tax = 0;
      total_tax = this.shippingPackages.reduce((accum, item) => {
        return parseFloat(accum) + parseFloat(item.tax);
      }, 0.0);
      this.$store.dispatch(
        "setFinalTax",
        this.config.enable_tax_in_checkout == this.enums.status.ACTIVE
          ? total_tax
          : 0
      );
      this.visibleShippingOptionPicker = false;
      this.loading = false;
    },
    /**
     * Confirm delivery and shipping info
     */
    goPreviousStep() {
      this.$emit("previous-step");
    },
    /**
     * Will submit shipping info
     */
    goNextStep() {
      let final_product_packages = [];
      for (let i = 0; i < this.shippingPackages.length; i++) {
        let temp = {
          uid: this.shippingPackages[i].id,
          tax:
            this.config.enable_tax_in_checkout == this.enums.status.ACTIVE
              ? this.shippingPackages[i].tax
              : 0,
          product_id: this.shippingPackages[i].product.id,
          quantity: this.shippingPackages[i].product.quantity,
          unitPrice: this.shippingPackages[i].product.unitPrice,
          oldPrice: this.shippingPackages[i].product.oldPrice,
          variant_code: this.shippingPackages[i].product.variant_code,
          variant: this.shippingPackages[i].product.variant,
          image: this.shippingPackages[i].product.image,
          shipping_cost: this.isActiveHomeDelivery
            ? this.shippingPackages[i].default_option.shipping_cost
            : 0,
          shipping_rate_id: this.isActiveHomeDelivery
            ? this.shippingPackages[i].default_option.id
            : "",
          attatchment:
            this.shippingPackages[i].product.attachment != null
              ? this.shippingPackages[i].product.attachment.file_id
              : null,
        };
        final_product_packages.push(temp);
      }
      this.$emit("next-step", final_product_packages);
    },
  },
};
</script>
<style lang="scss" scoped>
@import "../../assets/sass/00-abstracts/01-variables";
.cart-image {
  width: 90px;
  height: 90px;
}
.pl-store-container .pl-shipping:last-child {
  padding-bottom: 0;
}
.pl-shipping.large {
  margin-top: 0;
  cursor: pointer;
}
.pl-shipping {
  display: -webkit-box;
  display: -webkit-flex;
  display: -ms-flexbox;
  display: flex;
  -webkit-box-pack: justify;
  -webkit-justify-content: space-between;
  -ms-flex-pack: justify;
  justify-content: space-between;
  color: #999;
  text-align: center;
  -webkit-box-align: center;
  -webkit-align-items: center;
  -ms-flex-align: center;
  align-items: center;
  font-size: 12px;
  margin-top: 12px;
  position: relative;
  padding-bottom: 12px;
}
.pl-shipping.large .pl-shipping-left {
  display: -webkit-box;
  display: -webkit-flex;
  display: -ms-flexbox;
  display: flex;
  -webkit-box-orient: vertical;
  -webkit-box-direction: normal;
  -webkit-flex-direction: column;
  -ms-flex-direction: column;
  flex-direction: column;
}
.pl-shipping.large .pl-shipping-left .pl-shipping-left-title {
  margin-right: 6px;
}
.pl-shipping-left-title {
  font-family: $title-font;
  font-weight: 700;
  color: #222;
  letter-spacing: 0;
}
.pl-shipping.large .pl-shipping-left .pl-shipping-left-cost {
  font-weight: 700;
}
.pl-shipping-left-cost {
  font-family: $title-font;
  font-size: 10px;
  color: #999;
  letter-spacing: 0;
}
.pl-shipping-left-tags,
.pl-shipping-left-tags-item {
  display: -webkit-box;
  display: -webkit-flex;
  display: -ms-flexbox;
  display: flex;
}
.pl-shipping-left-tags {
  -webkit-flex-wrap: nowrap;
  -ms-flex-wrap: nowrap;
  flex-wrap: nowrap;
}
.pl-shipping-left {
  text-align: start;
}
.pl-shipping-right {
  height: -webkit-fit-content;
  height: -moz-fit-content;
  height: fit-content;
  position: relative;
  padding-right: 14px;
}

.product_name {
  display: block;
  display: -webkit-box;
  -webkit-line-clamp: 1;
  -webkit-box-orient: vertical;
  overflow: hidden;
  text-overflow: ellipsis;
}
.product-price {
  color: #3b3b3b;
  font-size: 16px;
  font-weight: 700;
}
@media (max-width: 575px) {
  .fz-sm-12 {
    font-size: 12px !important;
    line-height: 14px !important;
  }
  .fz-sm-14 {
    font-size: 14px !important;
    line-height: 14px !important;
  }
}
</style>
