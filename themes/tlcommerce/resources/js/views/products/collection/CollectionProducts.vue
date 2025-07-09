<template>
  <div class="">
    <page-header :items="bItems" />
    <div class="pb-60 light-bg">
      <template v-if="!loadingDetails">
        <template v-if="collectionDetails != null">
          <div
            class="flash-deals-banner p-0"
            v-if="collectionDetails.image != null"
          >
            <div class="text-center">
              <img
                :src="collectionDetails.image"
                :alt="collectionDetails.name"
              />
            </div>
          </div>
          <div class="flash-deals-countdown mb-60">
            <div class="custom-container2 py-2">
              <div class="row align-items-center">
                <div class="col-md-5">
                  <h3 class="mb-md-0">
                    {{ collectionDetails.name }}
                  </h3>
                </div>
                <div class="col-md-7"></div>
              </div>
            </div>
          </div>
        </template>
      </template>
      <template v-if="loadingDetails">
        <skeleton class="w-100 mb-20" height="250px"></skeleton>
      </template>

      <div class="custom-container2" v-if="!loadingProducts">
        <div class="row mobile-gap-10">
          <div
            v-for="product in paginatedItems"
            :key="product.id"
            class="col-lg-2 col-md-3 col-6"
          >
            <single-product :item="product" styleEight />
          </div>
        </div>
        <div class="row align-items-center mt-10" v-if="!loadingProducts">
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
              @paginate="getProducts"
            />
            <!-- End Pagination -->
          </div>
        </div>
      </div>
      <div class="custom-container2" v-if="loadingProducts">
        <div class="row mobile-gap-10">
          <div
            class="col-lg-2 col-md-3 col-6"
            v-for="(item, index) in productSkeletons"
            :key="index"
          >
            <skeleton :height="item.height" class="w-100 mb-10"> </skeleton>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import PageHeader from "@/components/pageheader/PageHeader.vue";
import SingleProduct from "@/components/product/SingleProduct.vue";
import ShowingPerPage from "@/components/ui/ShowingPerPage.vue";
import Pagination from "v-pagination-3";
import axios from "axios";
export default {
  name: "CollectionProducts",
  components: {
    PageHeader,
    SingleProduct,
    ShowingPerPage,
    Pagination,
  },
  data() {
    return {
      wToggle: false,
      bItems: [
        {
          text: this.$t("Home"),
          href: "/",
        },
        {
          text: this.$t("Collection"),
          active: true,
        },
      ],
      currentPage: 1,
      perPage:
        this.$store.state.siteSettings != null
          ? this.$store.state.siteSettings.product_per_page
          : 18,
      loadingDetails: true,
      loadingProducts: true,
      collectionDetails: null,
      paginatedItems: [],
      totalItems: 0,
      showFull: false,
      success: false,
      loading: false,
      paginationOptions: {
        chunk: 3,
        theme: "bootstrap4",
        hideCount: true,
      },
      productSkeletons: [
        {
          height: "370px",
        },
        {
          height: "370px",
        },
        {
          height: "370px",
        },
        {
          height: "370px",
        },
        {
          height: "370px",
        },
        {
          height: "370px",
        },
      ],
    };
  },
  mounted() {
    this.getCollectionDetails();
    this.getProducts();
  },
  methods: {
    /**
     * Will get collection details
     */
    getCollectionDetails() {
      window.scrollTo(0, 0);
      axios
        .post("/api/theme/tlcommerce/v1/collection-details", {
          id: this.$route.params.id,
        })
        .then((response) => {
          if (response.data.success) {
            this.collectionDetails = response.data.details;
          }
          this.loadingDetails = false;
        })
        .catch((error) => {
          this.loadingDetails = false;
        });
    },
    /**
     * Will get products
     */
    getProducts() {
      window.scrollTo(0, 0);
      axios
        .post("/api/theme/tlcommerce/v1/collection-all-products", {
          perPage: this.perPage,
          page: this.currentPage,
          id: this.$route.params.id,
        })
        .then((response) => {
          if (response.data.success) {
            this.paginatedItems = response.data.data;
            this.totalItems = response.data.meta.total;
          }
          this.loadingProducts = false;
        })
        .catch((error) => {
          this.loadingProducts = false;
        });
    },
  },
};
</script>
