<template>
  <!-- Mobile Header -->
  <header
    :class="
      this.headerStyle.custom_header == 1
        ? ' c1-bg custom-mobile-header mobile_header__two d-lg-none'
        : 'mobile_header__two d-lg-none c1-bg'
    "
    @scroll="scrollHandler"
    ref="mobileHeader"
  >
    <div class="custom-container2">
      <div class="row align-items-center justify-content-between">
        <div class="col-6" v-if="!isSticky">
          <template v-if="mode == 'dark'">
            <the-logo
              :logo="siteProperties.mobile_dark_logo"
              :title="siteProperties.site_title"
              :header-logo-style="headerLogoStyle"
              v-if="siteProperties.mobile_dark_logo"
            />
            <h4 class="site-title" v-else>
              {{ siteProperties.site_title }}
            </h4>
          </template>
          <template v-else>
            <the-logo
              :logo="siteProperties.mobile_logo"
              :title="siteProperties.site_title"
              :header-logo-style="headerLogoStyle"
              v-if="siteProperties.mobile_logo"
            />
            <h4 class="site-title" v-else>
              <router-link to="/">
                {{ siteProperties.site_title }}
              </router-link>
            </h4>
          </template>
        </div>
        <div class="col-6" v-else>
          <template v-if="mode == 'dark'">
            <the-logo
              :logo="siteProperties.sticky_black_mobile_logo"
              :title="siteProperties.site_title"
              :header-logo-style="headerLogoStyle"
              v-if="siteProperties.sticky_black_mobile_logo"
            />
            <h4 class="site-title" v-else>
              {{ siteProperties.site_title }}
            </h4>
          </template>
          <template v-else>
            <the-logo
              :logo="siteProperties.sticky_mobile_logo"
              :title="siteProperties.site_title"
              :header-logo-style="headerLogoStyle"
              v-if="siteProperties.sticky_mobile_logo"
            />
            <h4 class="site-title" v-else>
              {{ siteProperties.site_title }}
            </h4>
          </template>
        </div>

        <div
          class="
            col-6
            d-flex
            align-items-center
            justify-content-end
            position-static
          "
        >
          <!-- Offcanvas -->
          <the-offcanvas
            :user-info="customerInfo"
            :menu-items="offcanvas.menuItems"
            :header-menu-style="headerMenuStyle"
            :header-style="headerStyle"
            class="mr-20"
          />
          <!-- End The Offcanvas -->

          <!-- Search Form -->
          <search-form style-two mobile-style class="mr-20" />
          <!-- End Search Form -->

          <!-- Cart Button -->
          <router-link to="/cart" class="btn-circle custom-icon-btn">
            <base-icon-svg
              name="cart"
              class="material-icons"
              :width="18"
              :height="15"
            />
            <span
              class="
                count
                position-absolute
                d-flex
                align-items-center
                justify-content-center
              "
              >{{ cartItem }}</span
            >
          </router-link>
          <!-- End Cart Button -->
        </div>
      </div>
    </div>
  </header>
  <!-- End Mobile Header -->
</template>
<script>
import offcanvas from "@/fakeDB/offcanvas.json";
import SearchForm from "@/components/ui/SearchForm.vue";
import TheOffcanvas from "@/components/menu/TheOffcanvas.vue";
import { mapState } from "vuex";
export default {
  name: "MobileHeader",
  components: {
    SearchForm,
    TheOffcanvas,
  },
  props: {
    siteProperties: {
      type: Object,
      required: false,
    },
    mode: {
      type: String,
      required: false,
    },
    cartItem: {
      type: Number,
      required: false,
      default: 0,
    },
    headerStyle: {
      type: Object,
      required: false,
      default: () => {
        return {};
      },
    },
    headerMenuStyle: {
      type: Object,
      required: false,
      default: () => {
        return {};
      },
    },
    headerLogoStyle: {
      type: Object,
      required: false,
      default: () => {
        return {};
      },
    },
  },
  data() {
    return {
      offcanvas,
      wishlistItem: 0,
      compareItem: 0,
      isSticky: false,
    };
  },
  computed: mapState({
    customerInfo: (state) => state.customerInfo,
  }),
  mounted() {
    window.addEventListener("scroll", this.scrollHandler);
  },
  methods: {
    scrollHandler() {
      const mobileHeader = this.$refs.mobileHeader;
      if (window.pageYOffset > 100) {
        this.isSticky = true;
        mobileHeader.classList.add("sticky", "fadeInDowns");
      } else {
        this.isSticky = false;
        mobileHeader.classList.remove("sticky", "fadeInDowns");
      }
    },
  },
};
</script>
