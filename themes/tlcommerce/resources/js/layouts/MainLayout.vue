<template>
  <div class="layout__two">
    <preloader :loading="preloaderLoading"></preloader>
    <top-bar-banner
      :properties="top_bar_banner_properties"
      v-if="
        top_bar_banner_properties != null &&
        top_bar_banner_properties.topbar_banner_status == 1
      "
    ></top-bar-banner>
    <!-- Header -->
    <header class="header__two love-sticky">
      <header-top
        :data-loading="MenuItemsLoading"
        :currencies="data.currencies"
        :languages="data.languages"
        :right-menu-items="rightMenuItems"
        :left-menu-items="leftMenuItems"
        :header-menu-style="headerMenuStyle"
        @change-language-currency="setCurrencyLanguage"
        @logout-customer="logoutCustomer"
      ></header-top>
      <header-middle
        :site-properties="data.site_properties"
        :mode="mode"
        :cart-item="cartItem"
        :wishlist-item="wishlistItem"
        :compare-item="compareItem"
        :header-logo-style="headerLogoStyle"
        :header-menu-style="headerMenuStyle"
        class="d-none d-lg-block"
      ></header-middle>
      <header-bottom
        :data-loading="MenuItemsLoading"
        :mega-categories="data.megaCategories"
        :menu-items="headerBottomMenu"
        :header-style="headerStyle"
        :header-menu-style="headerMenuStyle"
        class="d-none d-lg-block"
      ></header-bottom>
    </header>

    <mobile-header
      :site-properties="data.site_properties"
      :mode="mode"
      :cart-item="cartItem"
      :header-style="headerStyle"
      :header-menu-style="headerMenuStyle"
      :header-logo-style="headerLogoStyle"
    ></mobile-header>
    <!-- End Header -->

    <div class="main_content light-bg">
      <slot />
    </div>

    <StickyFooter v-if="!isSingleProduct" />

    <!-- Footer -->
    <footer
      :class="
        this.footerStyle.custom_footer == 1
          ? 'custom-footer footer footer__two c1-bg'
          : 'footer footer__two c1-bg'
      "
      :style="{ backgroundImage: `url('${footerBgImg}')` }"
    >
      <!-- Footer Top -->
      <div class="footer-top">
        <div class="custom-container2">
          <div class="row justify-content-between">
            <v-runtime-template :template="widget_html"></v-runtime-template>
          </div>
        </div>
      </div>
      <!-- End Footer Top -->
      <!-- Footer Bottom -->
      <div class="footer-bottom">
        <div class="custom-container2">
          <div class="border-top text-center py-4">
            <copyright :site-properties="data.site_properties" />
          </div>
        </div>
      </div>
      <!-- End Footer Bottom -->
    </footer>
    <!-- End Footer -->

    <!--Cookie Consent-->
    <gdpr
      v-if="gdpr_properties != null && gdpr_properties.gdpr_status == 1"
      :properties="gdpr_properties"
    ></gdpr>
    <!--End Cookie Consent-->

    <!-- Dark Light Switcher -->
    <div class="floating-mode-switcher-wrap" v-if="dark_light_status == '1'">
      <label class="dl-switch">
        <input
          class="dark-looks-mode-changer"
          @change="toggleDark"
          :checked="mode == 'dark'"
          type="checkbox"
        />
        <span class="dl-slider"></span>
        <span class="dl-light">Light</span>
        <span class="dl-dark">Dark</span>
      </label>
    </div>
    <!-- End Dark Light Switcher -->
    <!--Website popup-->
    <CModal
      :visible="visibleWebsitePopup"
      alignment="center"
      class="website-popup-modal"
      @close="
        () => {
          visibleWebsitePopup = false;
        }
      "
    >
      <CModalBody
        class="modal-body p-0 position-relative website-popup-modal-body rounded-0"
      >
        <button
          class="btn-circle custom-modal-btn position-absolute size-35"
          @click="closePopupModal()"
        >
          <base-icon-svg name="close" :width="10" :height="10" />
        </button>
        <div
          class="m-0"
          v-html="website_popup_properties.website_popup_content"
        ></div>
        <subscribe-form
          class="mt-20"
          v-if="website_popup_properties.website_popup_subscribe_status == 1"
        ></subscribe-form>
      </CModalBody>
    </CModal>
    <!--End website popup-->

    <BackToTop />
  </div>
</template>

<script>
import { mapState } from "vuex";
import config from "../config.js";
const axios = require("axios").default;
import VRuntimeTemplate from "vue3-runtime-template";

const address_widget = defineAsyncComponent(() =>
  import("@/components/widget/address_widget.vue")
);

const newsletter_widget = defineAsyncComponent(() =>
  import("@/components/widget/newsletter_widget.vue")
);
const social_links = defineAsyncComponent(() =>
  import("@/components/widget/social_links.vue")
);
const Copyright = defineAsyncComponent(() =>
  import("@/components/ui/Copyright.vue")
);
const StickyFooter = defineAsyncComponent(() =>
  import("@/components/ui/StickyFooter.vue")
);
const Gdpr = defineAsyncComponent(() => import("@/components/ui/Gdpr.vue"));

const TopBarBanner = defineAsyncComponent(() =>
  import("@/components/ui/TopBarBanner.vue")
);

const HeaderTop = defineAsyncComponent(() =>
  import("@/components/pageheader/HeaderTop.vue")
);

const HeaderMiddle = defineAsyncComponent(() =>
  import("@/components/pageheader/HeaderMiddle.vue")
);
const HeaderBottom = defineAsyncComponent(() =>
  import("@/components/pageheader/HeaderBottom.vue")
);

const MobileHeader = defineAsyncComponent(() =>
  import("@/components/pageheader/MobileHeader.vue")
);

const BackToTop = defineAsyncComponent(() =>
  import("@/components/ui/BackToTop.vue")
);
const Preloader = defineAsyncComponent(() =>
  import("@/components/ui/Preloader.vue")
);

const footer_left_menu = defineAsyncComponent(() =>
  import("@/components/widget/footer_left_menu.vue")
);

const footer_right_menu = defineAsyncComponent(() =>
  import("@/components/widget/footer_right_menu.vue")
);
const SubscribeForm = defineAsyncComponent(() =>
  import("@/components/widget/SubscribeForm.vue")
);

const featured_blog_widget = defineAsyncComponent(() =>
  import("@/components/widget/featured_blog_widget.vue")
);

const recent_blog_widget = defineAsyncComponent(() =>
  import("@/components/widget/recent_blog_widget.vue")
);

import { defineAsyncComponent, reactive } from "vue";
import { useStore } from "vuex";
import {
  CModal,
  CButton,
  CModalHeader,
  CModalTitle,
  CModalBody,
} from "@coreui/vue";

export default {
  name: "MainLayout",
  components: {
    CModal,
    CButton,
    CModalHeader,
    CModalTitle,
    CModalBody,
    HeaderTop,
    HeaderMiddle,
    HeaderBottom,
    MobileHeader,
    BackToTop,
    Copyright,
    StickyFooter,
    Gdpr,
    TopBarBanner,
    SubscribeForm,
    address_widget,
    footer_left_menu,
    footer_right_menu,
    newsletter_widget,
    social_links,
    featured_blog_widget,
    recent_blog_widget,
    VRuntimeTemplate,
    Preloader,
  },

  setup() {
    const data = reactive({
      site_properties: {},
      languages: [],
      currencies: [],
      megaCategories: [],
    });

    const store = useStore();
    getSiteProperties();
    getMegacategories();

    /**
     * Get site properties
     */
    function getSiteProperties() {
      const headers = {
        "Content-Type": "application/json",
        "Accept-Language": localStorage.getItem("locale") || "en",
      };
      axios
        .get("/api/v1/ecommerce-core/site-properties", {
          headers: headers,
        })
        .then((response) => {
          if (response.data.success) {
            data.site_properties = response.data.siteProperties;
            data.languages = response.data.languages;
            data.currencies = response.data.currencies;
            store.dispatch("siteSettings", response.data.site_settings);
            store.dispatch("siteProperties", response.data.siteProperties);
          }
        })
        .catch((error) => {});
    }
    /**
     * Get Mega categories
     */
    function getMegacategories() {
      const headers = {
        "Content-Type": "application/json",
        "Accept-Language": localStorage.getItem("locale") || "en",
      };

      axios
        .get("/api/v1/ecommerce-core/mega-categories", {
          headers: headers,
        })
        .then((response) => {
          if (response.data.success) {
            data.megaCategories = response.data.data;
          }
        })
        .catch((error) => {
          data.megaCategories = [];
        });
    }

    return {
      data,
      getSiteProperties,
      getMegacategories,
    };
  },

  data() {
    return {
      config: config,
      MenuItemsLoading: true,
      headerBottomMenu: [],
      leftMenuItems: [],
      rightMenuItems: [],

      footerLeftMenus: [],
      footerLeftTitle: "",

      footerRightMenus: [],
      footerRightTitle: "",

      footerRightMenus: [],
      contactInfo: {},
      subscription: {
        widget_title: "",
        newsletter_short_desc: "",
      },

      widget_options: [],
      widget_html: "",
      headerStyle: {},
      headerLogoStyle: {},
      headerMenuStyle: {},
      footerStyle: {},
      socialStyle: {},
      subscriptionFormStyle: {},
      footerBgImg: "#",
      isSingleProduct: true,
      load_complete: false,

      visibleWebsitePopup: false,
      top_bar_banner_properties: null,
      gdpr_properties: null,
      website_popup_properties: null,
      dark_light_status: "0",
    };
  },
  computed: mapState({
    preloaderLoading: (state) => state.preloaderLoading,
    mode: (state) => state.mode,
    customerToken: (state) => state.customerToken,
    isCustomerLogin: (state) => state.isCustomerLogin,
    wishlistItem: (state) =>
      state.customerDashboardInfo != null
        ? state.customerDashboardInfo.total_wishlisted_product
        : 0,
    cartItem: (state) =>
      state.cart.length ? state.cart.reduce((a, b) => a + b.quantity, 0) : 0,
    compareItem: (state) =>
      state.compareItems.length ? state.compareItems.length : 0,
  }),

  mounted() {
    var body = document.querySelector("body");
    body.className = this.mode == "dark" ? "dark" : "";
    this.getThemeStyle();
    this.getAllMenusForEcommerceHome();
    this.getFooterWidget();

    if (this.isCustomerLogin) {
      this.checkCustomerAuthentication();
      setInterval(this.checkCustomerAuthentication, 1000 * 60);
    }
    this.$store.state.$t = this.translateLanguage;
  },

  methods: {
    translateLanguage(val) {
      return this.$t(val);
    },

    /**
     * Check customer authentication
     */
    checkCustomerAuthentication() {
      axios
        .get("/api/v1/ecommerce-core/auth/customer-refresh-auth", {
          headers: {
            Authorization: `Bearer ${this.customerToken}`,
          },
        })
        .then((response) => {
          if (response.data.success) {
            this.$store.dispatch("customerLogin", response.data);
            this.$store.dispatch("getCustomerCartItems");
          } else {
            this.$store.dispatch("customerLogout");
          }
        })
        .catch((error) => {
          this.$store.dispatch("customerLogout");
        });
    },

    /**
     * Get all ecommerce menus
     */
    getAllMenusForEcommerceHome() {
      const headers = {
        "Content-Type": "application/json",
        "Accept-Language": localStorage.getItem("locale") || "en",
      };
      axios
        .get("/api/theme/tlcommerce/v1/get-all-menus-for-ecommerce-home", {
          headers: headers,
        })
        .then((response) => {
          if (response.data.success) {
            this.rightMenuItems = response.data.header_top_right_menus.menus;
            this.leftMenuItems = response.data.header_top_left_menus.menus;
            this.headerBottomMenu =
              response.data.header_bottom_middle_menus.menus;

            this.footerLeftMenus = response.data.footer_widget_left_menus.menus;
            this.footerLeftTitle =
              response.data.footer_widget_left_menus.widget_title;

            this.footerRightMenus =
              response.data.footer_widget_right_menus.menus;
            this.footerRightTitle =
              response.data.footer_widget_right_menus.widget_title;
            this.MenuItemsLoading = false;
          }
        })
        .catch((error) => {
          this.MenuItemsLoading = false;
        });
    },

    /**
     * Get footer widget right menus
     */
    getFooterWidget() {
      const headers = {
        "Content-Type": "application/json",
        "Accept-Language": localStorage.getItem("locale") || "en",
      };
      axios

        .get("/api/theme/tlcommerce/v1/get-footer-widgets", {
          headers: headers,
        })
        .then((response) => {
          if (response.data.success) {
            this.widget_options = response.data.widget_options;
            for (const [key, value] of Object.entries(this.widget_options)) {
              if (key == "address_widget") {
                this.widget_html =
                  this.widget_html +
                  '<div class="col-lg-3 col-sm-6"><' +
                  key +
                  " :" +
                  key +
                  '="widget_options.' +
                  key +
                  '" :footer-style="footerStyle"/><social_links class="widget" :social_links="widget_options.address_widget.social_links" :social-style="socialStyle"/></div>';
              } else if (key == "newsletter_widget") {
                this.widget_html =
                  this.widget_html +
                  '<div class="col-lg-3 col-sm-6"><' +
                  key +
                  " :" +
                  key +
                  '="widget_options.' +
                  key +
                  '" :subscription-form-style="subscriptionFormStyle" :footer-style="footerStyle"/></div>';
              } else if (key == "footer_left_menu") {
                this.widget_html =
                  this.widget_html +
                  '<div class="col-lg-3 col-sm-6"><' +
                  key +
                  " :" +
                  key +
                  '="widget_options.' +
                  key +
                  '" :footer-style="footerStyle"/></div>';
              } else if (key == "footer_right_menu") {
                this.widget_html =
                  this.widget_html +
                  '<div class="col-lg-3 col-sm-6"><' +
                  key +
                  " :" +
                  key +
                  '="widget_options.' +
                  key +
                  '" :footer-style="footerStyle"/></div>';
              } else {
                this.widget_html =
                  this.widget_html +
                  '<div class="col-lg-3 col-sm-6"><' +
                  key +
                  " :" +
                  key +
                  '="widget_options.' +
                  key +
                  '"/></div>';
              }
            }
          }
        })
        .catch((error) => {});
    },

    /**
     * Get theme style
     */
    getThemeStyle() {
      const headers = {
        "Content-Type": "application/json",
        "Accept-Language": localStorage.getItem("locale") || "en",
      };

      axios
        .get("/api/theme/tlcommerce/v1/get-theme-style", {
          headers: headers,
        })
        .then((response) => {
          if (response.data.success) {
            this.headerStyle = response.data.headerOptions;
            this.headerLogoStyle = response.data.headerLogoStyles;
            this.headerMenuStyle = response.data.headerMenuStyle;
            this.footerStyle = response.data.footerStyle;
            this.socialStyle = response.data.socialStyle;
            this.subscriptionFormStyle = response.data.subscriptionFormStyle;

            this.top_bar_banner_properties =
              response.data.top_bar_banner_properties;
            this.website_popup_properties =
              response.data.website_popup_properties;
            this.gdpr_properties = response.data.gdpr_properties;
            //Dark light switcher status
            this.dark_light_status = response.data.dark_light_status;
            //website popup
            if (
              this.website_popup_properties != null &&
              this.website_popup_properties.website_popup_status == 1
            ) {
              let cooke_value = null;
              const cookies = document.cookie.split("; ");
              for (const cookie of cookies) {
                const [name, value] = cookie.split("=");
                if (name === "website_popup") {
                  cooke_value = value;
                }
              }
              if (cooke_value != null && cooke_value == 1) {
                this.visibleWebsitePopup = false;
              } else {
                this.visibleWebsitePopup = true;
              }
            }
          }
        })
        .catch((error) => {});
    },

    /**
     * Set Language
     * Set Currency
     */
    setCurrencyLanguage(lang, currency) {
      localStorage.setItem("locale", lang);
      localStorage.setItem("currency", JSON.stringify(currency));
      location.reload();
    },

    /**
     * Will logout customer
     */
    logoutCustomer() {
      axios
        .get("/api/v1/ecommerce-core/auth/customer-logout", {
          headers: {
            Authorization: `Bearer ${this.customerToken}`,
          },
        })
        .then((response) => {
          if (response.data.success) {
            this.$toast.success(this.$t("Logout successful"));
            this.$store.dispatch("customerLogout").then(() => {
              this.$store.dispatch("flushCartData");
              this.$router.push("/");
            });
          } else {
            this.$store.dispatch("customerLogout").then(() => {
              this.$store.dispatch("flushCartData");
              this.$router.push("/");
            });
          }
        })
        .catch((error) => {
          this.$store.dispatch("customerLogout").then(() => {
            this.$store.dispatch("flushCartData");
            this.$router.push("/");
          });
        });
    },

    /**
     * Toggle dark mood
     */
    toggleDark(e) {
      if (e.target.checked) {
        localStorage.setItem("mode", "dark");
        this.$store.dispatch("changeScreenMode", "dark");
      } else {
        localStorage.removeItem("mode");
        this.$store.dispatch("changeScreenMode", null);
      }
      var body = document.querySelector("body");
      body.className = e.target.checked ? "dark" : "";
    },
    /**
     * Close website popup modal
     */
    closePopupModal() {
      const now = new Date();
      const expires = new Date(now.getTime() + 2 * 60 * 60 * 1000);
      document.cookie = `website_popup=1; expires=${expires.toUTCString()}; path=/`;
      this.visibleWebsitePopup = false;
    },
  },
  watch: {
    $route(to, from) {
      if (this.$route.name === "product") {
        this.isSingleProduct = true;
      } else {
        this.isSingleProduct = false;
      }
    },
  },
  beforeDestroy() {
    document.removeEventListener("click", this.close);
  },
};
</script>

<style scoped lang="scss">
.modal-dialog.modal-dialog-centered {
  background-color: red;
}
.modal.website-popup-modal .modal-content {
  border-radius: 0px !important;
}
.custom-modal-btn {
  top: -15px;
  right: -15px;
}
.footer {
  display: block;
  padding: 0;
}
.main_content {
  min-height: 100vh;
}
.header-btn-group {
  .btn-circle {
    .material-icons {
      font-size: 22px;
    }
    &:hover {
      .icon-wrapper svg,
      .icon-wrapper .icon {
        color: #fff;
      }
    }
  }
}
</style>
