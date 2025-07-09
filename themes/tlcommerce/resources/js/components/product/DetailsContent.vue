<template>
  <!-- Product Details Content -->
  <div class="product-details-content">
    <!--Flash deal info-->
    <div
      class="d-flex flash-deal flex-wrap justify-content-between mb-20 p-2 text-white"
      v-if="product.has_deal != null"
    >
      <div class="align-items-center d-flex deal-title">
        <h5 class="text-white mb-0">{{ product.has_deal.deal_title }}</h5>
      </div>
      <div class="deal-dead-line">
        <countdown
          class="justify-content-lg-end"
          :deadline="product.has_deal.end_date"
          titleColor="white"
        />
      </div>
    </div>
    <!--End flash deal info-->
    <!-- Title -->
    <h1 class="product-title">{{ product.name }}</h1>
    <!--End Title-->
    <!-- Rating -->
    <div
      class="align-items-center d-flex rating-wrap"
      v-if="config.enable_product_reviews == enums.status.ACTIVE"
    >
      <div
        class="d-flex align-items-center mr-15"
        v-if="config.enable_product_star_rating == enums.status.ACTIVE"
      >
        <div class="product-rating-wrapper">
          <i :data-star="product.rating" :title="product.rating"></i>
        </div>
        <h4 class="ms-3 mb-0 c1 mt3px">{{ product.rating }}</h4>
      </div>
      <div class="rating-text-wrap mt5px flex-wrap d-flex">
        <span class="c1 review-count" @click="gotoSec">
          ({{ product.total_reviews }}) {{ $t("Reviews") }}
        </span>
      </div>
    </div>
    <!-- End Rating -->
    <!-- Summary -->
    <div v-if="product.summary" class="product-summary-section mt-20">
      <div class="product-description" v-html="product.summary"></div>
    </div>
    <!--End Summary-->
    <hr class="divider bg-secondary" />
    <!--Price Range-->
    <div
      class="product-price price-range"
      v-if="
        product.price_range_min &&
        product.price_range_max &&
        product.price_range_min != product.price_range_max
      "
    >
      <h6 class="mb-1">{{ $t("Price Range") }}</h6>
      <div class="align-items-center d-flex flex-wrap price">
        <h3 class="mb-0 mr-20">
          <the-currency :amount="product.price_range_min"></the-currency>
          -
          <the-currency :amount="product.price_range_max"></the-currency>
        </h3>
        <del v-if="product.price_range_min_old && product.price_range_max_old">
          <the-currency
            v-if="product.price_range_min_old > product.price_range_min"
            :amount="product.price_range_min_old"
          ></the-currency>
          <span v-if="product.price_range_max_old > product.price_range_max">
            -
            <the-currency :amount="product.price_range_max_old"></the-currency>
          </span>
        </del>
      </div>
    </div>
    <!-- End  Price Range-->
    <!-- Total Price -->
    <div class="product-price unit-price mt-25">
      <h6 class="mb-1">{{ $t("Price") }}</h6>
      <div class="price d-flex align-items-center">
        <the-currency
          :amount="product.price"
          tag="h3"
          class="mb-0"
        ></the-currency>
        <the-currency
          v-if="product.oldPrice > product.price"
          :amount="product.oldPrice"
          tag="del"
          class="ml-20"
        ></the-currency>
      </div>
    </div>
    <!-- End Total Price -->
    <!-- Option Choice Form -->
    <div class="option-choice-form mt-4" v-if="product.attribute">
      <!--Variant options-->
      <div v-for="(attr, i) in product.attribute" :key="i">
        <div class="mb-3">
          <label class="option-label font-weight-bold text-capitalize">{{
            attr.title
          }}</label>

          <!-- Option List -->
          <div class="checkbox-group d-flex flex-wrap">
            <div v-for="(option, j) in attr.options" :key="j">
              <label
                class="custom-checkbox--two position-relative"
                :for="`${attr.title}-option-${j + 1}`"
              >
                <input
                  :id="`${attr.title}-option-${j + 1}`"
                  type="radio"
                  :name="`product_${attr.title}`"
                  :value="option"
                  :checked="attr.options[j].id == attr.options[0].id"
                  v-on:change="updateSelectedVariant(option)"
                />

                <template v-if="attr.title == 'color'">
                  <span
                    class="checkmark p-0"
                    :style="{
                      backgroundColor: option.value,
                      height: '50px',
                      width: '50px',
                    }"
                  >
                    <img
                      :src="option.image"
                      :alt="`${option.name}`"
                      v-if="option.image"
                    />
                    <p v-else>{{ option.name }}</p>
                  </span>
                </template>

                <template v-else-if="attr.title == 'size'">
                  <span class="checkmark">
                    <strong class="text-uppercase">{{ option.title }}</strong>
                  </span>
                </template>

                <template v-else>
                  <span class="checkmark text-capitalize">
                    <strong>{{ option.title }}</strong>
                  </span>
                </template>
              </label>
            </div>
          </div>
          <!-- End Option List -->
        </div>
      </div>
      <!--End variant options-->
    </div>
    <!-- End Option Choice Form -->
    <!-- Quantity -->
    <div class="mt-20 mb-2 product-details-quantity">
      <h6 class="fz-12">{{ $t("Quantity") }}</h6>
      <div class="d-flex align-items-center">
        <!-- Quantity Input -->
        <div class="quantity-input text-center d-flex">
          <button
            class="d-flex align-items-center justify-content-center p-0 bg-transparent border-0"
            :disabled="quantityValue <= min_qty"
            @click.prevent="quantityValue > 1 ? quantityValue-- : null"
          >
            <base-icon-svg name="minus" :height="12" :width="12" />
          </button>
          <input
            v-model="quantityValue"
            type="number"
            class="border-0 text-center font-weight-bold w-100"
          />
          <button
            class="d-flex align-items-center justify-content-center p-0 bg-transparent border-0"
            :disabled="product.quantity < 1 || quantityValue == max_qty"
            @click.prevent="
              quantityValue > 0 && quantityValue <= product.quantity - 1
                ? quantityValue++
                : null
            "
          >
            <base-icon-svg name="plus" :height="12" :width="12" />
          </button>
        </div>
        <!-- End Quantity Input -->
        <div class="ml-15 fz-12">
          <p v-if="product.quantity > 0" class="c1">
            {{ product.quantity }}
            {{ product.quantity > 1 ? "items" : "item" }}
            {{ $t("are available") }}
          </p>
          <p v-else class="text-danger">{{ $t("Sold out") }}</p>
        </div>
      </div>
    </div>
    <!-- End Quantity -->
    <!--Attachment-->
    <div
      class="mt-25 product-details-attachment-area"
      v-if="product.attatchment_title != null"
    >
      <div class="align-items-center attach-input-wrapper d-flex mb-10">
        <h6 class="mb-0 mr-10 text-capitalize">
          {{ product.attatchment_title }}
        </h6>
        <input
          type="file"
          name="attach"
          ref="attachment"
          @change="addAttachment()"
        />
      </div>
      <template v-if="errors.attachment">
        <p
          class="fz-12 text-danger mt-1"
          v-for="(error, index) in errors.attachment"
          :key="index"
        >
          {{ error }}
        </p>
      </template>
      <p class="fz-12 mt-1" v-else>
        {{ $t("Compatible file extensions to upload: png, jpg, pdf") }}
      </p>
    </div>
    <!--End attachment-->
    <!--Action buttons-->
    <hr class="divider bg-secondary" />
    <div class="product-details-action-area">
      <div class="button-group d-flex align-items-center flex-wrap gap-3">
        <!--Place order button-->
        <button
          type="button"
          class="btn btn_fill"
          :disabled="product.quantity < 1"
          @click.prevent="placeOrder"
        >
          {{ $t("Place Order") }}
        </button>
        <!--End place order button-->
        <!--Add to cart button-->
        <button
          type="button"
          :disabled="product.quantity < 1"
          class="btn btn_borderd"
          @click.prevent="addToCart"
        >
          {{ $t("Add To Cart") }}
        </button>
        <!--End add to cart button-->
        <div
          class="btn-group-right d-flex flex-md-column align-items-center align-items-md-start"
        >
          <!--Desktop compare button-->
          <button
            class="icon_btn d-none d-md-inline-flex btn-compare"
            @click.prevent="addToCompare"
            v-if="config.enable_product_compare == 1"
          >
            <div class="icon-wrapper">
              <span class="material-icons"> compare_arrows </span>
            </div>
            <strong class="ms-1">{{ $t("Add to Compare") }}</strong>
          </button>
          <!--End Desktop compare button-->
          <!--Add to wishlist button-->
          <button
            :class="{ 'w-100': config.enable_product_compare != 1 }"
            class="icon_btn btn-wishlist mt-md-2"
            @click.prevent="addToWishlist"
          >
            <div class="icon-wrapper">
              <span class="material-icons"> favorite_border </span>
            </div>
            <strong class="d-none d-md-inline-block ms-1">{{
              $t("Add to wishlist")
            }}</strong>
          </button>
          <!--End Add to wishlist button-->
          <!--Mobile add to compare button-->
          <button
            class="icon_btn btn-chat d-inline-flex d-md-none"
            @click.prevent="addToCompare"
            v-if="config.enable_product_compare == 1"
          >
            <div class="icon-wrapper">
              <span class="material-icons"> compare_arrows </span>
            </div>
          </button>
          <!--End Mobile compare button-->
        </div>
      </div>
    </div>
    <!--End action buttons-->
  </div>
  <!-- End Product Details Content -->
</template>

<script>
const axios = require("axios").default;
import Countdown from "../ui/Countdown.vue";
import { mapState } from "vuex";
import enums from "../../enums/enums";
export default {
  emits: ["goto-section", "color-variant-images"],
  components: {
    Countdown,
  },
  props: {
    product: {
      type: Object,
      required: true,
    },
  },
  data() {
    return {
      enums: enums,
      errors: [],
      attachment: null,
      quantityValue:
        this.product.min_item_on_purchase != null &&
        this.product.min_item_on_purchase > 0
          ? parseInt(this.product.min_item_on_purchase)
          : 1,
    };
  },
  computed: mapState({
    customerToken: (state) => state.customerToken,
    isCustomerLogin: (state) => state.isCustomerLogin,
    config: (state) => state.siteSettings,
    product_variant() {
      if (this.product.has_variant == 1) {
        const output = [];
        const variant_array = this.product.selectedVariant.split("/");
        for (let i = 0; i < variant_array.length; i++) {
          let single_variant = variant_array[i];
          let single_variant_array = single_variant.split(":");
          let variant_id = single_variant_array[0];
          let variant_value_id = single_variant_array[1];
          let match_variant = this.product.attribute.find(
            (item) => item.id == variant_id
          );

          let variant_name = match_variant.title;

          let match_variant_value = match_variant.options.find(
            (item) => item.id == variant_value_id
          );
          let variant_value_name = "";
          if (variant_name == "Color" || variant_name == "color") {
            variant_value_name = match_variant_value.name;
          } else {
            variant_value_name = match_variant_value.title;
          }

          let variant = variant_name + ":" + variant_value_name;

          output.push(variant);
        }
        let text = output.join("/");
        return text;
      } else {
        return null;
      }
    },
    min_qty() {
      return this.product.min_item_on_purchase != null &&
        parseInt(this.product.min_item_on_purchase) > 0
        ? parseInt(this.product.min_item_on_purchase)
        : 1;
    },
    max_qty() {
      return this.product.max_item_on_purchase != null &&
        parseInt(this.product.max_item_on_purchase) > 0 &&
        parseInt(this.product.max_item_on_purchase) <
          parseInt(this.product.quantity)
        ? parseInt(this.product.max_item_on_purchase)
        : this.product.quantity;
    },
  }),
  watch: {
    quantityValue() {
      //Check minimum qty
      if (this.quantityValue < parseInt(this.min_qty)) {
        this.quantityValue = parseInt(this.min_qty);
      }
      //Check maximum qty
      if (this.quantityValue > parseInt(this.max_qty)) {
        this.quantityValue = parseInt(this.max_qty);
      }
      this.quantityValue = parseInt(this.quantityValue);
    },
  },
  methods: {
    gotoSec() {
      this.$emit("goto-section", "productDetails");
    },
    /**
     * Load Color variant images
     *
     */
    colorVariantImages(color_id) {
      this.$emit("color-variant-images", color_id);
    },
    /**
     * Get product variant price
     *
     */
    updateSelectedVariant(item) {
      if (item.parent == "color") {
        this.colorVariantImages(item.id);
      }
      axios
        .post("/api/v1/ecommerce-core/single-variant-info", {
          id: this.product.id,
          variant: this.product.selectedVariant,
          choice: item.parent,
          option: item.id,
        })
        .then((response) => {
          if (response.data.success) {
            this.product.price = response.data.base_price;
            this.product.selectedVariant = response.data.new_variant;
            this.product.quantity = response.data.quantity;
            this.product.oldPrice = response.data.oldPrice;
          }
        })
        .catch((error) => {});
    },
    /**
     * Add attachment with order
     */
    addAttachment() {
      this.errors = [];
      let formData = new FormData();
      formData.append(
        "attachment_old",
        this.attachment != null ? this.attachment.file_id : null
      );
      formData.append("attachment", this.$refs.attachment.files[0]);
      axios
        .post("/api/v1/ecommerce-core/upload-attachment-in-order", formData, {
          headers: {
            "Content-Type": "multipart/form-data",
          },
        })
        .then((response) => {
          if (response.data.success) {
            this.attachment = response.data.attatchment;
            this.$toast.success(this.$t("Attachment upload successfully"));
          } else {
            this.$toast.error(this.$t("Attachment upload failed"));
          }
        })
        .catch((error) => {
          if (error.response.status == 422) {
            this.errors = error.response.data.errors;
          } else {
            this.$toast.error(this.$t("Attachment upload failed"));
          }
        });
    },
    /**
     * Place order
     */
    placeOrder() {
      let image = "";
      if (this.product.galleryImages[0].type == "image") {
        image = this.product.galleryImages[0].regular;
      } else {
        image = this.product.galleryImages[1].regular;
      }
      let cart_item = {
        uid: Date.now(),
        id: this.product.id,
        name: this.product.name,
        permalink: this.product.permalink,
        image: image,
        variant: this.product_variant,
        variant_code: this.product.selectedVariant,
        unitPrice: this.product.price,
        oldPrice: this.product.oldPrice,
        quantity: this.quantityValue,
        attachment: this.attachment,
        max_item: this.max_qty,
        min_item: this.min_qty,
        seller: this.product.seller,
        shop_name:
          this.product.shopInfo != null ? this.product.shopInfo.name : null,
        shop_slug:
          this.product.shopInfo != null ? this.product.shopInfo.slug : null,
      };

      this.$store.dispatch("addToCart", cart_item);
      this.$router.push("/cart");
    },
    /**
     * Store items to cart
     */
    addToCart() {
      let image = "";
      if (this.product.galleryImages[0].type == "image") {
        image = this.product.galleryImages[0].regular;
      } else {
        image = this.product.galleryImages[1].regular;
      }
      let cart_item = {
        uid: Date.now(),
        id: this.product.id,
        name: this.product.name,
        permalink: this.product.permalink,
        image: image,
        variant: this.product_variant,
        variant_code: this.product.selectedVariant,
        unitPrice: this.product.price,
        oldPrice: this.product.oldPrice,
        quantity: this.quantityValue,
        attachment: this.attachment,
        max_item: this.max_qty,
        min_item: this.min_qty,
        seller: this.product.seller,
        shop_name:
          this.product.shopInfo != null ? this.product.shopInfo.name : null,
        shop_slug:
          this.product.shopInfo != null ? this.product.shopInfo.slug : null,
      };

      this.$store.dispatch("addToCart", cart_item);
    },
    /**
     * Add to wishlist
     */
    addToWishlist() {
      if (this.isCustomerLogin) {
        axios
          .post(
            "/api/v1/ecommerce-core/customer/store-product-to-wishlist",
            {
              product_id: this.product.id,
            },
            {
              headers: {
                Authorization: `Bearer ${this.customerToken}`,
              },
            }
          )
          .then((response) => {
            if (response.data.success) {
              this.$store.dispatch("refreshCustomerDashboardInfo");
              this.$toast.success("Product added to wishlist successfully");
            } else {
              this.$toast.error("Product add to wishlist failed");
            }
          })
          .catch((error) => {
            this.$toast.error("Product add to wishlist failed");
          });
      } else {
        this.$toast.error("Please login");
        this.$router.push("/login");
      }
    },
    /**
     * Add to compare
     */
    addToCompare() {
      this.$store.dispatch("addItemToCompareItems", this.product.id);
    },
  },
};
</script>
<style lang="scss" scoped>
@import "../../assets/sass/00-abstracts/01-variables";
.option-label {
  font-weight: 700;
  line-height: 1;
  margin-bottom: 10px;
  font-family: $title-font;
}
.button-group {
  margin-top: -15px;
  .btn {
    padding: 10px 22px;
    margin-right: 15px;
  }
  .btn-wishlist,
  .btn-compare {
    .material-icons {
      color: $c1;
      font-size: 18px;
    }
  }
  > * {
    margin-top: 15px;
  }
  @media only screen and (max-width: 767px) {
    margin: 0;
    position: fixed;
    bottom: 0;
    width: 100%;
    background: #ddd;
    left: 0;
    justify-content: center;
    z-index: 9;
    height: 60px;
    box-shadow: 0 0 30px rgba(0, 0, 0, 0.1);
    gap: 0 !important;
    .btn {
      padding: 8px 16px;
      margin-right: 0;
      width: 35%;
      border-radius: 0;
      height: 100%;
      line-height: 1.2;
      &:hover {
        background-color: $c1;
      }
      &:nth-child(2) {
        background-color: #f2380f;
        &:hover {
          background-color: #f2380f;
        }
      }
    }
    .btn-wishlist,
    .btn-compare {
      .material-icons {
        color: #fff;
      }
    }
    .btn-group-right {
      width: 30%;
      .icon_btn {
        background-color: #f26110;
        width: 50%;
        height: 60px;
        &.btn-chat {
          background-color: #ff7624;
        }
      }
      .icon-wrapper {
        width: 35px;
        height: 35px;
        min-width: 35px;
        border: 1px solid #fff;
        border-radius: 50%;
        color: #fff;
        font-size: 18px;
        justify-content: center;
      }
    }
    > * {
      margin-top: 0px;
    }
  }
}
.product-title {
  margin-top: -1px;
  margin-bottom: 15px;
  font-size: 24px;
  font-weight: 500;
}
.btn:disabled {
  color: white;
  pointer-events: none;
  background-color: $c1;
  border-color: var(--bs-btn-disabled-border-color);
  opacity: var(--bs-btn-disabled-opacity);
}
.deal-title {
  font-size: 20px;
  font-weight: 600;
  color: #ffffff;
}
.flash-deal {
  background-color: $c1;
}
.mt3px {
  margin-top: 3px;
}
.mt5px {
  margin-top: 5px;
}
.divider {
  margin-top: 25px !important;
  margin-bottom: 25px !important;
}
.mt-25 {
  margin-top: 25px;
}
</style>
