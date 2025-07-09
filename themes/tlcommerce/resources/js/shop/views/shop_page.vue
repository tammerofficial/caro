<template>
  <div class="shop-page" v-if="shop_found">
    <!--Shop Header-->
    <div lass="shop-header-preloader" v-if="loadingDetails">
      <skeleton class="w-100" height="100px"></skeleton>
    </div>
    <div class="shop-header" v-if="!loadingDetails && shopDetails != null">
      <div class="custom-container2">
        <div class="row">
          <div class="col-12">
            <div class="align-items-center shop-header-inner">
              <div class="align-items-center d-flex gap-3 shop-brand">
                <img
                  v-if="shopDetails.logo != null"
                  :src="shopDetails.logo"
                  :alt="shopDetails.name"
                  class="img-70"
                />
                <h3 class="shop-title m-0">{{ shopDetails.name }}</h3>
              </div>

              <div class="d-flex gap-4 right-side align-items-center flex-wrap">
                <div class="shop-statistic">
                  <div
                    class="shop-rating"
                    v-if="
                      reviewSummary != null &&
                      reviewSummary.positive_ratings > 0
                    "
                  >
                    <strong class="c1"
                      >{{ reviewSummary.positive_ratings }}%</strong
                    >
                    {{ $t("Positive Seller Ratings") }}
                  </div>
                  <div class="shop-rating" v-else>
                    {{ $t("No feedback") }}
                  </div>

                  <div class="followers-qt">
                    {{ shopDetails.total_followers }}
                    {{
                      shopDetails.total_followers > 1
                        ? $t("Followers")
                        : $t("Follower")
                    }}
                  </div>
                </div>

                <div class="mt-n1">
                  <router-link
                    to="#"
                    class="btn mt-1"
                    @click.prevent="storeFollower()"
                  >
                    <span class="material-icons me-2"> add </span>
                    <span>{{ $t("Follow") }}</span>
                  </router-link>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!--End Shop Header-->

    <!--Shop Banner-->
    <div
      class="shop-banner"
      v-if="!loadingDetails && shopDetails.shop_banner != null"
    >
      <img :src="shopDetails.shop_banner" :alt="shopDetails.name" />
    </div>
    <div lass="shop-banner-preloader" v-if="loadingDetails">
      <skeleton class="w-100 mt-1" height="200px"></skeleton>
    </div>
    <!--End Shop Banner-->
    <!--Shop Navbar-->
    <div class="shop-navbar" v-if="!loadingDetails">
      <div class="custom-container2 position-relative">
        <div class="row align-items-center">
          <div class="col-xl-8 col-lg-7 col-md-6 col-10">
            <div class="shop-navigar">
              <nav>
                <a
                  href="#"
                  :class="{ active: homePage }"
                  @click.prevent="goHome()"
                  >{{ $t("Home") }}</a
                >
                <a
                  href="#"
                  :class="{ active: allProductPage }"
                  @click.prevent="goAllProducts()"
                  >{{ $t("All Products") }}</a
                >
                <a
                  href="#"
                  :class="{ active: reviewPage }"
                  @click.prevent="goReviews()"
                  >{{ $t("Reviews") }}</a
                >
              </nav>
            </div>
          </div>

          <div class="col-xl-4 col-lg-5 col-md-6 col-2">
            <div class="shop-search d-none d-md-block">
              <!-- Search Form -->
              <search-form styleFour />
              <!-- End Search Form -->
            </div>
            <div class="shop-search-mobile d-md-none">
              <!-- Shop Mobile Search Form -->
              <ShopMobileSearch />
              <!-- End Shop Mobile Search Form -->
            </div>
          </div>
        </div>
      </div>
    </div>
    <!--End Shop Navbar-->
    <!--Home Page-->
    <div class="pt-60 pb-60" v-if="homePage">
      <div class="custom-container2">
        <div class="row">
          <div class="col-12" v-if="!loadingProducts">
            <!-- New Items -->
            <section class="pb-50" v-if="newItems.length">
              <div class="custom-container2">
                <div class="row align-items-center">
                  <div class="col-md-6">
                    <section-title class="mb-30" title="New Items" />
                  </div>
                </div>
                <swiper
                  v-if="newItems.length"
                  :slidesPerView="6"
                  :modules="modules"
                  :spaceBetween="1"
                  :autoplay="{
                    delay: 2500,
                    disableOnInteraction: false,
                    pauseOnMouseEnter: true,
                  }"
                  :loop="true"
                  :pagination="{
                    clickable: true,
                  }"
                  class="product-grid-slider theme-slider-dots"
                  :breakpoints="{
                    '0': {
                      slidesPerView: 2,
                    },
                    '768': {
                      slidesPerView: 3,
                    },
                    '1024': {
                      slidesPerView: 5,
                    },
                  }"
                >
                  <swiper-slide
                    v-for="(item, index) in newItems"
                    :key="`slide-${index}`"
                  >
                    <single-product :item="item" styleEight />
                  </swiper-slide>
                </swiper>
                <the-not-found title="No item found" v-else></the-not-found>
              </div>
            </section>
            <section v-else>
              <div class="text-center">
                <h2>{{ $t("No Product Found") }}</h2>
                <p>
                  {{ $t("There are currently no products for this seller") }}
                </p>
              </div>
            </section>
            <!-- End New Items -->

            <!-- Top Selling Items -->
            <section class="pb-50" v-if="topSellingItems.length">
              <div class="custom-container2">
                <div class="row align-items-center">
                  <div class="col-md-6">
                    <section-title class="mb-30" title="Top Selling Items" />
                  </div>
                </div>
                <swiper
                  v-if="topSellingItems.length"
                  :slidesPerView="6"
                  :modules="modules"
                  :spaceBetween="1"
                  :autoplay="{
                    delay: 2500,
                    disableOnInteraction: false,
                    pauseOnMouseEnter: true,
                  }"
                  :loop="true"
                  :pagination="{
                    clickable: true,
                  }"
                  class="product-grid-slider theme-slider-dots"
                  :breakpoints="{
                    '0': {
                      slidesPerView: 2,
                    },
                    '768': {
                      slidesPerView: 3,
                    },
                    '1024': {
                      slidesPerView: 5,
                    },
                  }"
                >
                  <swiper-slide
                    v-for="(item, index) in topSellingItems"
                    :key="`slide-${index}`"
                  >
                    <single-product :item="item" styleEight />
                  </swiper-slide>
                </swiper>
                <the-not-found title="No item found" v-else></the-not-found>
              </div>
            </section>
            <!-- End Top Selling Items -->

            <!-- Top Featured Items -->
            <section
              class="shop-featured-item list"
              v-if="featuredItems.length"
            >
              <div class="custom-container2">
                <div class="row align-items-center">
                  <div class="col-md-6">
                    <section-title class="mb-30" title="Featured Items" />
                  </div>
                </div>
                <swiper
                  v-if="featuredItems.length"
                  :slidesPerView="6"
                  :modules="modules"
                  :spaceBetween="1"
                  :autoplay="{
                    delay: 2500,
                    disableOnInteraction: false,
                    pauseOnMouseEnter: true,
                  }"
                  :loop="true"
                  :pagination="{
                    clickable: true,
                  }"
                  class="product-grid-slider theme-slider-dots"
                  :breakpoints="{
                    '0': {
                      slidesPerView: 2,
                    },
                    '768': {
                      slidesPerView: 3,
                    },
                    '1024': {
                      slidesPerView: 5,
                    },
                  }"
                >
                  <swiper-slide
                    v-for="(item, index) in featuredItems"
                    :key="`slide-${index}`"
                  >
                    <single-product :item="item" styleEight />
                  </swiper-slide>
                </swiper>
                <the-not-found title="No item found" v-else></the-not-found>
              </div>
            </section>
            <!-- End Top Featured Items -->
          </div>
          <div class="col-12" v-if="loadingProducts">
            <div class="row">
              <div
                class="col-2 p-1px"
                v-for="(item, index) in productSkeletons"
                :key="index"
              >
                <skeleton :height="item.height" class="w-100 mb-3"> </skeleton>
                <skeleton height="13px" class="w-75 mb-1 rounded-5"> </skeleton>
                <skeleton height="14px" class="w-100 mb-1 rounded-5">
                </skeleton>
                <skeleton height="13px" class="w-75 rounded-5"> </skeleton>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!--End Home Page-->
    <!--All Products Page-->
    <div class="pt-60 pb-60" v-if="allProductPage">
      <div class="custom-container2">
        <div class="row">
          <div class="col-lg-3">
            <div class="widget_wrap" :class="{ active: wToggle }">
              <button
                class="close-btn btn-circle d-lg-none"
                @click.prevent="wToggle = !wToggle"
              >
                <span class="material-icons"> close </span>
              </button>
              <div class="widget_wrap-inner">
                <WidgetTopCategory
                  v-if="!categoryLoading"
                  :categories="categories"
                  :selected-cat="category_filter"
                  @filter="addCategoryFilter"
                />
                <div
                  v-if="categoryLoading"
                  class="widget widget-style-1 widget_top_category mb-4"
                >
                  <skeleton height="300px"></skeleton>
                </div>
                <WidgetBrand
                  v-if="!brandLoading"
                  :brands="brands"
                  :selected-brand="brand_filter"
                  @filter="addBrandFilter"
                />
                <div
                  v-if="brandLoading"
                  class="widget widget-style-1 widget_top_category mb-4"
                >
                  <skeleton height="300px"></skeleton>
                </div>
                <WidgetRating
                  :selected-item="rating_filter"
                  @filter="addRatingFilter"
                />
                <WidgetPrice
                  :selected-option="price_filter"
                  @filter="addPriceFilter"
                />
              </div>
            </div>
          </div>
          <div class="col-lg-9">
            <!--Product Section Head-->
            <div class="row">
              <div class="col-12">
                <div class="mb-40 shadow-card">
                  <div class="row">
                    <div class="col-lg-6 order-1 order-lg-0 col-xl-6">
                      <div class="section-header">
                        <h3 class="product_header" v-if="!categoryLoading">
                          {{ $t("Products") }}
                        </h3>
                        <h3 class="product_header" v-if="categoryLoading">
                          <skeleton
                            border-radius="5px"
                            width="150px"
                            height="30px"
                          ></skeleton>
                        </h3>
                        <div v-if="categoryLoading">
                          <p class="mt-1">
                            <skeleton
                              border-radius="5px"
                              width="50px"
                              height="10px"
                            ></skeleton>
                          </p>
                        </div>
                        <div v-if="!categoryLoading">
                          <p v-if="totalItems > 0">
                            {{ totalItems }} {{ $t("items found") }}
                          </p>
                          <p v-else>{{ $t("No item found") }}</p>
                        </div>
                      </div>
                    </div>
                    <sorting-option
                      class="col-lg-6 order-0 order-lg-1 text-lg-right"
                      :data-loading="categoryLoading"
                      :selected-item="sorting_by"
                      @sorting-items="sortingItems"
                      @filter-toggle="wToggle = !wToggle"
                    ></sorting-option>
                  </div>
                  <!-- Brand Collapse Box -->
                  <brand-collapse-box
                    :brands="brands"
                    :brand-loading="brandLoading"
                    @select-brand="addBrandFilter"
                    v-if="!brandLoading && brands.length > 0"
                  ></brand-collapse-box>
                  <!-- End Brand Collapse Box -->
                  <!--Filter items-->
                  <div
                    class="filter-tag-wrap"
                    v-if="
                      brand_filter.id ||
                      category_filter.id ||
                      price_filter.max ||
                      rating_filter != null
                    "
                  >
                    <div class="filter-tags">
                      <h6 class="filtered-by mb-0">{{ $t("Filtered By") }}:</h6>

                      <div class="ant-tag" v-if="brand_filter.id">
                        <span class="ant-tag-text">{{
                          brand_filter.name
                        }}</span>
                        <span
                          class="material-icons"
                          @click.prevent="removeTag('brand')"
                          >close</span
                        >
                      </div>
                      <div class="ant-tag" v-if="category_filter.id">
                        <span class="ant-tag-text">{{
                          category_filter.name
                        }}</span>
                        <span
                          class="material-icons"
                          @click.prevent="removeTag('category')"
                          >close</span
                        >
                      </div>
                      <div class="ant-tag" v-if="rating_filter != null">
                        <span class="ant-tag-text"
                          >{{ rating_filter }} Star</span
                        >
                        <span
                          class="material-icons"
                          @click.prevent="removeTag('rating')"
                          >close</span
                        >
                      </div>
                      <div class="ant-tag" v-if="price_filter.max">
                        <span class="ant-tag-text">
                          <the-currency
                            :amount="price_filter.min"
                          ></the-currency
                          >-
                          <the-currency
                            :amount="price_filter.max"
                          ></the-currency>
                        </span>
                        <span
                          class="material-icons"
                          @click.prevent="removeTag('price')"
                          >close</span
                        >
                      </div>

                      <span class="clear-all" @click.prevent="removeAllTag">{{
                        $t("CLEAR ALL")
                      }}</span>
                    </div>
                  </div>
                  <!--End filter items-->
                </div>
              </div>
            </div>
            <!--End Product Section Head-->
            <!--Preloader-->
            <div class="row mobile-gap-10" v-if="productsLoading">
              <div
                class="col-lg-3 col-6"
                v-for="(item, index) in productSkeletons"
                :key="index"
              >
                <skeleton :height="item.height" class="w-100 mb-10"> </skeleton>
              </div>
            </div>

            <!--Product List-->
            <div
              class="row mobile-gap-10"
              v-if="!productsLoading && totalItems > 0"
            >
              <div
                v-for="product in shopAllProducts"
                :key="product.id"
                class="col-lg-3 col-6"
              >
                <single-product :item="product" styleEight />
              </div>
            </div>
            <!--No item found-->
            <div v-if="!productsLoading && totalItems < 1">
              <the-not-found title="No item found"></the-not-found>
            </div>
            <!--End Product List-->
            <div class="row align-items-center mt-10" v-if="!productsLoading">
              <div class="col-md-6">
                <!-- Showing Per Page -->
                <ShowingPerPage
                  class="text-center text-md-start"
                  :items-per-page="perPage"
                  :total-items="totalItems"
                  :current-page="currentPage"
                />
                <!-- Showing Per Page -->
              </div>
              <div
                class="col-md-6 d-flex justify-content-center justify-content-md-end mt-3 mt-md-0"
              >
                <!-- Pagination -->
                <v-pagination
                  :options="paginationOptions"
                  v-model="currentPage"
                  :records="totalItems"
                  :per-page="perPage"
                  @paginate="getShopAllProducts"
                />
                <!-- End Pagination -->
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!--End All  Products Page-->
    <!--Reviews Page-->
    <div class="pt-60 pb-60" v-if="reviewPage">
      <div class="custom-container2">
        <div class="row" v-if="reviewSummary != null">
          <div class="col-lg-12">
            <div class="shadow-card">
              <h3 class="mb-4 pb-3 border-bottom">
                {{ $t("Seller Ratings") }}
              </h3>
              <div class="d-flex flex-wrap">
                <div class="seller-review mb-4 mb-md-0 me-md-5">
                  <div class="summary">
                    <div class="score">
                      <span class="score-average">{{
                        reviewSummary.avg_review
                      }}</span
                      ><span class="score-max">/5</span>
                    </div>
                    <div class="average">
                      <div class="container-star">
                        <div class="star-rating">
                          <div class="product-rating-wrapper">
                            <i
                              class="fs-34"
                              :data-star="reviewSummary.avg_review"
                              :title="reviewSummary.avg_review"
                            ></i>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="count">
                      {{ reviewSummary.total_reviews }}
                      {{ $t("Ratings") }}
                    </div>
                  </div>
                </div>
                <div class="seller-ratings">
                  <ul class="list-unstyled mb-0">
                    <li>
                      <div class="container-star">
                        <span v-for="i in 5" :key="i" class="material-icons">
                          star
                        </span>
                      </div>
                      <span class="progress-wrap">
                        <div class="pdp-review-progress">
                          <div
                            class="bar"
                            :style="{ width: five_star_length + '%' }"
                          ></div>
                        </div>
                      </span>
                      <span class="percent"> {{ reviewSummary.five }}</span>
                    </li>
                    <li>
                      <div class="container-star">
                        <span
                          v-for="i in 5"
                          :key="i"
                          class="material-icons"
                          :class="{ disable: i === 5 || i === 5 }"
                        >
                          star
                        </span>
                      </div>
                      <span class="progress-wrap">
                        <div class="pdp-review-progress">
                          <div
                            class="bar"
                            :style="{ width: four_star_length + '%' }"
                          ></div>
                        </div>
                      </span>
                      <span class="percent">
                        {{ reviewSummary.four }}
                      </span>
                    </li>
                    <li>
                      <div class="container-star">
                        <span
                          v-for="i in 5"
                          :key="i"
                          class="material-icons"
                          :class="{ disable: i === 5 || i === 4 }"
                        >
                          star
                        </span>
                      </div>
                      <span class="progress-wrap">
                        <div class="pdp-review-progress">
                          <div
                            class="bar"
                            :style="{ width: three_star_length + '%' }"
                          ></div>
                        </div>
                      </span>
                      <span class="percent">
                        {{ reviewSummary.three }}
                      </span>
                    </li>
                    <li>
                      <div class="container-star">
                        <span
                          v-for="i in 5"
                          :key="i"
                          class="material-icons"
                          :class="{ disable: i === 5 || i === 4 || i === 3 }"
                        >
                          star
                        </span>
                      </div>
                      <span class="progress-wrap">
                        <div class="pdp-review-progress">
                          <div
                            class="bar"
                            :style="{ width: two_star_length + '%' }"
                          ></div>
                        </div>
                      </span>
                      <span class="percent">
                        {{ reviewSummary.two }}
                      </span>
                    </li>
                    <li>
                      <div class="container-star">
                        <span
                          v-for="i in 5"
                          :key="i"
                          class="material-icons"
                          :class="{
                            disable: i === 5 || i === 4 || i === 3 || i === 2,
                          }"
                        >
                          star
                        </span>
                      </div>
                      <span class="progress-wrap">
                        <div class="pdp-review-progress">
                          <div
                            class="bar"
                            :style="{ width: one_star_length + '%' }"
                          ></div>
                        </div>
                      </span>
                      <span class="percent">
                        {{ reviewSummary.one }}
                      </span>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="row" v-if="reviewSummary.total_reviews > 0">
          <div class="col-12">
            <SellerReview :shop="slug" :config="site_config" styleTwo />
          </div>
        </div>
        <div class="m-0 mt-4 row" v-else>
          <div class="no-review-wrapper py-5 shadow-card text-center">
            <h2>{{ $t("No Review Yet") }}</h2>
            <p>
              {{
                $t("There are currently no ratings or reviews for this seller")
              }}
            </p>
          </div>
        </div>
      </div>
    </div>
    <!--End Reviews Page-->
  </div>
  <the-not-found
    title="Shop not found"
    class="mt-3 py-2 text-center"
    v-else
  ></the-not-found>
</template>

<script>
import { mapState } from "vuex";
import PageHeader from "@/components/pageheader/PageHeader.vue";
import SearchForm from "@/components/ui/SearchForm.vue";
import ShopMobileSearch from "@/components/ui/ShopMobileSearch.vue";
import SingleProduct from "@/components/product/SingleProduct.vue";
import BrandCollapseBox from "@/components/product/BrandCollapseBox.vue";
import SortingOption from "@/components/product/SortingOption.vue";
import WidgetTopCategory from "@/components/widget/WidgetTopCategory.vue";
import WidgetBrand from "@/components/widget/WidgetBrand.vue";
import WidgetRating from "@/components/widget/WidgetRating.vue";
import WidgetPrice from "@/components/widget/WidgetPrice.vue";
import SellerReview from "@/components/shop/SellerReviews.vue";
import { Swiper, SwiperSlide } from "swiper/vue";
import { Pagination } from "swiper";
import VPagination from "v-pagination-3";
import axios from "axios";

export default {
  name: "Shop",
  components: {
    PageHeader,
    Swiper,
    SwiperSlide,
    Pagination,
    SingleProduct,
    BrandCollapseBox,
    SortingOption,
    WidgetTopCategory,
    WidgetBrand,
    WidgetRating,
    WidgetPrice,
    VPagination,
    SellerReview,
    SearchForm,
    ShopMobileSearch,
  },
  setup() {
    return {
      modules: [Pagination],
    };
  },
  computed: mapState({
    customerToken: (state) => state.customerToken,
    isCustomerLogin: (state) => state.isCustomerLogin,
    site_config: (state) => state.siteSettings,
    five_star_length() {
      return (this.reviewSummary.five * 100) / this.reviewSummary.total_reviews;
    },
    four_star_length() {
      return (this.reviewSummary.four * 100) / this.reviewSummary.total_reviews;
    },
    three_star_length() {
      return (
        (this.reviewSummary.three * 100) / this.reviewSummary.total_reviews
      );
    },
    two_star_length() {
      return (this.reviewSummary.two * 100) / this.reviewSummary.total_reviews;
    },
    one_star_length() {
      return (this.reviewSummary.one * 100) / this.reviewSummary.total_reviews;
    },
  }),
  data() {
    return {
      pageTitle: "Shop",
      slug: this.$route.params.slug,
      newItems: [],
      topSellingItems: [],
      featuredItems: [],
      shopDetails: {},
      shop_found: true,
      reviewSummary: {},
      loadingProducts: true,
      productsLoading: false,
      loadingDetails: false,
      homePage: true,
      allProductPage: false,
      reviewPage: false,
      paginationOptions: {
        chunk: 3,
        theme: "bootstrap4",
        hideCount: true,
      },
      productSkeletons: [
        {
          height: "260px",
        },
        {
          height: "260px",
        },
        {
          height: "260px",
        },
        {
          height: "260px",
        },
        {
          height: "260px",
        },
        {
          height: "260px",
        },
      ],
      //Product section
      brandLoading: true,
      categoryLoading: true,
      wToggle: false,
      currentPage: 1,
      perPage:
        this.$store.state.siteSettings != null
          ? parseInt(this.$store.state.siteSettings.product_per_page)
          : 18,
      shopAllProducts: [],
      totalItems: 0,
      sorting_by: "newest",
      categories: [],
      brands: [],
      category_filter: {},
      brand_filter: {},
      price_filter: {},
      rating_filter: null,
    };
  },
  mounted() {
    this.getShopInfo();
  },

  methods: {
    /**
     * Get deals Info
     */
    getShopInfo() {
      window.scrollTo(0, 0);
      this.loadingDetails = true;
      axios
        .post("/api/v1/multivendor/seller-shop-details", {
          slug: this.$route.params.slug,
        })
        .then((response) => {
          if (response.data.success) {
            this.shopDetails = response.data.details;
            this.reviewSummary = response.data.review_summary;
            document.title = response.data.details.name;
            this.shop_found = true;
            this.getProducts();
          } else {
            this.shop_found = false;
          }

          this.loadingDetails = false;
        })
        .catch((error) => {
          this.shop_found = false;
          this.loadingDetails = false;
        });
    },
    /**
     * Get products
     */
    getProducts() {
      this.$store.dispatch("showPreloader", true);
      this.loadingProducts = true;
      axios
        .post("/api/v1/multivendor/shop-products", {
          slug: this.$route.params.slug,
        })
        .then((response) => {
          if (response.status == 200) {
            this.newItems = response.data.new_items.data;
            this.featuredItems = response.data.featured_items.data;
            this.topSellingItems = response.data.top_selling_items.data;
          }
          this.$store.dispatch("showPreloader", false);
          this.loadingProducts = false;
        })
        .catch((error) => {
          this.$store.dispatch("showPreloader", false);
          this.loadingProducts = false;
        });
    },
    /**
     * Visible Home tab
     */
    goHome() {
      this.homePage = true;
      this.allProductPage = false;
      this.reviewPage = false;
    },
    /**
     * Visible reviews tab
     */
    goReviews() {
      this.homePage = false;
      this.allProductPage = false;
      this.reviewPage = true;
    },
    /**
     * Visible All Products tab
     */
    goAllProducts() {
      this.homePage = false;
      this.allProductPage = true;
      this.reviewPage = false;

      this.getCategories();
      this.getBrands();
      this.getShopAllProducts();
    },

    /**
     * Get all shop products
     */
    getShopAllProducts() {
      this.$store.dispatch("showPreloader", true);
      this.productsLoading = true;
      axios
        .post("/api/v1/multivendor/shop-all-products", {
          perPage: this.perPage,
          page: this.currentPage,
          brand_id: this.brand_filter.id,
          category_id: this.category_filter.id,
          min_price: this.price_filter.min,
          max_price: this.price_filter.max,
          rating: this.rating_filter,
          sorting: this.sorting_by,
          slug: this.$route.params.slug,
        })
        .then((response) => {
          if (response.status === 200) {
            this.shopAllProducts = response.data.data;
            this.totalItems = response.data.meta.total;
          }
          this.$store.dispatch("showPreloader", false);
          this.productsLoading = false;
        })
        .catch((error) => {
          this.productsLoading = false;
          this.$store.dispatch("showPreloader", false);
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
            this.categories = response.data.data;
            this.categoryLoading = false;
          }
        })
        .catch((error) => {
          this.categoryLoading = false;
        });
    },
    /**
     * Get Top brands
     */
    getBrands() {
      axios
        .get("/api/v1/ecommerce-core/brands")
        .then((response) => {
          if (response.status === 200) {
            this.brands = response.data.data;
            this.brandLoading = false;
          }
        })
        .catch((error) => {
          this.brandLoading = false;
        });
    },
    /**
     * Sorting all products items
     */
    sortingItems(item) {
      this.sorting_by = item;
      this.getShopAllProducts();
    },
    /**
     * Remove filter option
     */
    removeTag(item) {
      if (item === "brand") {
        this.brand_filter = {};
      } else if (item === "category") {
        this.category_filter = {};
      } else if (item === "price") {
        this.price_filter = {};
      } else if (item === "rating") {
        this.rating_filter = null;
      }
      this.currentPage = 1;
      this.getShopAllProducts();
    },
    /**
     * Remove all filter options
     */
    removeAllTag() {
      this.category_filter = {};
      this.brand_filter = {};
      this.price_filter = {};
      this.rating_filter = null;
      this.currentPage = 1;
      this.getShopAllProducts();
    },
    /**
     * Filter all products by brand
     */
    addBrandFilter(el) {
      this.brand_filter = el;
      this.currentPage = 1;
      this.getShopAllProducts();
    },
    /**
     * Filter all products by category
     */
    addCategoryFilter(el) {
      this.category_filter = el;
      this.currentPage = 1;
      this.getShopAllProducts();
    },
    /**
     * Filter all products by price
     */
    addPriceFilter(el) {
      this.price_filter = el;
      this.currentPage = 1;
      this.getShopAllProducts();
    },
    /**
     * Filter all products by rating
     */
    addRatingFilter(el) {
      this.rating_filter = el;
      this.currentPage = 1;
      this.getShopAllProducts();
    },
    /**
     * Will store new follower
     */
    storeFollower() {
      if (this.isCustomerLogin) {
        axios
          .post(
            "/api/v1/multivendor/store-shop-follower",
            {
              slug: this.$route.params.slug,
            },
            {
              headers: {
                Authorization: `Bearer ${this.customerToken}`,
              },
            }
          )
          .then((response) => {
            if (response.data.success) {
              if (response.data.duplicate) {
                this.$toast.info(this.$t("Already follow the seller"));
              } else {
                this.$toast.success(this.$t("Shop followed successfully"));
              }
            } else {
              this.$toast.error(
                this.$t("Something went wrong. Please try again")
              );
            }
          })
          .catch((error) => {
            this.$toast.error(this.$t("Something went wrong"));
          });
      } else {
        this.$toast.error("Please login");
        this.$router.push("/login");
      }
    },
  },
};
</script>
<style lang="scss" scoped>
.p-1px {
  padding: 1px !important;
}
.fs-34 {
  font-size: 34px;
}
</style>
