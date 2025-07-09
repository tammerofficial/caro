<template>
  <div class="light-bg pt-4 pt-md-5 pb-4 pb-md-5">
    <div class="custom-container2">
      <div class="row" v-if="isCustomerLogin">
        <div class="col-lg-3">
          <!-- Store Info -->
          <div
            class="store-info media c1-bg pl-20 pr-20 pt-15 pb-15 align-items-center mb-30"
          >
            <div class="reseller-logo position-relative me-3">
              <img
                class="rounded-circle"
                :src="customerInfo.image"
                :alt="`${customerInfo.name}`"
                height="50px"
                width="50px"
              />

              <template>
                <span class="btn_tooltip position-absolute" title="Verified">
                  <span class="tooltip-icon w-auto h-auto">
                    <img
                      src="/src/assets/images/icons/dashboard/verified.png"
                      alt=""
                    />
                  </span>
                </span>
              </template>
            </div>
            <div class="media-body">
              <h5 class="store-title text-white font-weight-medium mb-0">
                {{ customerInfo.name }}
              </h5>
              <span class="store-tagline fz-12">{{ customerInfo.uid }}</span>
            </div>
          </div>
          <!-- End Store Info -->
        </div>

        <div class="col-lg-9">
          <div class="c1-bg pl-20 pr-20 pt-20 pb-15 mb-30">
            <div class="row gx-0">
              <!-- Store Info -->
              <div class="single-store-info col-lg-3 col-md-6 mb-10 mb-lg-0">
                <span class="d-block fz-12">{{
                  $t("Total Purchase Amount")
                }}</span>
                <h4 class="text-white mb-0">
                  <the-currency
                    :amount="
                      dashboard_content != null
                        ? dashboard_content.total_purchase_amount
                        : 0
                    "
                  ></the-currency>
                </h4>
              </div>
              <!-- End Store Info -->

              <!-- Store Info -->
              <div class="single-store-info col-lg-4 col-md-6 mb-10 mb-lg-0">
                <span class="d-block fz-12"
                  >{{ $t("Total Purchase in") }}
                  {{ dashboard_content.current_month }}
                </span>
                <h4 class="text-white mb-0">
                  <the-currency
                    :amount="dashboard_content.current_month_purchase"
                  ></the-currency>
                </h4>
              </div>
              <!-- End Store Info -->

              <div class="col-lg-5">
                <!-- Store Info -->
                <div class="single-store-info d-flex align-items-center mb-1">
                  <span class="d-block fz-12">
                    {{ $t("Last Purchase") }} (
                    {{ dashboard_content.last_purchase_date }}
                    )
                  </span>
                  <h6 class="text-white font-weight-medium ml-10 mb-0">
                    <the-currency
                      :amount="dashboard_content.last_purchase_amount"
                    ></the-currency>
                  </h6>
                </div>
                <!-- End Store Info -->
                <!-- Store Info -->
                <div class="single-store-info d-flex align-items-center">
                  <span class="d-block fz-12">
                    {{ $t("Last Month Purchase") }} ({{
                      dashboard_content.last_month
                    }})
                  </span>
                  <h6 class="text-white font-weight-medium ml-10 mb-0">
                    <the-currency
                      :amount="dashboard_content.last_month_purchase"
                    ></the-currency>
                  </h6>
                </div>
                <!-- End Store Info -->
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-lg-3 d-none d-lg-block">
          <ul class="reseller-dashboard-menu nav flex-column">
            <li>
              <router-link to="/dashboard">
                {{ $t("Dashboard") }}
              </router-link>
            </li>
            <li>
              <router-link to="/dashboard/purchase-history">
                {{ $t("Purchase History") }}
              </router-link>
            </li>
            <li>
              <router-link to="/dashboard/wishlist">
                {{ $t("Wishlist") }}
              </router-link>
            </li>
            <li>
              <router-link to="/dashboard/address">
                {{ $t("Address") }}
              </router-link>
            </li>

            <li>
              <router-link to="/dashboard/refund/requests">
                {{ $t("Refund Requests") }}
              </router-link>
            </li>
            <li>
              <router-link
                to="/dashboard/wallet"
                v-if="siteSettings.is_active_wallet == status.ACTIVE"
              >
                {{ $t("My Wallet") }}
              </router-link>
            </li>

            <li>
              <router-link to="/dashboard/manage-account">
                {{ $t("Manage Account") }}
              </router-link>
            </li>
          </ul>
        </div>

        <div class="col-lg-9">
          <slot></slot>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapState } from "vuex";
import enums from "../enums/enums";
export default {
  data() {
    return {
      supportTicketMgs: 2,
      status: enums.status,
    };
  },
  computed: mapState({
    isCustomerLogin: (state) => state.isCustomerLogin,
    customerToken: (state) => state.customerToken,
    customerInfo: (state) => state.customerInfo,
    dashboard_content: (state) => state.customerDashboardInfo,
    siteSettings: (state) => state.siteSettings,
  }),
};
</script>

<style lang="scss" scoped>
@import "../assets/sass/00-abstracts/01-variables";
.fz-12 {
  font-size: 12px;
}
.store-info {
  line-height: 1;
  .btn_tooltip {
    bottom: 0;
    right: 0;
    .tooltip-icon {
      width: 18px;
      height: 18px;
    }
  }
  .store-title {
    line-height: calc(24 / 16);
  }
  .store-tagline {
    color: #ffdbd5;
  }
}

.single-store-info {
  line-height: 1;
  span {
    color: #ffdbd5;
    line-height: calc(18 / 12);
  }
  h4 {
    line-height: calc(27 / 18);
  }
}

.reseller-dashboard-menu {
  li {
    &:not(:last-child) {
      margin-bottom: 5px;
    }
    a {
      display: block;
      line-height: 50px;
      padding: 0 12px;
      background-color: #fff;
      img {
        margin-right: 12px;
      }
      &:hover,
      &.router-link-exact-active {
        color: $c1;
      }
    }
  }

  .btn_badge {
    width: 25px;
    height: 25px;
    border: 2px solid #ffe6e6;
    border-radius: 50%;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 12px;
    background-color: #fff;
    position: absolute;
    right: 10px;
    top: 50%;
    transform: translateY(-50%);
  }
}
</style>
