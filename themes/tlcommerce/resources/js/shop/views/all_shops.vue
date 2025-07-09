<template>
  <div class="shop-page">
    <div class="pt-60 pb-60">
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
                          {{ $t("All Shops") }}
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
                            {{ totalItems }} {{ $t("Shop Found") }}
                          </p>
                          <p v-else>{{ $t("No Shop found") }}</p>
                        </div>
                      </div>
                    </div>
                    <shop-sorting-option
                      class="col-lg-6 order-0 order-lg-1 text-lg-right"
                      :data-loading="categoryLoading"
                      :selected-item="sorting_by"
                      @sorting-items="sortingItems"
                    ></shop-sorting-option>
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
            <div class="row" v-if="shopLoading">
              <div
                class="col-12 col-lg-4"
                v-for="(item, index) in shopSkeletons"
                :key="index"
              >
                <skeleton :height="item.height" class="w-100 mb-3"> </skeleton>
              </div>
            </div>
            <!--Shop List-->
            <div class="row" v-if="!shopLoading && totalItems > 0">
              <div
                class="col-12 col-lg-4"
                v-for="(shop, index) in allShops"
                :key="index"
              >
                <single-shop :shop="shop" hasBanner></single-shop>
              </div>
            </div>
            <!--No Item Found-->
            <div class="row" v-if="!shopLoading && totalItems < 1">
              <the-not-found title="No item found"></the-not-found>
            </div>

            <!--Pagination-->
            <div class="row align-items-center mt-10" v-if="!shopLoading">
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
                <pagination
                  :options="paginationOptions"
                  v-model="currentPage"
                  :records="totalItems"
                  :per-page="perPage"
                  @paginate="getAllActiveShop"
                />
                <!-- End Pagination -->
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import PageHeader from "@/components/pageheader/PageHeader.vue";
import SingleShop from "@/components/shop/SingleShop.vue";
import BrandCollapseBox from "@/components/product/BrandCollapseBox.vue";
import ShopSortingOption from "@/components/shop/ShopSortingOption.vue";
import WidgetTopCategory from "@/components/widget/WidgetTopCategory.vue";
import WidgetBrand from "@/components/widget/WidgetBrand.vue";
import WidgetRating from "@/components/widget/WidgetRating.vue";
import Pagination from "v-pagination-3";
import axios from "axios";

export default {
  name: "AllShop",
  components: {
    PageHeader,
    SingleShop,
    Pagination,
    BrandCollapseBox,
    ShopSortingOption,
    WidgetTopCategory,
    WidgetBrand,
    WidgetRating,
  },
  data() {
    return {
      pageTitle: "AllShop",
      shopLoading: false,
      paginationOptions: {
        chunk: 3,
        theme: "bootstrap4",
        hideCount: true,
      },
      shopSkeletons: [
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
      currentPage: 1,
      perPage: 15,
      allShops: [],
      totalItems: 0,
      brandLoading: true,
      categoryLoading: true,
      wToggle: false,
      sorting_by: "newest",
      categories: [],
      brands: [],
      category_filter: {},
      brand_filter: {},
      rating_filter: null,
    };
  },
  mounted() {
    this.getCategories();
    this.getBrands();
    this.getAllActiveShop();
  },

  methods: {
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
     * Get all  active shops
     */
    getAllActiveShop() {
      this.shopLoading = true;
      axios
        .post("/api/v1/multivendor/active-shop-list", {
          brand_id: this.brand_filter.id,
          category_id: this.category_filter.id,
          rating: this.rating_filter,
          sorting: this.sorting_by,
          perPage: this.perPage,
          page: this.currentPage,
        })
        .then((response) => {
          if (response.status === 200) {
            this.allShops = response.data.data;
            this.totalItems = response.data.meta.total;
          }
          this.shopLoading = false;
        })
        .catch((error) => {
          this.shopLoading = false;
        });
    },
    /**
     * Sorting all products items
     */
    sortingItems(item) {
      this.sorting_by = item;
      this.getAllActiveShop();
    },
    /**
     * Remove filter option
     */
    removeTag(item) {
      if (item === "brand") {
        this.brand_filter = {};
      } else if (item === "category") {
        this.category_filter = {};
      } else if (item === "rating") {
        this.rating_filter = null;
      }
      this.currentPage = 1;
      this.getAllActiveShop();
    },
    /**
     * Remove all filter options
     */
    removeAllTag() {
      this.category_filter = {};
      this.brand_filter = {};
      this.rating_filter = null;
      this.currentPage = 1;
      this.getAllActiveShop();
    },
    /**
     * Filter all products by brand
     */
    addBrandFilter(el) {
      this.brand_filter = el;
      this.currentPage = 1;
      this.getAllActiveShop();
    },
    /**
     * Filter all products by category
     */
    addCategoryFilter(el) {
      this.category_filter = el;
      this.currentPage = 1;
      this.getAllActiveShop();
    },
    /**
     * Filter all products by rating
     */
    addRatingFilter(el) {
      this.rating_filter = el;
      this.currentPage = 1;
      this.getAllActiveShop();
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
