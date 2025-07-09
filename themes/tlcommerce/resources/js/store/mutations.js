import { useToast } from 'vue-toast-notification';
import 'vue-toast-notification/dist/theme-sugar.css';
const $toast = useToast();
export default {
  /**
 * Set site settings
 */
  siteSettings(state, data) {
    state.siteSettings = data;
    localStorage.setItem("siteSettings", JSON.stringify(state.siteSettings));
  },
  /**
 * Set Properties
 */
  siteProperties(state, data) {
    state.siteProperties = data;
    localStorage.setItem("siteProperties", JSON.stringify(state.siteProperties));
  },
  changeScreenMode(state, payload) {
    state.mode = payload;
  },
  changeCurrency(state, payload) {
    state.currency = payload;
  },

  showPreloader(state, payload) {
    return state.preloaderLoading = payload;
  },

  setlanguage(state, language) {
    state.locale = language;
  },
  /**
   * Store cart items
   */
  storeCartItems(state, item) {
    //Remove applied coupon
    state.couponDiscount = [];
    localStorage.removeItem("couponDiscount");
    //Add item to cart
    let productInCart = state.cart.find((product) => product.id === item.id && product.variant === item.variant);
    if (productInCart) {
      productInCart.quantity += item.quantity;
      if (productInCart.quantity <= productInCart.max_item) {
        localStorage.setItem("cart", JSON.stringify(state.cart));
        $toast.success(state.$t("Product add to cart successfully") +
          '<a href="/cart" class="btn btn-sm m-md-2 m-lg-2 ml-1">'
          + state.$t("View Cart") +
          "</a>"
        );
      } else {
        productInCart.quantity -= item.quantity;
        $toast.error(state.$t("Cross the available quantity"));
      }
    } else {
      state.cart.push(item);
      localStorage.setItem("cart", JSON.stringify(state.cart));
      $toast.success(state.$t("Product add to cart successfully") +
        '<a href="/cart" class="btn btn-sm m-md-2 m-lg-2 ml-1">'
        + state.$t("View Cart") +
        "</a>"
      );
    }

  },
  /**
   *add data to checkout item
   */
  addItemsToCheckoutItems(state, data) {
    state.checkoutItems = data;
    localStorage.setItem("checkoutItems", JSON.stringify(state.checkoutItems));
  },
  /**
   * Add item to compare list
   */
  addItemToCompareItems(state, item) {
    let productInCompareList = state.compareItems.find((product) => product == item);
    if (!productInCompareList) {
      state.compareItems.push(item);
      localStorage.setItem("compareItems", JSON.stringify(state.compareItems));
      $toast.success(state.$t("Item has been added to compare list"));
    } else {
      $toast.error(state.$t("Product is already added to compare"));
    }
  },
  /**
   * Will update compare product items
   */
  updateCompareItems(state, data) {
    state.compareItems = data;
    localStorage.setItem("compareItems", JSON.stringify(state.compareItems));
  },
  /**
   * Will update cart
   */
  updateCart(state, data) {
    state.cart = data;
    localStorage.setItem("cart", JSON.stringify(state.cart));
  },
  /**
   * Will store Home delivery checkout
   */
  storeHomeDeliveryCheckout(state, data) {
    state.isActiveHomeDelivery = data;
    localStorage.setItem("isActiveHomeDelivery", JSON.stringify(state.isActiveHomeDelivery));
    state.isActivePickupPoint = false;
    localStorage.setItem("isActivePickupPoint", JSON.stringify(state.isActivePickupPoint));
  },
  /**
   * Will store pickup point  checkout
   */
  storePickoupPointCheckout(state, data) {
    state.isActivePickupPoint = data;
    localStorage.setItem("isActivePickupPoint", JSON.stringify(state.isActivePickupPoint));
    state.isActiveHomeDelivery = false;
    localStorage.setItem("isActiveHomeDelivery", JSON.stringify(state.isActiveHomeDelivery));
  },
  /**
   * Will store selected pickup point 
   */
  storePickoupPoint(state, data) {
    state.pickupPoint = data;
    localStorage.setItem("pickupPoint", JSON.stringify(state.pickupPoint));
  },
  /**
   * Will store billing details
   */
  storeBillingDetails(state, data) {
    state.billingDetails = data;
    localStorage.setItem("billingDetails", JSON.stringify(state.billingDetails));
  },
  /**
   * Will store shipping details
   */
  storeShippingDetails(state, data) {
    state.shippingDetails = data;
    localStorage.setItem("shippingDetails", JSON.stringify(state.shippingDetails));
  },
  /**
   * Store guest customer details
   */
  storeGuestCustomerDetails(state, data) {
    state.guestCustomerInfo = data;
    localStorage.setItem("guestCustomerInfo", JSON.stringify(state.guestCustomerInfo));
  },
  /**
     * Store is_active_ship_to_different_address
     */
  storeIsActiveBillToDifferentAddress(state, data) {
    state.isActiveBillToDifferentAddress = data;
    localStorage.setItem("isActiveBillToDifferentAddress", JSON.stringify(state.isActiveBillToDifferentAddress));
  },
  /**
   * Store is_active_create_guest_account
   */
  storeIsActiveCreateNewAccount(state, data) {
    state.isActiveCreateNewAccount = data;
    localStorage.setItem("isActiveCreateNewAccount", JSON.stringify(state.isActiveCreateNewAccount));
  },
  /**
   * Will set final shipping cost
   */
  setFinalShippingCost(state, data) {
    state.shippingCost = data;
    localStorage.setItem("shippingCost", JSON.stringify(state.shippingCost));
  },
  /**
  * Will set final tax
  */
  setFinalTax(state, data) {
    state.tax = data;
    localStorage.setItem("tax", JSON.stringify(state.tax));
  },
  /**
   * Store is_active_create_guest_account
   */
  storeCouponDiscount(state, item) {
    state.couponDiscount.push(item);
    localStorage.setItem("couponDiscount", JSON.stringify(state.couponDiscount));
  },
  /**
   * Remove applied coupon
   */
  removeCouponDiscount(state, item) {
    let checkCoupon = state.couponDiscount.find((coupon) => coupon.coupon_code === item);
    if (checkCoupon) {
      const index = state.couponDiscount.indexOf(checkCoupon);
      if (index > -1) {
        state.couponDiscount.splice(index, 1);
        localStorage.setItem("couponDiscount", JSON.stringify(state.couponDiscount));
      }
    }
  },
  /**
   * Flush coupon data 
   */
  flushCouponData(state) {
    state.couponDiscount = [];
    localStorage.removeItem("couponDiscount");
  },

  /**
   * Flush Cart data
   */
  flushCartData(state) {

    if (state.checkoutItems.length == state.cart.length) {
      //remove cart
      state.cart = [];
      localStorage.removeItem("cart");
    }

    if (state.checkoutItems.length != state.cart.length) {
      for (let i = 0; i < state.checkoutItems.length; i++) {
        let itemToRemove = state.checkoutItems[i];
        state.cart = state.cart.filter((item) => item.uid !== itemToRemove.uid);
      }
      localStorage.setItem("cart", JSON.stringify(state.cart));
    }

    //remove checkout Items
    state.checkoutItems = [];
    localStorage.removeItem("checkoutItems");

    //Remove Billing address
    state.billingDetails = null;
    localStorage.removeItem("billingDetails");
    //Remove shipping address
    state.shippingDetails = null;
    localStorage.removeItem("shippingDetails");
    //Remove guest customer info
    state.guestCustomerInfo = null;
    localStorage.removeItem("guestCustomerInfo");
    //Remove Is active bill to different address
    state.isActiveBillToDifferentAddress = false;
    localStorage.removeItem("isActiveBillToDifferentAddress");
    //Remove is active create new account
    state.isActiveCreateNewAccount = false;
    localStorage.removeItem("isActiveCreateNewAccount");
    //Remove is active pickup point
    state.isActivePickupPoint = false;
    localStorage.removeItem("isActivePickupPoint");
    //Remove pickup point
    state.pickupPoint = null;
    localStorage.removeItem("pickupPoint");
    //Remove is active home delivery
    state.isActiveHomeDelivery = true;
    localStorage.removeItem("isActiveHomeDelivery");
    //Remove final shipping cost
    state.shippingCost = 0;
    localStorage.removeItem('shippingCost');
    //Remove total vat/tax
    state.tax = 0;
    localStorage.removeItem("tax");
    //remove total coupon discount
    state.couponDiscount = [];
    localStorage.removeItem("couponDiscount");
    //remove coupon code
    state.couponCode = "";
    localStorage.removeItem("couponCode");
  },
  flushCustomerCart(state) {
    //remove cart
    state.cart = [];
    localStorage.removeItem("cart");
  },
  /**
  * Set customer login state
  */
  customerLogin(state, data) {
    state.isCustomerLogin = true;
    if (data.token_refresh) {
      state.customerToken = data.access_token;
      localStorage.setItem("customerToken", JSON.stringify(state.customerToken));
    }
    state.notifications = data.notifications.data;
    state.customerInfo = data.user;
    state.customerDashboardInfo = data.dashboard_content
    localStorage.setItem("customerDashboardInfo", JSON.stringify(state.customerDashboardInfo));
    localStorage.setItem("isCustomerLogin", JSON.stringify(state.isCustomerLogin));
    localStorage.setItem("customerInfo", JSON.stringify(state.customerInfo));
  },
  /**
   * Set customer summary
   * 
   */
  setCustomerDashboardSummary(state, data) {
    state.customerDashboardInfo = data
    localStorage.setItem("customerDashboardInfo", JSON.stringify(state.customerDashboardInfo));
  },
  /**
   * Set logged customer info
   */
  loggedCustomerInfo(state, data) {
    state.customerInfo = data;
    localStorage.setItem("customerInfo", JSON.stringify(state.customerInfo));
  },
  /**
  * Logout customer
  */
  customerLogout(state) {
    state.isCustomerLogin = false;
    state.customerToken = "";
    state.customerInfo = {};
    state.customerDashboardInfo = null;
    localStorage.removeItem("customerDashboardInfo");
    localStorage.removeItem("isCustomerLogin");
    localStorage.removeItem("customerToken");
    localStorage.removeItem("customerInfo");
  },

  /**
   * Will store customer notification
   * 
   */
  customerNotificationMutation(state, data) {
    state.notifications = data;
  }
};
