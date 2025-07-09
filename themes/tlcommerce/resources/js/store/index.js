import { createStore } from "vuex";
import mutations from "./mutations.js";
import actions from "./actions.js";
import getters from "./getters.js";
import createMultiTabState from 'vuex-multi-tab-state';

const store = createStore({
  state() {
    return {
      notifications: [],
      siteSettings: JSON.parse(localStorage.getItem("siteSettings")) || null,
      siteProperties: JSON.parse(localStorage.getItem("siteProperties")) || null,
      currency: JSON.parse(localStorage.getItem("currency")) || {},
      defaultCurrency: JSON.parse(localStorage.getItem("default_currency")) || {},
      customerToken: JSON.parse(localStorage.getItem("customerToken")) || "",
      customerInfo: JSON.parse(localStorage.getItem("customerInfo")) || {},
      customerDashboardInfo: JSON.parse(localStorage.getItem("customerDashboardInfo")) || null,
      isCustomerLogin: JSON.parse(localStorage.getItem("isCustomerLogin")) || false,
      locale: localStorage.getItem("locale") || "en",
      compareItems: JSON.parse(localStorage.getItem("compareItems") || "[]"),
      cart: JSON.parse(localStorage.getItem("cart") || "[]"),
      checkoutItems: JSON.parse(localStorage.getItem("checkoutItems") || "[]"),
      billingDetails: JSON.parse(localStorage.getItem("billingDetails") || null),
      shippingDetails: JSON.parse(localStorage.getItem("shippingDetails") || null),
      guestCustomerInfo: JSON.parse(localStorage.getItem("guestCustomerInfo") || null),
      isActiveBillToDifferentAddress: JSON.parse(localStorage.getItem("isActiveBillToDifferentAddress") || false),
      isActiveCreateNewAccount: JSON.parse(localStorage.getItem("isActiveCreateNewAccount") || false),
      isActivePickupPoint: JSON.parse(localStorage.getItem("isActivePickupPoint") || false),
      isActiveHomeDelivery: JSON.parse(localStorage.getItem("isActiveHomeDelivery") || true),
      pickupPoint: JSON.parse(localStorage.getItem("pickupPoint") || null),
      shippingCost: JSON.parse(localStorage.getItem("shippingCost") || 0),
      tax: JSON.parse(localStorage.getItem("tax") || 0),
      couponDiscount: JSON.parse(localStorage.getItem("couponDiscount") || "[]"),
      couponCode: JSON.parse(localStorage.getItem("couponCode") || null),
      mode: localStorage.getItem("mode") || null,
      preloaderLoading: false,
    };
  },
  mutations,
  actions,
  getters,
  plugins: [
    createMultiTabState(),
  ],
});

export default store;
