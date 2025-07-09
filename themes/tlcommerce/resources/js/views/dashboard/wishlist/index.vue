<template>
  <Dashboard>
    <div class="customer-wishlist">
      <page-header class="pt-3 pb-3" whiteBg :items="bItems" />
      <template v-if="!loading">
        <div class="pt-4" v-if="tableData.length > 0">
          <div class="row">
            <div class="col-12">
              <div class="shadow-card">
                <div class="table-responsive">
                  <!-- Table -->
                  <CTable class="cart-table wishlist-table border-0 mb-0">
                    <CTableHead>
                      <CTableRow>
                        <CTableHeaderCell>{{ $t("Product") }}</CTableHeaderCell>
                        <CTableHeaderCell>{{ $t("Price") }}</CTableHeaderCell>
                        <CTableHeaderCell>{{ $t("Action") }}</CTableHeaderCell>
                        <CTableHeaderCell class="text-center">
                          {{ $t("Remove") }}
                        </CTableHeaderCell>
                      </CTableRow>
                    </CTableHead>
                    <CTableBody>
                      <template
                        v-for="(t_data, index) in tableData"
                        :key="index"
                      >
                        <single-product
                          :item="t_data"
                          wishlistStyle
                          @remove-wishlist="removeWishlist"
                        />
                      </template>
                    </CTableBody>
                  </CTable>
                </div>
              </div>
            </div>
          </div>

          <div class="row align-items-center mt-30" v-if="tableData.length > 0">
            <div class="col-md-6">
              <!-- Showing Per Page -->
              <showing-per-page
                class="text-center text-md-start"
                :total-items="totalRows"
                :current-page="currentPage"
              />
              <!-- Showing Per Page -->
            </div>
            <div class="col-md-6 col-md-6 d-flex justify-content-end">
              <!-- Pagination -->
              <pagination
                :options="paginationOptions"
                v-model="currentPage"
                :records="totalRows"
                :per-page="perPage"
                @paginate="getCustomerWishlistsProducts"
              />
              <!-- End Pagination -->
            </div>
          </div>
        </div>
        <div v-else>
          <the-not-found title="No product found in wishlist"></the-not-found>
        </div>
      </template>
      <template v-if="loading">
        <skeleton class="w-100 mb-20" height="70px"></skeleton>
        <skeleton class="w-100" height="500px"></skeleton>
      </template>
    </div>
  </Dashboard>
</template>

<script>
import PageHeader from "@/components/pageheader/PageHeader.vue";
import ShowingPerPage from "@/components/ui/ShowingPerPage.vue";
import Dashboard from "@/views/dashboard.vue";
import Pagination from "v-pagination-3";
import SingleProduct from "../../../components/product/SingleProduct.vue";
import axios from "axios";
import { mapState } from "vuex";
import {
  CTable,
  CTableBody,
  CTableRow,
  CTableDataCell,
  CTableHeaderCell,
  CTableHead,
} from "@coreui/vue";

export default {
  components: {
    PageHeader,
    ShowingPerPage,
    Dashboard,
    CTable,
    CTableBody,
    CTableRow,
    CTableDataCell,
    CTableHeaderCell,
    CTableHead,
    Pagination,
    SingleProduct,
  },
  data() {
    return {
      pageTitle: "Wishlist",
      loading: false,
      bItems: [
        {
          text: this.$t("Home"),
          href: "/",
        },
        {
          text: this.$t("Dashboard"),
          href: "/dashboard",
        },
        {
          text: this.$t("Wishlist"),
          active: true,
        },
      ],
      tableData: [],
      totalRows: 1,
      currentPage: 1,
      perPage: 5,
      paginationOptions: {
        chunk: 3,
        theme: "bootstrap4",
        hideCount: true,
      },
    };
  },
  computed: mapState({
    customerToken: (state) => state.customerToken,
  }),
  mounted() {
    document.title = this.$t("Dashboard") + " | " + this.$t("Wishlist");
    this.getCustomerWishlistsProducts();
  },
  methods: {
    /**
     * Get customer wishlists products
     */
    getCustomerWishlistsProducts() {
      this.loading = true;
      axios
        .post(
          "/api/v1/ecommerce-core/customer/get-customer-wishlist-product",
          {
            perPage: this.perPage,
            page: this.currentPage,
          },
          {
            headers: {
              Authorization: `Bearer ${this.$store.state.customerToken}`,
            },
          }
        )
        .then((response) => {
          if (response.data.success) {
            this.tableData = response.data.data;
            this.totalRows = response.data.meta.total;
            this.loading = false;
          } else {
            this.loading = false;
            this.totalRows = 0;
          }
        })
        .catch((error) => {
          this.totalRows = 0;
          this.loading = false;
        });
    },
    /**
     * Remove wishlist from list
     */
    removeWishlist() {
      this.currentPage = 1;
      this.getCustomerWishlistsProducts();
    },
  },
};
</script>
