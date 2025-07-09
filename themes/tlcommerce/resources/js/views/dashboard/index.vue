<template>
  <Dashboard>
    <div class="dashboard">
      <template v-if="!loading">
        <!--Dashboard overview-->
        <div class="row">
          <div class="col-lg-4">
            <dashboard-card
              title="Total Order"
              :counter="dashboard_content.total_order"
            ></dashboard-card>
          </div>
          <div class="col-lg-4">
            <dashboard-card
              title="Pending Orders"
              :counter="dashboard_content.total_pending_order"
            ></dashboard-card>
          </div>
          <div class="col-lg-4">
            <dashboard-card
              title="Total Purchase Amount"
              :counter="dashboard_content.total_purchase_amount"
              currency
            ></dashboard-card>
          </div>
        </div>
        <!--End dashboard overview-->
        <!--Purchase overview-->
        <div class="row">
          <div class="col-12">
            <h5 class="order-summery-title">{{ $t("Latest Purchase") }}</h5>
            <div class="table-responsive" v-if="latestPurchases.length > 0">
              <!-- Table -->
              <CTable
                class="style1 mb-0"
                :class="latestPurchases.length == 1 ? 't-mh-160' : ''"
              >
                <CTableHead>
                  <CTableRow>
                    <CTableHeaderCell>{{ $t("ID") }}</CTableHeaderCell>
                    <CTableHeaderCell>{{ $t("Order Date") }}</CTableHeaderCell>
                    <CTableHeaderCell>{{ $t("Amount") }}</CTableHeaderCell>
                    <CTableHeaderCell>{{
                      $t("Num of Products")
                    }}</CTableHeaderCell>
                    <CTableHeaderCell>{{ $t("Actions") }}</CTableHeaderCell>
                  </CTableRow>
                </CTableHead>
                <CTableBody>
                  <CTableRow v-for="tdata in latestPurchases" :key="tdata.id">
                    <CTableDataCell>
                      <router-link :to="`/dashboard/order-details/${tdata.id}`">
                        {{ tdata.order_code }}</router-link
                      >
                    </CTableDataCell>
                    <CTableDataCell>{{ tdata.order_date }}</CTableDataCell>
                    <CTableDataCell
                      ><the-currency
                        :amount="tdata.total_payable_amount"
                      ></the-currency>
                    </CTableDataCell>
                    <CTableDataCell>{{ tdata.total_products }}</CTableDataCell>
                    <CTableDataCell>
                      <CDropdown>
                        <CDropdownToggle
                          ><span class="material-icons">
                            more_vert
                          </span></CDropdownToggle
                        >
                        <CDropdownMenu>
                          <CDropdownItem>
                            <router-link
                              :to="`/dashboard/order-details/${tdata.id}`"
                              >{{ $t("Details") }}</router-link
                            >
                          </CDropdownItem>
                        </CDropdownMenu>
                      </CDropdown>
                    </CTableDataCell>
                  </CTableRow>
                </CTableBody>
              </CTable>
            </div>
            <div v-else>
              <the-not-found title="No item found to display"></the-not-found>
            </div>
          </div>
        </div>
        <!--End purchase overview-->
      </template>
      <template v-if="loading">
        <div class="d-flex gap-5 justify-content-between">
          <skeleton class="w-25 mb-20" height="90px"></skeleton>
          <skeleton class="w-25 mb-20" height="90px"></skeleton>
          <skeleton class="w-25 mb-20" height="90px"></skeleton>
        </div>
        <skeleton class="w-100" height="500px"></skeleton>
      </template>
    </div>
  </Dashboard>
</template>

<script>
import Dashboard from "@/views/dashboard.vue";
import DashboardCard from "../../components/ui/DashboardCard.vue";
import axios from "axios";
import { mapState } from "vuex";
import {
  CTable,
  CTableBody,
  CTableRow,
  CTableDataCell,
  CTableHeaderCell,
  CTableHead,
  CDropdown,
  CDropdownToggle,
  CDropdownMenu,
  CDropdownItem,
  CPagination,
  CPaginationItem,
} from "@coreui/vue";
export default {
  data() {
    return {
      loading: false,
      pageTitle: "Dashboard",
      bItems: [
        {
          text: this.$t("Home"),
          href: "/",
        },
        {
          text: this.$t("Dashboard"),
          active: true,
        },
      ],
      latestPurchases: [],
      dashboard_content: {},
    };
  },
  components: {
    Dashboard,
    DashboardCard,
    CTable,
    CTableBody,
    CTableRow,
    CTableDataCell,
    CTableHeaderCell,
    CTableHead,
    CDropdown,
    CDropdownToggle,
    CDropdownMenu,
    CDropdownItem,
    CPagination,
    CPaginationItem,
  },
  computed: mapState({
    customerToken: (state) => state.customerToken,
  }),
  mounted() {
    document.title = this.$t("Dashboard");
    this.getCustomerDashboardContent();
  },
  methods: {
    /**
     * Get customer dashboard content
     */
    getCustomerDashboardContent() {
      this.loading = true;
      axios
        .get("/api/v1/ecommerce-core/customer/customer-dashboard", {
          headers: {
            Authorization: `Bearer ${this.customerToken}`,
          },
        })
        .then((response) => {
          if (response.data.success) {
            this.dashboard_content = response.data.dasboard_content;
            this.latestPurchases = response.data.latest_purchases.data;
            this.loading = false;
          } else {
            this.loading = false;
          }
        })
        .catch((error) => {
          this.loading = false;
        });
    },
  },
};
</script>

