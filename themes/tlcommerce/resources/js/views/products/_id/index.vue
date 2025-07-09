<template>
  <div class="productDetails">
    <page-header :items="bItems" />

    <!-- Product details Hash Menu -->
    <div class="product-details-hash-menu d-lg-none" ref="hashMenu">
      <div class="custom-container2">
        <ul>
          <li @click.prevent="goSec('overview')">{{ $t("Overview") }}</li>
          <li @click.prevent="goSec('quickConnect')">
            {{ $t("Quick Connect") }}
          </li>
          <li @click.prevent="goSec('productDetails')">
            {{ $t("Product Details") }}
          </li>
          <li @click.prevent="goSec('recommendations')">
            {{ $t("Recommendations") }}
          </li>
        </ul>
      </div>
    </div>
    <!-- End Product details Hash Menu -->

    <div class="pt-4 pb-4 light-bg" ref="overview">
      <div class="custom-container2">
        <div class="product-details" v-if="!productLoading">
          <div class="row">
            <template v-if="product != null">
              <div class="col-lg-5">
                <details-gallery
                  :gallery-images="product.galleryImages"
                  :voucher-list="product.voucher_list"
                  :product-name="product.name"
                  :url="product.url"
                  :summary="product.summary"
                  :networks="product.shareOptions"
                  :key="galleryKey"
                />
              </div>
              <div class="col-lg-7">
                <details-content
                  :product="product"
                  @goto-section="goSec"
                  @color-variant-images="colorVariantImages"
                />
              </div>
            </template>
            <div class="row" v-else>
              <the-not-found title="Sorry! Product not found"></the-not-found>
            </div>
          </div>
        </div>

        <div class="product-details1" v-if="productLoading">
          <div class="row">
            <div class="col-lg-5">
              <gallery-image-skeleton></gallery-image-skeleton>
            </div>
            <div class="col-lg-7">
              <product-details-skeleton></product-details-skeleton>
            </div>
          </div>
        </div>

        <!--Product info card-->
        <div class="row mt-lg-4" v-if="!productLoading && product != null">
          <div class="col-12">
            <ul class="info-list shadow-card" ref="quickConnect">
              <li class="info-item" v-if="product.condition">
                <h4>{{ $t("Conditions") }}</h4>
                <p>{{ $t("Product Condition") }}</p>
                <span class="c1">{{ product.condition }}</span>
              </li>
              <li class="info-item" v-if="product.is_authentic">
                <h4>{{ $t("Authentic") }}</h4>
                <p>{{ $t("Authentic") }}</p>
                <span class="c1">{{ product.is_authentic }}</span>
              </li>
              <li class="info-item" v-if="product.is_active_cod">
                <h4>{{ $t("Payment Option") }}</h4>
                <p>{{ $t("Cash on Delivery") }}</p>
                <span class="c1">{{ product.is_active_cod }}</span>
              </li>
              <li class="info-item">
                <h4>{{ $t("Return Options") }}</h4>
                <p>{{ $t("Change of mind is not applicable") }}</p>
                <span class="c1">{{ product.return_option }}</span>
              </li>
              <li class="info-item">
                <h4>{{ $t("Warranty") }}</h4>
                <p>{{ $t("Seller warranty") }}</p>
                <p v-if="product.has_warranty == enums.status.ACTIVE">
                  <span class="c1"
                    >{{ product.warrenty_days }} {{ $t("days") }}
                    <span class="c1" v-if="product.has_replacement_warranty">
                      {{ $t("replacement") }}</span
                    >
                    <span class="c1"> {{ $t("warranty") }}</span>
                  </span>
                </p>
                <p class="c1" v-else>
                  {{ $t("Not available") }}
                </p>
              </li>
            </ul>
          </div>
        </div>
        <!--End product info card-->

        <!--Tab Content-->
        <div class="row mt-45" v-if="!productLoading && product != null">
          <!--Product widgets-->
          <div class="col-lg-3 d-none d-lg-block">
            <div class="widget_wrap">
              <single-shop
                :shop="product.shopInfo"
                widgetTitle
                v-if="product.shopInfo != null"
              ></single-shop>
              <WidgetTopCategory :categories="topCategories" link="true" />
              <WidgetTopSellingProduct :products="topSellingProducts" />
            </div>
          </div>
          <!--End Product widgets-->
          <!--Product details tabs-->
          <div class="col-lg-9">
            <div class="overview-wrap" ref="productDetails">
              <CNav
                variant="tabs"
                role="tablist"
                class="product-description-tabs bg-light"
              >
                <CNavItem>
                  <CNavLink
                    href="javascript:void(0);"
                    :active="tabPaneActiveKey === 1"
                    @click="
                      () => {
                        tabPaneActiveKey = 1;
                      }
                    "
                  >
                    {{ $t("Product Overview") }}
                  </CNavLink>
                </CNavItem>
                <CNavItem
                  v-if="
                    site_config.enable_product_reviews == enums.status.ACTIVE
                  "
                >
                  <CNavLink
                    href="javascript:void(0);"
                    :active="tabPaneActiveKey === 2"
                    @click="
                      () => {
                        tabPaneActiveKey = 2;
                      }
                    "
                  >
                    {{ $t("Buyer Review") }}
                  </CNavLink>
                </CNavItem>
              </CNav>
              <CTabContent>
                <CTabPane
                  role="tabpanel"
                  aria-labelledby="home-tab"
                  click="product-overview"
                  :visible="tabPaneActiveKey === 1"
                >
                  <div
                    v-if="product.description"
                    v-html="product.description"
                  ></div>
                  <div class="no-review-wrapper text-center py-5" v-else>
                    <h2>{{ $t("No Details Found") }}</h2>
                    <p>
                      {{
                        $t("There are currently no details  for this product")
                      }}
                    </p>
                  </div>
                  <div v-if="product.pdf_specifications">
                    <a :href="product.pdf_specifications" target="_blank"
                      >Download Pdf Specifications</a
                    >
                  </div>
                </CTabPane>
                <CTabPane
                  role="tabpanel"
                  click="buyer-review "
                  aria-labelledby="profile-tab"
                  :visible="tabPaneActiveKey === 2"
                  v-if="
                    site_config.enable_product_reviews == enums.status.ACTIVE
                  "
                >
                  <ProductReview
                    :product-id="product.id"
                    :config="site_config"
                    :key="product.id"
                  ></ProductReview>
                </CTabPane>
              </CTabContent>
            </div>
          </div>
          <!--End product details tabs-->
        </div>
        <!--End Tab Content-->
      </div>
    </div>

    <!-- Related Product -->
    <section
      class="bg-white mt-n1 pb-30 pt-30"
      ref="recommendations"
      v-if="!productLoading && product != null"
    >
      <div class="custom-container2">
        <div class="row align-items-center mb-30">
          <div class="col-md-6">
            <section-title :title="sectionTitle" />
          </div>
        </div>

        <swiper
          v-if="relatedProducts.length"
          :slidesPerView="6"
          :modules="modules"
          :spaceBetween="1"
          :loop="true"
          class="product-grid-slider theme-slider-dots"
          :breakpoints="{
            '0': {
              slidesPerView: 2,
            },
            '480': {
              slidesPerView: 2,
            },
            '768': {
              slidesPerView: 3,
            },
            '1024': {
              slidesPerView: 6,
            },
          }"
        >
          <swiper-slide
            v-for="(item, index) in relatedProducts"
            :key="`slide-${index}`"
          >
            <single-product :item="item" />
          </swiper-slide>
        </swiper>
      </div>
    </section>
    <!-- End Related Product -->
  </div>
</template>

<script>
import { mapState } from "vuex";
import { Pagination } from "swiper";
const axios = require("axios").default;
import enums from "../../../enums/enums";
import { defineAsyncComponent } from "vue";
import { Swiper, SwiperSlide } from "swiper/vue";

const PageHeader = defineAsyncComponent(() =>
  import("@/components/pageheader/PageHeader.vue")
);
const DetailsContent = defineAsyncComponent(() =>
  import("@/components/product/DetailsContent.vue")
);

const ProductReview = defineAsyncComponent(() =>
  import("@/components/product/ProductReview.vue")
);

const SingleProduct = defineAsyncComponent(() =>
  import("@/components/product/SingleProduct.vue")
);

const WidgetTopCategory = defineAsyncComponent(() =>
  import("@/components/widget/WidgetTopCategory.vue")
);

const WidgetTopSellingProduct = defineAsyncComponent(() =>
  import("@/components/widget/WidgetTopSellingProduct.vue")
);

const GalleryImageSkeleton = defineAsyncComponent(() =>
  import("@/components/skeleton/GalleryImageSkeleton.vue")
);

const ProductDetailsSkeleton = defineAsyncComponent(() =>
  import("@/components/skeleton/ProductDetailsSkeleton.vue")
);

const DetailsGallery = defineAsyncComponent(() =>
  import("@/components/product/DetailsGallery.vue")
);

const SingleShop = defineAsyncComponent(() =>
  import("@/components//shop/SingleShop.vue")
);

import {
  CTabContent,
  CTabPane,
  CNav,
  CNavItem,
  CNavLink,
  CTable,
  CTableBody,
  CTableRow,
  CTableDataCell,
  CTableHeaderCell,
  CTableHead,
} from "@coreui/vue";
export default {
  name: "ProductDetails",
  components: {
    ProductDetailsSkeleton,
    GalleryImageSkeleton,
    DetailsGallery,
    PageHeader,
    DetailsContent,
    ProductReview,
    SingleProduct,
    WidgetTopCategory,
    WidgetTopSellingProduct,
    Swiper,
    SwiperSlide,
    Pagination,
    CTabContent,
    CTabPane,
    CNav,
    CNavItem,
    CNavLink,
    CTable,
    CTableBody,
    CTableRow,
    CTableDataCell,
    CTableHeaderCell,
    CTableHead,
    SingleShop,
  },
  data() {
    return {
      enums: enums,
      product: null,
      tabPaneActiveKey: 1,
      bItems: [
        {
          text: this.$t("Home"),
          href: "/",
        },
        {
          text: this.$t("Products"),
          href: "/products",
        },
      ],
      topCategories: [],
      relatedProducts: [],
      topSellingProducts: [],
      galleryKey: 1,
      sectionTitle: this.$t("Related Products"),
      productLoading: true,
    };
  },
  computed: mapState({
    site_config: (state) => state.siteSettings,
  }),
  setup() {
    return {
      modules: [Pagination],
    };
  },
  watch: {
    $route: {
      deep: true,
      handler(to, from) {
        this.tabPaneActiveKey = 1;
        this.getProductDetails();
        window.scrollTo(0, 0);
      },
    },
  },
  mounted() {
    window.addEventListener("scroll", this.scrollHandler);
    this.getProductDetails();
    this.getCategories();
    this.getTopSellingProducts();
  },
  methods: {
    /**
     * Get single product details
     */
    getProductDetails() {
      axios
        .post("/api/v1/ecommerce-core/product-details", {
          permalink: this.$route.params.id,
          preview:
            typeof this.$route.query.preview != "undefined"
              ? this.$route.query.preview
              : null,
        })
        .then((response) => {
          if (response.data.success) {
            this.getRelatedProducts(response.data.data.id);
            document.title = response.data.data.name;
            this.product = response.data.data;
            this.productLoading = false;
          } else {
            this.productLoading = false;
          }
        })
        .catch((error) => {
          this.productLoading = false;
        });
    },
    /**
     * Top selling  Products
     */
    getTopSellingProducts(id) {
      axios
        .post("/api/v1/ecommerce-core/top-selling-products")
        .then((response) => {
          this.topSellingProducts = response.data.data;
        })
        .catch((error) => {
          this.topSellingProducts = [];
        });
    },

    /**
     * Related Products
     */
    getRelatedProducts(id) {
      axios
        .post("/api/v1/ecommerce-core/related-products", {
          id: id,
        })
        .then((response) => {
          this.relatedProducts = response.data.data;
        })
        .catch((error) => {
          this.relatedProducts = [];
        });
    },
    /**
     * Get top categories
     *
     */
    getCategories() {
      axios
        .get("/api/v1/ecommerce-core/parent-categories")
        .then((response) => {
          if (response.status === 200) {
            this.topCategories = response.data.data;
          }
        })
        .catch((error) => {
          this.topCategories = [];
        });
    },
    /**
     * Color variant gallery images
     */
    colorVariantImages(color_id) {
      this.$store.dispatch("showPreloader", true);
      this.galleryKey = this.galleryKey + 1;
      axios
        .post("/api/v1/ecommerce-core/color-variant-images", {
          product_id: this.product.id,
          color_id: color_id,
        })
        .then((response) => {
          if (response.data.success) {
            this.product.galleryImages = response.data.images;
            this.$store.dispatch("showPreloader", false);
          } else {
            this.$store.dispatch("showPreloader", false);
          }
        })
        .catch((error) => {
          this.$store.dispatch("showPreloader", false);
          this.product.galleryImages = [];
        });
    },
    goSec(sec) {
      this.$nextTick(() => {
        let element = this.$refs[sec];
        let top = element.offsetTop;
        window.scrollTo(0, top - 110);
      });
    },

    scrollHandler() {
      const hashMenu = this.$refs.hashMenu;
      if (hashMenu) {
        window.pageYOffset > 450
          ? hashMenu.classList.add("active")
          : hashMenu.classList.remove("active");
      }
    },
  },
};
</script>

<style lang="scss" scoped>
@import "../../../assets/sass/00-abstracts/01-variables";

.product-details {
  padding: 30px;
  background-color: #fff;
  box-shadow: 3px 3px 30px rgb(0 0 0 / 3%);
  border: 1px solid #f7f8fa;
  @media only screen and (max-width: 575px) {
    padding: 0px 15px;
  }
}
.overview-wrap {
  background-color: #fff;
  box-shadow: 3px 3px 30px rgb(0 0 0 / 3%);
  border: 1px solid #f7f8fa;
  ul {
    li {
      &:not(:last-child) {
        margin-bottom: 5px;
      }
    }
  }
  p {
    &:not(:last-child) {
      margin-bottom: 30px;
    }
  }
  .tab-content {
    padding: 30px;
    @media only screen and (max-width: 575px) {
      padding: 0px 15px;
    }
  }
}

.product-description-tabs {
  border-bottom: none !important;

  @media only screen and (max-width: 575px) {
    flex-direction: column;
  }
  li {
    margin-bottom: 0 !important;
    a {
      color: #666666;
      font-size: 18px;
      font-weight: 700;
      padding: 11px 20px;
      line-height: 1.2;
      font-family: $title-font;
      border: none;
      position: relative;
      border-radius: 0px;
      @media only screen and (max-width: 575px) {
        text-align: center;
      }
      &:after {
        font-family: "Material Icons";
        content: "\e5cf";
        position: relative;
        top: 3px;
        left: 5px;
        font-size: 16px;
      }
      &.active {
        color: #fff;
        background-color: $c1;
        &:after {
          content: "\e5ce";
        }
      }
    }
  }
}
.info-list {
  display: flex;
  list-style: none;
  margin: 0;
  padding: 30px 0;
  background-color: #fff;
  box-shadow: 3px 3px 30px rgb(0 0 0 / 3%);
  border: 1px solid #f7f8fa;
  max-width: 100%;
  overflow-x: auto;
  @media only screen and (max-width: 1199px) {
    padding: 0;
  }
  li {
    padding: 0 30px;
    flex-grow: 1;
    &:not(:last-child) {
      border-right: 1px solid #e7eaef;
    }
    @media only screen and (max-width: 1199px) {
      padding: 15px;
      box-shadow: 3px 3px 30px rgb(0 0 0 / 3%);
      flex-grow: inherit;
      min-width: 220px;
    }
    p {
      margin-bottom: 0;
    }
    span,
    a {
      font-size: 13px;
    }
  }
}
.specification-table {
  h4 {
    font-size: 21px;
    font-weight: 500;
    margin-bottom: 16px;
  }
  .table {
    th {
      background-color: #f7f8fa;
    }
    th,
    td {
      border-color: #f7f8fa;
    }
    tr {
      &:hover {
        background-color: rgba($color: #fafafa, $alpha: 0.5);
      }
    }
  }
}

.product-details-hash-menu {
  position: fixed;
  width: 100%;
  top: 75px;
  visibility: hidden;
  opacity: 0;
  transition: all 0.3s ease;
  left: 0;
  box-shadow: 7px 7px 60px rgb(0 0 0 / 7%);
  padding: 10px 0;
  background-color: #fff;
  ul {
    list-style: none;
    margin: 0;
    padding: 0;
    display: flex;
    align-items: center;
    white-space: nowrap;
    overflow: auto;
    li {
      user-select: none;
      cursor: pointer;
      &:not(:last-child) {
        margin-right: 20px;
      }
      &.active {
        color: $c1;
      }
    }
  }
  &.active {
    top: 65px;
    visibility: visible;
    opacity: 1;
    z-index: 9;
  }
}
</style>
