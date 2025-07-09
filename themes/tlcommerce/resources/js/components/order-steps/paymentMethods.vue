<template>
  <div class="shadow-card mb-30">
    <div class="row" v-if="!loading">
      <div class="col-12">
        <h3 class="checkout-title">{{ $t("Payment method") }}:</h3>
      </div>
      <!--Order Note-->
      <div
        class="col-lg-12"
        v-if="config.enable_order_note_in_checkout == enums.status.ACTIVE"
      >
        <div class="form-group mb-20">
          <label class="font-weight-bold fz-12 mb-2">
            {{ $t("Order Note") }}</label
          >
          <textarea class="theme-input-style" v-model="additional_order_note">
          </textarea>
        </div>
      </div>
      <!--End Order Note-->
      <!--Payment methods-->
      <div class="col-12">
        <label class="font-weight-bold fz-12 mb-2">{{
          $t("Payment method")
        }}</label>
        <ul class="list-unstyled form-selector-list mb-3">
          <li
            class="single-form-selector"
            v-for="(payment, index) in paymentMethods"
            :key="index"
          >
            <span class="custom-radio-btn">
              <label>
                <input
                  type="radio"
                  :value="payment"
                  class="shipping-method"
                  name="payment-method"
                  v-model="selected_payment_method"
                  @click="takeBankDetails"
                  @input="!pay_wallet"
                />
                <span class="label-title" v-if="payment.logo">
                  <img :src="payment.logo" :alt="payment.name" />
                </span>
                <span class="label-title" v-else>
                  {{ payment.name }}
                </span>
              </label>
            </span>
          </li>
        </ul>
      </div>
      <!--End Payment methods-->
      <!--Selected payment instruction-->
      <div class="col-12 mb-3" v-if="selected_payment_method != null">
        <p v-html="selected_payment_method.instruction"></p>
      </div>
      <!--End Selected payment instruction-->

      <!--Bank Transaction Info-->
      <div
        class="col-12 mb-3"
        v-if="
          selected_payment_method != null &&
          selected_payment_method.id + '' == '9'
        "
      >
        <div
          class="bank-t-info"
          v-if="
            selected_payment_method != null &&
            selected_payment_method.id + '' == '9' &&
            selected_payment_method.additional == 1
          "
        >
          <h5>{{ $t("Transaction Information") }}</h5>
          <div class="form-group mb-20">
            <label class="fz-14">
              {{ $t("Account Name") }}
            </label>
            <input
              class="theme-input-style"
              type="text"
              v-model="bankDetails.accountName"
              v-bind:placeholder="$t('Account Name')"
            />
            <template v-if="errors.account_name">
              <p
                class="fz-12 text-danger mt-1"
                v-for="(error, index) in errors.account_name"
                :key="index"
              >
                {{ error }}
              </p>
            </template>
          </div>
          <div class="form-group mb-20">
            <label class="fz-14">
              {{ $t("Account Number") }}
            </label>
            <input
              class="theme-input-style"
              type="text"
              v-model="bankDetails.accountNumber"
              v-bind:placeholder="$t('Account Number')"
            />
            <template v-if="errors.account_number">
              <p
                class="fz-12 text-danger mt-1"
                v-for="(error, index) in errors.account_number"
                :key="index"
              >
                {{ error }}
              </p>
            </template>
          </div>
          <div class="form-group mb-20">
            <label class="fz-14">
              {{ $t("Bank Name") }}
            </label>
            <input
              class="theme-input-style"
              type="text"
              v-model="bankDetails.bankName"
              v-bind:placeholder="$t('Bank Name')"
            />
            <template v-if="errors.bank_name">
              <p
                class="fz-12 text-danger mt-1"
                v-for="(error, index) in errors.bank_name"
                :key="index"
              >
                {{ error }}
              </p>
            </template>
          </div>
          <div class="form-group mb-20">
            <label class="fz-14">
              {{ $t("Branch Name") }}
            </label>
            <input
              class="theme-input-style"
              type="text"
              v-model="bankDetails.branchName"
              v-bind:placeholder="$t('Branch Name')"
            />
            <template v-if="errors.branch_name">
              <p
                class="fz-12 text-danger mt-1"
                v-for="(error, index) in errors.branch_name"
                :key="index"
              >
                {{ error }}
              </p>
            </template>
          </div>
          <div class="form-group mb-20">
            <label class="fz-14">
              {{ $t("Transaction Number") }}
            </label>
            <input
              class="theme-input-style"
              type="text"
              v-model="bankDetails.transactionNumber"
              v-bind:placeholder="$t('Transaction Number')"
            />
            <template v-if="errors.transaction_number">
              <p
                class="fz-12 text-danger mt-1"
                v-for="(error, index) in errors.transaction_number"
                :key="index"
              >
                {{ error }}
              </p>
            </template>
          </div>
        </div>

        <div class="form-group mb-20">
          <label class="fz-14">
            {{ $t("Attach Receipt") }}
          </label>
          <base-file-input
            id="reviewImages"
            name="reviewImages"
            single
            v-on:getFileInput="returnImages($event)"
          />
          <template v-if="errors.receipt">
            <p
              class="fz-12 text-danger mt-1"
              v-for="(error, index) in errors.receipt"
              :key="index"
            >
              {{ error }}
            </p>
          </template>
        </div>
      </div>
      <!--End Bank Transaction Info-->

      <!--Wallet area-->
      <div
        class="col-12 mb-5 text-center"
        v-if="
          config.enable_wallet_in_checkout == enums.status.ACTIVE &&
          isCustomerLogin &&
          config.is_active_wallet == enums.status.ACTIVE &&
          wallet_available_balance >= totalPayableAmount
        "
      >
        <p>{{ $t("OR") }}</p>
        <p>
          {{ $t("Wallet Balance") }}
          <the-currency :amount="wallet_available_balance"></the-currency>
        </p>
        <button
          type="submit"
          class="btn btn_fill m-w-100 justify-content-center"
          @click.prevent="payWithWallet"
        >
          {{ $t("Pay with wallet") }}
        </button>
      </div>
      <!--End Wallet Area-->

      <!--Action Area-->
      <div class="col-12">
        <div class="d-flex flex-wrap justify-content-between">
          <button
            type="button"
            class="btn btn_border mb-20 m-w-100 justify-content-center"
            @click.prevent="goPreviousStep"
          >
            <span class="material-icons me-2"> arrow_back </span>
            {{ $t("Previous") }}
          </button>
          <button
            type="submit"
            class="btn btn_fill mb-20 m-w-100 justify-content-center"
            :disabled="orderCreating"
            @click.prevent="
              () => {
                pay_wallet = false;
                createOrder();
              }
            "
          >
            <span v-if="orderCreating">
              <CSpinner component="span" size="sm" aria-hidden="true" />
              {{ $t("Please wait") }}
            </span>
            <span v-else>
              {{ $t("Place Order") }}
            </span>
          </button>
        </div>
      </div>
      <!--End action area-->
    </div>
    <div v-if="loading">
      <skeleton
        class="col-12 mb-20 single-package border-bottom"
        height="70px"
      ></skeleton>
      <skeleton
        class="col-12 mb-20 mt-2 single-package border-bottom"
        height="150px"
      ></skeleton>
      <skeleton
        class="col-12 mb-2 mt-2 single-package border-bottom"
        height="80px"
      ></skeleton>
    </div>
  </div>
</template>
<script>
import axios from "axios";
import { mapState } from "vuex";
import { CSpinner } from "@coreui/vue";
export default {
  name: "PaymentMethods",
  emits: ["previous-step"],
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
    productPackages: {
      type: Array,
      required: true,
    },
    isCustomerLogin: {
      type: Boolean,
      required: false,
      default: false,
    },
    totalPayableAmount: {
      type: Number,
      required: false,
      default: 0,
    },
  },
  data() {
    return {
      loading: true,
      paymentMethods: [],
      additional_order_note: "",
      selected_payment_method: null,
      wallet_available_balance: 0,
      pay_wallet: false,
      orderCreating: false,
      return_images: [],
      errors: {},
      bankDetails: {
        bankName: "",
        branchName: "",
        accountNumber: "",
        accountName: "",
        transactionNumber: "",
      },
    };
  },
  computed: mapState({
    customerToken: (state) => state.customerToken,
    isActivePickupPoint: (state) => state.isActivePickupPoint,
    isActiveHomeDelivery: (state) => state.isActiveHomeDelivery,
    pickupPoint: (state) => state.pickupPoint,
    pickupPointId: (state) =>
      state.pickupPoint != null ? state.pickupPoint.id : null,
    city: (state) =>
      state.shippingDetails != null && state.shippingDetails.city != null
        ? state.shippingDetails.city.id
        : null,
  }),
  mounted() {
    this.getPaymentMethods();
    if (this.isCustomerLogin) {
      this.getCustomerWalletSummary();
    }
  },
  methods: {
    /**
     * Get active Payment methods
     *
     */
    getPaymentMethods() {
      axios
        .post("/api/v1/ecommerce-core/active-payment-methods", {
          products: JSON.stringify(this.$store.state.checkoutItems),
          city: this.isActiveHomeDelivery ? this.city : "",
          pickup_point: this.isActivePickupPoint ? this.pickupPointId : "",
        })
        .then((response) => {
          if (response.data.success) {
            this.paymentMethods = response.data.data;
            this.loading = false;
          } else {
            this.paymentMethods = [];
            this.loading = false;
          }
        })
        .catch((error) => {
          this.this.paymentMethods = [];
          this.loading = false;
        });
    },
    /**
     * Get customer wallet transactions
     */
    getCustomerWalletSummary() {
      axios
        .post(
          "/api/wallet/v1/customer-wallet-summary",
          {
            perPage: null,
          },
          {
            headers: {
              Authorization: `Bearer ${this.customerToken}`,
            },
          }
        )
        .then((response) => {
          if (response.data.success) {
            this.wallet_available_balance =
              response.data.summary.total_available;
          } else {
            this.wallet_available_balance = 0;
          }
        })
        .catch((error) => {
          this.wallet_available_balance = 0;
        });
    },
    /**
     * Check out with wallet
     */
    payWithWallet() {
      this.pay_wallet = true;
      this.createOrder();
    },
    /**
     * return product image input value
     */
    returnImages(e) {
      this.return_images = e[0];
    },
    /**
     * Create new order
     */
    createOrder() {
      this.orderCreating = true;
      if (this.selected_payment_method == null && !this.pay_wallet) {
        this.$toast.error(this.$t("Please select a payment option"));
        this.orderCreating = false;
        return null;
      }
      if (this.isCustomerLogin) {
        this.customerCheckout();
      } else if (
        this.config.enable_guest_checkout == this.enums.status.ACTIVE
      ) {
        this.guestCheckout();
      } else {
        this.$router.push("/login");
      }
    },

    /**
     * Customer checkout
     */
    customerCheckout() {
      let formData = new FormData();
      formData.append(
        "coupon_discounts",
        JSON.stringify(this.$store.state.couponDiscount)
      );
      formData.append(
        "payment_id",
        this.selected_payment_method ? this.selected_payment_method.id : null
      );
      formData.append(
        "wallet_payment",
        this.pay_wallet ? this.enums.status.ACTIVE : this.enums.status.IN_ACTIVE
      );
      formData.append("note", this.additional_order_note);
      //pickup point delivery
      if (this.isActivePickupPoint && !this.isActiveHomeDelivery) {
        formData.append(
          "pickup_point",
          this.pickupPoint != null ? this.pickupPoint.id : null
        );
      }

      //Home Delivery
      if (!this.isActivePickupPoint && this.isActiveHomeDelivery) {
        //Shipping address
        formData.append(
          "shipping_address",
          this.$store.state.shippingDetails.id
        );
        //Billing address
        if (
          this.config.enable_billing_address == this.enums.status.ACTIVE &&
          this.config.use_shipping_address_as_billing_address ==
            this.enums.status.ACTIVE
        ) {
          formData.append(
            "billing_address",
            this.$store.state.shippingDetails.id
          );
        }

        if (
          this.config.enable_billing_address == this.enums.status.ACTIVE &&
          this.config.use_shipping_address_as_billing_address !=
            this.enums.status.ACTIVE
        ) {
          formData.append(
            "billing_address",
            this.$store.state.billingDetails != null
              ? this.$store.state.billingDetails.id
              : ""
          );
        }
      }

      if (
        this.selected_payment_method != null &&
        this.selected_payment_method.id + "" == "9"
      ) {
        formData.append("bank_name", this.bankDetails.bankName);
        formData.append("branch_name", this.bankDetails.branchName);
        formData.append("account_number", this.bankDetails.accountNumber);
        formData.append("account_name", this.bankDetails.accountName);
        formData.append("account_name", this.bankDetails.accountName);
        formData.append(
          "transaction_number",
          this.bankDetails.transactionNumber
        );

        formData.append("receipt", this.return_images);
      }

      formData.append("products", JSON.stringify(this.productPackages));
      axios
        .post("/api/v1/ecommerce-core/customer/order/create", formData, {
          headers: {
            Authorization: `Bearer ${this.customerToken}`,
          },
        })
        .then((response) => {
          if (response.data.success) {
            if (response.data.response_url) {
              this.$store.dispatch("flushCartData").then(() => {
                window.location.href = response.data.response_url;
              });
            } else {
              this.orderCreating = false;
            }
          } else {
            this.orderCreating = false;
            this.$toast.error("Order create failed");
          }
        })
        .catch((error) => {
          this.orderCreating = false;
          if (error.response.status == 422) {
            var errors = error.response.data.errors;
            if (this.selected_payment_method.id + "" == "9") {
              this.errors = errors;
              this.$toast.error("Order create failed");
            } else {
              var errormessage = "";
              Object.keys(errors).forEach(function (key) {
                errormessage += "\n" + errors[key];
              });
              this.$toast.error(errormessage);
            }
          } else {
            this.$toast.error("Order create failed");
          }
        });
    },
    /**
     * Guest checkout
     */
    guestCheckout() {
      let formData = new FormData();
      formData.append(
        "coupon_discounts",
        JSON.stringify(this.$store.state.couponDiscount)
      );
      formData.append("name", this.$store.state.guestCustomerInfo.name);
      formData.append("email", this.$store.state.guestCustomerInfo.email);
      if (this.$store.state.isActiveCreateNewAccount) {
        formData.append(
          "password",
          this.$store.state.guestCustomerInfo.password
        );
        formData.append(
          "password_confirmation",
          this.$store.state.guestCustomerInfo.confirm_password
        );
        formData.append(
          "create_new_account",
          this.$store.state.isActiveCreateNewAccount
        );
      }
      formData.append("payment_id", this.selected_payment_method.id);
      formData.append("note", this.additional_order_note);
      //pickup point delivery
      if (this.isActivePickupPoint && !this.isActiveHomeDelivery) {
        formData.append(
          "pickup_point",
          this.pickupPoint != null ? this.pickupPoint.id : null
        );
      }
      //Home Delivery
      if (!this.isActivePickupPoint && this.isActiveHomeDelivery) {
        let shippingAddress = this.getAddressData(
          this.$store.state.shippingDetails
        );
        formData.append("shipping_address", JSON.stringify(shippingAddress));
        //Billing address
        if (this.config.enable_billing_address == this.enums.status.ACTIVE) {
          //Shipping address as billing address
          if (
            this.config.use_shipping_address_as_billing_address ==
            this.enums.status.ACTIVE
          ) {
            formData.append("billing_address", JSON.stringify(shippingAddress));
          }
          //Billing address as billing address
          if (
            this.config.use_shipping_address_as_billing_address !=
            this.enums.status.ACTIVE
          ) {
            let billingAddress = this.getAddressData(
              this.$store.state.billingDetails
            );
            formData.append("billing_address", JSON.stringify(billingAddress));
          }
        }
      }

      if (
        this.selected_payment_method != null &&
        this.selected_payment_method.id + "" == "9"
      ) {
        formData.append("bank_name", this.bankDetails.bankName);
        formData.append("branch_name", this.bankDetails.branchName);
        formData.append("account_number", this.bankDetails.accountNumber);
        formData.append("account_name", this.bankDetails.accountName);
        formData.append("account_name", this.bankDetails.accountName);
        formData.append(
          "transaction_number",
          this.bankDetails.transactionNumber
        );

        formData.append("receipt", this.return_images);
      }
      formData.append("products", JSON.stringify(this.productPackages));
      console.log(formData);
      axios
        .post("/api/v1/ecommerce-core/guest/checkout", formData)
        .then((response) => {
          if (response.data.success) {
            if (response.data.response_url) {
              this.$store.dispatch("flushCartData").then(() => {
                window.location.href = response.data.response_url;
              });
            }
          } else {
            this.$toast.error("Order create failed");
          }
          this.orderCreating = false;
        })
        .catch((error) => {
          this.orderCreating = false;
          if (error.response.status == 422) {
            var errors = error.response.data.errors;
            var errormessage = "";
            Object.keys(errors).forEach(function (key) {
              errormessage += errors[key];
            });
            this.$toast.error(errormessage);
          } else {
            this.$toast.error("Order create failed");
          }
        });
    },
    /**
     * Go to previous step
     */
    goPreviousStep() {
      this.$emit("previous-step");
    },
    /**
     * Set address data
     *
     */
    getAddressData(address) {
      let modifiedAddress = {
        address: address.address,
        name: address.name,
        email: address.email,
        phone: address.phone,
        phone_code: address.phone_code,
        postal_code: address.postal_code,
        country_id: address.country.hasOwnProperty("id")
          ? address.country.id
          : null,
        state_id: address.state.hasOwnProperty("id") ? address.state.id : null,
        city_id: address.city.hasOwnProperty("id") ? address.city.id : null,
      };

      return modifiedAddress;
    },
  },
};
</script>
