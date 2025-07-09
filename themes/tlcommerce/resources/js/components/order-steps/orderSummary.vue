<template>
  <div class="order-details shadow-card">
    <h3 class="checkout-title">{{ $t("Summary") }}</h3>
    <div class="table-responsive">
      <table class="shop_table w-100">
        <tbody>
          <tr class="font-weight-bold">
            <td>{{ $t("Product") }}</td>
            <td>{{ $t("Total") }}</td>
          </tr>
          <tr
            class="products font-weight-regular"
            v-for="tdata in tableData"
            :key="tdata.id"
          >
            <td>
              <span class="product-name">{{ tdata.name }}</span>
              <span> x{{ tdata.quantity }}</span>
            </td>
            <td>
              <the-currency
                :amount="tdata.unitPrice * tdata.quantity"
              ></the-currency>
            </td>
          </tr>

          <tr class="font-weight-bold">
            <td>{{ $t("Subtotal") }}</td>
            <td>
              <span class="woocommerce-Price-amount amount">
                <bdi>
                  <span class="woocommerce-Price-currencySymbol"></span>
                  <the-currency :amount="totalUnitPrice"></the-currency>
                </bdi>
              </span>
            </td>
          </tr>
          <!--Tax-->
          <tr
            class="shipping-cost font-weight-regular"
            v-if="config.enable_tax_in_checkout == enums.status.ACTIVE"
          >
            <td>{{ $t("Tax") }}</td>
            <td>
              <span class="woocommerce-Price-amount amount">
                <bdi>
                  <span class="woocommerce-Price-currencySymbol">+</span>
                  <the-currency :amount="totalTax"></the-currency>
                </bdi>
              </span>
            </td>
          </tr>
          <!--End Tax-->
          <!--Shipping Cost-->
          <tr class="shipping-cost font-weight-regular">
            <td>{{ $t("Shipping Cost") }}</td>
            <td>
              <span class="woocommerce-Price-amount amount">
                <bdi>
                  <span class="woocommerce-Price-currencySymbol">+</span>
                  <the-currency :amount="shippingCost"></the-currency>
                </bdi>
              </span>
            </td>
          </tr>
          <!--End Shipping Cost-->
          <!--Discount-->
          <template
            v-if="
              couponDiscounts.length > 0 &&
              config.enable_coupon_in_checkout == this.enums.status.ACTIVE
            "
          >
            <tr
              class="order-savings font-weight-regular"
              v-for="(discount, index) in couponDiscounts"
              :key="index"
            >
              <td class="d-flex">
                <span class="c1">{{ discount.coupon_code }}</span>
              </td>
              <td>
                <span class="woocommerce-Price-amount amount c1">
                  <bdi>
                    <span class="woocommerce-Price-currencySymbol">-</span>
                    <the-currency :amount="discount.discount"></the-currency>
                  </bdi>
                </span>
              </td>
            </tr>
          </template>
          <!--End Discount-->
          <!--Total Payable Amount-->
          <tr class="order-total">
            <td class="c1">{{ $t("Payable Total") }}</td>
            <td>
              <span class="woocommerce-Price-amount amount c1">
                <bdi>
                  <span class="woocommerce-Price-currencySymbol"></span>
                  <the-currency :amount="totalPayable"></the-currency>
                </bdi>
              </span>
            </td>
          </tr>

          <!--End Total Payable Amount-->
        </tbody>
      </table>
    </div>
  </div>
</template>
<script>
import { mapState } from "vuex";
import { CSpinner } from "@coreui/vue";
export default {
  name: "OrderSummary",
  components: {
    CSpinner,
  },
  props: {
    config: {
      type: Object,
      required: true,
    },
    enums: {
      type: Object,
      required: true,
    },
  },
  data() {
    return {
      tableData: this.$store.state.checkoutItems,
      totalPrice: 0,
    };
  },
  emits: ["get-total-payable"],
  computed: mapState({
    shippingCost: (state) => (state.shippingCost ? state.shippingCost : 0),
    totalTax: (state) => (state.tax ? state.tax : 0),
    couponDiscounts: (state) =>
      state.couponDiscount ? state.couponDiscount : [],
    totalUnitPrice() {
      return this.tableData.reduce((accum, item) => {
        return parseFloat(accum) + parseFloat(item.unitPrice * item.quantity);
      }, 0.0);
    },
    totalPayable() {
      let sum = this.totalUnitPrice + this.shippingCost + this.totalTax;
      let sub = this.totalSaving;
      let payable = sum - sub;
      return payable;
    },
    totalSaving() {
      if (this.config.enable_coupon_in_checkout == this.enums.status.ACTIVE) {
        return this.couponDiscounts.reduce((accum, item) => {
          return parseFloat(accum) + parseFloat(item.discount);
        }, 0.0);
      } else {
        return 0;
      }
    },
  }),
  watch: {
    totalPayable() {
      this.changeOrderTotal();
    },
  },
  mounted() {
    this.changeOrderTotal();
  },
  methods: {
    /**
     * Will change order total
     */
    changeOrderTotal() {
      this.$emit("get-total-payable", this.totalPayable);
    },
  },
};
</script>
<style lang="scss" scoped>
@import "../../assets/sass/00-abstracts/01-variables";
.coupon-btn {
  display: inline-flex;
  align-items: center;
  text-transform: capitalize;
  padding: 9px 20px 10px;
  font-size: 16px;
  font-weight: 700;
  background-color: $c1;
  color: #ffffff;
  border: none;
  cursor: pointer;
  border-radius: 0;
}
.product-name {
  display: block;
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
  text-overflow: ellipsis;
}
</style>
