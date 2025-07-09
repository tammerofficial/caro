<template>
  <!-- Header Top -->
  <div
    class="custom-header-mid header-top py-20 c1-bg"
    @scroll="scrollHandler"
    ref="fooHeader"
  >
    <div class="custom-container2">
      <div class="row align-items-center">
        <div class="col-lg-3" v-if="!this.isSticky">
          <template v-if="mode == 'dark'">
            <the-logo
              :header-logo-style="headerLogoStyle"
              :logo="siteProperties.logo_dark"
              :title="siteProperties.site_name"
              v-if="siteProperties.logo_dark"
            />
            <h2 class="site-title" v-else>
              <a href="/">{{ siteProperties.site_name }}</a>
            </h2>
          </template>
          <template v-else>
            <the-logo
              :header-logo-style="headerLogoStyle"
              :logo="siteProperties.logo"
              :title="siteProperties.site_name"
              v-if="siteProperties.logo"
            />
            <h2 class="site-title" v-else>
              <a href="/">{{ siteProperties.site_name }}</a>
            </h2>
          </template>
        </div>
        <div class="col-lg-3" v-else>
          <template v-if="mode == 'dark'">
            <div v-if="siteProperties.sticky_black_logo">
              <the-logo
                :header-logo-style="headerLogoStyle"
                :logo="siteProperties.sticky_black_logo"
                :title="siteProperties.site_name"
              />
            </div>
            <div v-else>
              <h2 class="site-title">
                <a href="/">{{ siteProperties.site_name }}</a>
              </h2>
            </div>
          </template>
          <template v-else>
            <div v-if="siteProperties.sticky_logo">
              <the-logo
                :header-logo-style="headerLogoStyle"
                :logo="siteProperties.sticky_logo"
                :title="siteProperties.site_name"
              />
            </div>
            <div v-else>
              <h2 class="site-title">
                <a href="/">{{ siteProperties.site_name }}</a>
              </h2>
            </div>
          </template>
        </div>
        <div class="col-lg-6 position-relative">
          <!-- Search Form -->
          <search-form
            @search-suggestions="getSearchProducts"
            rounded
            style-two
          />
          <!-- End Search Form -->
          <div
            class="search-suggestion box-shadow bg-white"
            v-if="suggestionsOpen"
          >
            <div
              v-if="
                tag_suggestions.length ||
                category_suggestions ||
                products_suggestions
              "
            >
              <!--Tags suggestions List-->
              <div v-if="tag_suggestions.length">
                <div
                  class="px-2 py-1 text-uppercase fs-10 text-right text-muted bg-soft-secondary"
                >
                  {{ $t("Popular Suggestions") }}
                </div>
                <ul class="list-unstyled mb-0">
                  <li
                    class="d-block text-left suggestion_list"
                    v-for="(tag, index) in tag_suggestions"
                    :key="index"
                  >
                    <router-link :to="`/product/search?tag=${tag.permalink}`">{{
                      tag.name
                    }}</router-link>
                  </li>
                </ul>
              </div>
              <!--End Tags suggestion List--->

              <!--Categories suggestions List-->
              <div v-if="category_suggestions">
                <div
                  class="px-2 py-1 text-uppercase fs-10 text-right text-muted bg-soft-secondary"
                >
                  {{ $t("Category Suggestions") }}
                </div>
                <ul class="list-unstyled mb-0">
                  <li
                    class="d-block text-left suggestion_list"
                    v-for="(category, index) in category_suggestions"
                    :key="index"
                  >
                    <router-link :to="`/products/category/${category.slug}`">{{
                      category.name
                    }}</router-link>
                  </li>
                </ul>
              </div>
              <!--End Categories suggestion List--->
              <div v-if="products_suggestions">
                <div
                  ref="searchSuggestion"
                  class="px-2 py-1 text-uppercase fs-10 text-right text-muted bg-soft-secondary"
                >
                  {{ $t("Products Suggestions") }}
                </div>
                <!--Product List-->
                <ul class="list-unstyled mb-0">
                  <li
                    class="d-block text-left suggestion_list"
                    v-for="(product, index) in products_suggestions"
                    :key="index"
                  >
                    <single-product :item="product" small />
                  </li>
                </ul>
                <!--End Product List--->
              </div>
            </div>

            <div class="p-3 text-center mt-1" v-else>
              {{ $t("Sorry, nothing found for") }}
              <strong>{{ search_key }}</strong>
            </div>
          </div>
        </div>
        <div class="col-lg-3">
          <!-- Header Buttons -->
          <ul class="header-btn-group nav justify-content-end">
            <li v-if="enable_product_compare == 1">
              <router-link to="/compare" class="btn-circle custom-icon-btn">
                <span class="material-icons">compare_arrows</span>
                <span
                  class="count position-absolute d-flex align-items-center justify-content-center"
                  >{{ compareItem }}</span
                >
              </router-link>
            </li>
            <li>
              <router-link
                to="/dashboard/wishlist"
                class="btn-circle custom-icon-btn"
              >
                <base-icon-svg
                  name="wishlist"
                  class="material-icons"
                  :width="16.5"
                  :height="16.5"
                />
                <span
                  class="count position-absolute d-flex align-items-center justify-content-center"
                  >{{ wishlistItem }}</span
                >
              </router-link>
            </li>

            <li>
              <router-link to="/cart" class="btn-circle custom-icon-btn">
                <span class="material-icons">shopping_cart</span>
                <span
                  class="count position-absolute d-flex align-items-center justify-content-center"
                  >{{ cartItem }}</span
                >
              </router-link>
            </li>
          </ul>
          <!-- End Header Buttons -->
        </div>
      </div>
    </div>
  </div>
  <!-- End Header Top -->
</template>
<script>
import { mapState } from "vuex";
import SearchForm from "@/components/ui/SearchForm.vue";
import SingleProduct from "../product/SingleProduct.vue";
import axios from "axios";
export default {
  name: "HeaderMiddle",
  components: {
    SearchForm,
    SingleProduct,
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
    wishlistItem: {
      type: Number,
      required: false,
      default: 0,
    },
    compareItem: {
      type: Number,
      required: false,
      default: 0,
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
      loading: false,
      search_key: "",
      suggestionsOpen: false,
      products_suggestions: [],
      category_suggestions: [],
      tag_suggestions: [],
      active: 1,
      isSticky: false,
    };
  },
  computed: mapState({
    enable_product_compare: (state) =>
      state.siteSettings != null
        ? state.siteSettings.enable_product_compare
        : 0,
  }),
  mounted() {
    window.addEventListener("scroll", this.scrollHandler);
    document.addEventListener("click", this.close);
  },
  methods: {
    /**
     * Will close dropdown area
     *
     * @param {*} e
     */
    close(e) {
      let el1 = this.$refs.searchSuggestion;
      let target = e.target;
      if (el1 !== target && !el1?.contains(target)) {
        this.suggestionsOpen = false;
      }
    },
    /**
     * Get suggestions products
     *
     */
    getSearchProducts(search_key) {
      this.search_key = search_key;
      this.loading = true;
      if (search_key) {
        axios
          .post("/api/v1/ecommerce-core/search-suggestions", {
            search_key: search_key,
          })
          .then((response) => {
            this.loading = false;
            if (response.data.success) {
              this.suggestionsOpen = true;
              this.category_suggestions = response.data.categories.data;
              this.products_suggestions = response.data.products.data;
              this.tag_suggestions = response.data.tags;
            }
          })
          .catch((error) => {});
      } else {
        this.suggestionsOpen = false;
      }
    },
    scrollHandler() {
      const fooHeader = this.$refs.fooHeader;
      if (window.pageYOffset > 100) {
        this.isSticky = true;
        fooHeader.classList.add("sticky", "fadeInDowns");
      } else {
        this.isSticky = false;
        fooHeader.classList.remove("sticky", "fadeInDowns");
      }
    },
  },
};
</script>

<style lang="scss" scoped>
.search-suggestion {
  z-index: 9;
  position: absolute;
  top: 99%;
  width: 90%;
  left: 50%;
  max-height: 500px;
  min-height: 100px;
  overflow-y: scroll;
  overflow-x: hidden;
  transform: translateX(-50%);
  border-radius: 0px;
  scrollbar-width: none !important;
  box-shadow: 0 10px 15px -3px rgb(0 0 0 / 10%), 0 4px 6px -2px rgb(0 0 0 / 5%) !important;
}
.search-suggestion::-webkit-scrollbar {
  display: none;
}
.color-gray {
  color: #0a0e33b8;
}
.font-weight-custom {
  font-weight: 600;
}
.suggestion_list {
  padding: 10px 5px;
}
.suggestion_list:not(:last-child) {
  border-bottom: 1px solid rgba(51, 51, 51, 0.1);
}
.suggestion_list:hover {
  background-color: #dcdcdc36;
}
.bg-soft-secondary {
  background-color: rgb(238 240 242) !important;
}
.fs-10 {
  font-size: 0.625rem !important;
}
.text-muted {
  color: #6c757d !important;
}
</style>