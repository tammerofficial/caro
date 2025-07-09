<template>
  <div class="order-details">
    <div v-if="coupon" class="coupon">
      <div class="form-group">
        <input
          class="form-control me-1"
          type="text"
          v-bind:placeholder="$t('Your Coupon')"
        />
        <button type="submit" class="btn btn_border">
          <span>{{ $t("Apply Coupon") }}</span>
        </button>
      </div>
    </div>
    <div class="table-responsive">
      <table class="shop_table w-100">
        <tbody>
          <tr class="cart-subtotal">
            <td>{{ $t("Subtotal") }}</td>
            <td>
              <span class="woocommerce-Price-amount amount"
                ><bdi
                  ><span class="woocommerce-Price-currencySymbol"></span
                  >{{ subtotal }}</bdi
                ></span
              >
            </td>
          </tr>
          <tr class="shipping-cost">
            <td>{{ $t("Shipping Cost") }}</td>
            <td>
              <span class="woocommerce-Price-amount amount"
                ><bdi
                  ><span class="woocommerce-Price-currencySymbol">+</span
                  >{{ deliveryCost }}</bdi
                ></span
              >
            </td>
          </tr>
          <tr class="order-savings" v-if="couponDiscount">
            <td>{{ $t("Savings") }} (<span class="c1">bijoy50</span>)</td>
            <td>
              <span class="woocommerce-Price-amount amount c1">
                <bdi
                  ><span class="woocommerce-Price-currencySymbol">-</span
                  >{{ couponDiscount }}</bdi
                >
              </span>
            </td>
          </tr>

          <tr class="order-total">
            <td class="c1">{{ $t("Payable Total") }}</td>
            <td>
              <span class="woocommerce-Price-amount amount c1"
                ><bdi
                  ><span class="woocommerce-Price-currencySymbol"></span
                  >{{ totalPrice }}</bdi
                ></span
              >
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script>
export default {
  name: "OrderTotal",
  props: {
    subtotal: {
      type: Number,
      required: true,
    },
    deliveryCost: {
      type: Number,
      default: 0,
    },
    couponDiscount: {
      type: Number,
      default: 0,
    },
    coupon: {
      type: Boolean,
      default: false,
    },
  },
  data() {
    return {};
  },
  computed: {
    totalPrice() {
      return (
        parseInt(this.subtotal) +
        parseInt(this.deliveryCost === "" ? 0 : this.deliveryCost) -
        parseInt(this.couponDiscount === "" ? 0 : this.couponDiscount)
      );
    },
  },
  watch: {
    deliveryCost(newValue, oldValue) {
      if (this.deliveryCost < 0) {
        return (this.deliveryCost = 45);
      }
    },
  },
};
</script>
