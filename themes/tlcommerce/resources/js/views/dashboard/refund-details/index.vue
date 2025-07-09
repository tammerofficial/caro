<template>
  <Dashboard>
    <page-header class="py-3 mb-3" whiteBg :items="bItems" />
    <template v-if="!loading">
      <div class="order_details" v-if="orderDetails != NULL">
        <!--Refund details header-->
        <div class="shadow-card mb-3 p-3">
          <div class="row">
            <div class="col-12 col-lg-6 mb-lg-0 mb-md-2">
              <h6>{{ $t("Refund ID") }} : {{ orderDetails.refund_code }}</h6>
              <p class="breadcrumb-item active">
                {{ $t("Returned on") }} {{ orderDetails.refund_date }}
              </p>
            </div>
            <div
              class="align-items-center col-12 col-lg-6 d-flex justify-content-lg-end"
            >
              <h6
                v-if="
                  orderDetails.current_payment_status !=
                  enums.return_request_payment_status.REFUNDED
                "
              >
                {{ $t("Total") }} :
                <the-currency
                  :amount="orderDetails.total_amount"
                ></the-currency>
              </h6>
              <h6 v-else>
                {{ $t("REFUND AMOUNT") }} :
                <the-currency
                  :amount="orderDetails.refunded_amount"
                ></the-currency>
              </h6>
            </div>
          </div>
        </div>
        <!--End Refund details header-->
        <!--Product list-->
        <div class="row">
          <div class="col-12">
            <div class="shadow-card mb-30 p-0">
              <div
                class="border-bottom d-flex justify-content-between p-3 pb-2"
              >
                <h5>
                  {{ $t("Details") }}
                </h5>
              </div>
              <div class="p-0 p-lg-3 py-3">
                <div class="row px-12">
                  <!--Status-->
                  <div class="col-md-12 mb-20">
                    <div class="order-info d-flex justify-content-between">
                      <div class="delivery-time">
                        <span>
                          {{ $t("Return") }}:
                          <span
                            class="status-text text-capitalize"
                            :class="orderDetails.return_status"
                            >{{ orderDetails.return_status }}</span
                          >
                        </span>
                      </div>
                      <div class="delivery-time">
                        <span :class="orderDetails.payment_status">
                          {{ $t("Payment") }}:
                          <span
                            class="status-text text-capitalize"
                            :class="orderDetails.payment_status"
                          >
                            {{ orderDetails.payment_status }}
                          </span>
                        </span>
                      </div>
                    </div>
                  </div>
                  <!--End Status-->
                  <!--Order status and tracking history-->
                  <div class="col-12">
                    <div class="d-none d-lg-block">
                      <order-steps
                        v-if="
                          orderDetails.current_return_status !=
                          enums.return_request_status.CANCELLED
                        "
                        :status="orderDetails.current_return_status"
                        :payment-status="orderDetails.current_payment_status"
                        refund
                      >
                      </order-steps>
                      <div class="mb-20" v-else>
                        <p class="alert alert-danger text-center">
                          {{ $t("This request has been cancelled") }}
                        </p>
                      </div>
                    </div>
                    <order-tracking
                      v-if="orderDetails.tracking_list.data.length > 0"
                      :items="orderDetails.tracking_list.data"
                    ></order-tracking>
                  </div>
                </div>
                <!--End Order status and  tracking history-->
                <!--Product details-->
                <div class="row px-12">
                  <div class="col-md-12">
                    <div class="product-list-group mt-4">
                      <div class="product-list p-3 border">
                        <div class="row gy-10 align-items-center">
                          <div class="col-md-6">
                            <div class="align-items-center d-flex product-info">
                              <div class="image img70">
                                <router-link
                                  :to="`/products/${orderDetails.product_details.permalink}`"
                                >
                                  <img
                                    :src="orderDetails.product_details.image"
                                    :alt="orderDetails.product_details.name"
                                  />
                                </router-link>
                              </div>
                              <div class="title">
                                <h5 class="mb-0 text-capitalize">
                                  <router-link
                                    :to="`/products/${orderDetails.product_details.permalink}`"
                                  >
                                    {{ orderDetails.product_details.name }}
                                  </router-link>
                                </h5>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div
                              class="right-info d-flex justify-content-between"
                            >
                              <div class="price">
                                <span>
                                  {{ $t("Qty") }}:
                                  {{ orderDetails.product_details.quantity }}
                                </span>
                              </div>
                              <div class="price">
                                {{ $t("Price") }}:
                                <the-currency
                                  :amount="orderDetails.product_details.price"
                                ></the-currency>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <!--End product details-->
              </div>
            </div>
          </div>
        </div>
        <!--End product list-->
        <!--summery-->
        <div class="row">
          <div class="col-12">
            <!--Refund Request details-->
            <div class="shadow-card mb-30 p-3">
              <h5 class="order-summery-title">
                {{ $t("Refund Request Information") }}
              </h5>
              <div class="row">
                <div class="col-lg-12 mt-2 mt-lg-0">
                  <table>
                    <tr v-if="orderDetails.refund_reason != null">
                      <td>{{ $t("Reason") }}</td>
                      <td>{{ orderDetails.refund_reason }}</td>
                    </tr>
                    <tr v-if="orderDetails.note != null">
                      <td>{{ $t("Note") }}</td>
                      <td>{{ orderDetails.note }}</td>
                    </tr>
                    <tr v-if="orderDetails.attachments != null">
                      <td>{{ $t("Attachments") }}</td>
                      <td>
                        <div class="attachments d-flex flex-wrap gap-1 ml-10">
                          <img
                            :src="attachment"
                            class="img-70"
                            v-for="(
                              attachment, index
                            ) in orderDetails.attachments"
                            :key="index"
                          />
                        </div>
                      </td>
                    </tr>
                  </table>
                </div>
              </div>
            </div>
            <!--End Refund Request details-->
          </div>
        </div>
        <!--End summery-->
      </div>
      <the-not-found v-else title="No details found"></the-not-found>
    </template>
    <template v-if="loading">
      <skeleton class="w-100 mb-20" height="70px"></skeleton>
      <skeleton class="w-100" height="500px"></skeleton>
    </template>
  </Dashboard>
</template>

<script>
import PageHeader from "@/components/pageheader/PageHeader.vue";
import ShowingPerPage from "@/components/ui/ShowingPerPage.vue";
import Dashboard from "@/views/dashboard.vue";
import OrderTracking from "../../../components/ui/OrderTracking.vue";
import OrderSteps from "../../../components/ui/OrderSteps.vue";
import enums from "../../../enums/enums";
import axios from "axios";
import { mapState } from "vuex";
import {
  CDropdown,
  CDropdownToggle,
  CModal,
  CModalHeader,
  CModalTitle,
  CModalBody,
  CModalFooter,
} from "@coreui/vue";
export default {
  name: "refundDetails",
  components: {
    OrderSteps,
    PageHeader,
    ShowingPerPage,
    Dashboard,
    CDropdown,
    CDropdownToggle,
    CModal,
    CModalHeader,
    CModalTitle,
    CModalBody,
    CModalFooter,
    OrderTracking,
  },
  data() {
    return {
      pageTitle: "Refund details",
      loading: false,
      success: false,
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
          text: this.$t("Refund Details"),
          active: true,
        },
      ],
      orderDetails: null,
      enums: enums,
      errors: [],
    };
  },
  watch: {
    perPage() {
      if (this.perPage == null) {
        this.perPage = this.totalRows;
      }
    },
  },
  computed: mapState({
    customerToken: (state) => state.customerToken,
    product_config: (state) => state.siteSettings,
  }),
  mounted() {
    document.title = this.$t("Dashboard") + " | " + this.$t("Refund Details");
    this.getRefundRequestDetails();
  },
  methods: {
    /**
     * Get refund request details
     */
    getRefundRequestDetails() {
      this.loading = true;
      axios
        .post(
          "/api/refund/v1/refund-request-details",
          {
            id: this.$route.params.id,
          },
          {
            headers: {
              Authorization: `Bearer ${this.customerToken}`,
            },
          }
        )
        .then((response) => {
          if (response.data.success) {
            this.orderDetails = response.data.data;
            this.success = true;
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

<style lang="scss" scoped>
@import "../../../assets/sass/00-abstracts/01-variables";
.img-70 {
  width: 70px;
  height: 70px;
}
.order-info {
  flex-wrap: wrap;
  gap: 10px;
  padding: 0;
}
.px-12 {
  padding-inline: 12px;
}
.gy-10 {
  gap: 10px 0;
}
.product-list-group {
  margin-top: 45px;
}
.product-list:not(:last-child) {
  margin-bottom: 20px;
}
.product-list .product-info {
  gap: 10px;
}
.product-list .product-info .image {
  max-width: 100px;
}
.product-list .product-info .title h5 {
  display: block;
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
  text-overflow: ellipsis;
}
.product-list .product-info:not(:last-child) {
  margin-bottom: 10px;
}
.right-info .write-review {
  color: $c1;
  font-weight: 500;
}
.stars-wrapper .stars .star.active {
  color: #ffc107;
}
.stars-wrapper ul li span {
  font-size: 20px;
}
.stars-wrapper ul .rating {
  font-size: 20px;
  margin-left: 10px;
}
.td-right {
  text-align: right;
}

@media (max-width: 575px) {
  .right-info {
    flex-direction: column;
  }
}
.img70 {
  min-width: 70px !important;
  max-width: 70px !important;
}
</style>
