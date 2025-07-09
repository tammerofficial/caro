<template>
  <Dashboard>
    <div class="purchase_history">
      <page-header class="py-3 mb-20" whiteBg :items="bItems" />
      <template v-if="!loading">
        <!--Overview-->
        <div class="row">
          <div class="col-lg-4">
            <dashboard-card
              title="Available Balance"
              currency
              :counter="wallet_available_balance"
            ></dashboard-card>
          </div>
          <div class="col-lg-4">
            <dashboard-card
              title="Pending Balance"
              currency
              :counter="wallet_pending_balance"
            ></dashboard-card>
          </div>
          <div class="col-lg-4">
            <div
              class="single-overview white-box pt-15 pb-15 pl-20 pr-20 mb-30 text-center"
            >
              <span class="text-soft">{{ $t("Recharge wallet") }}</span>

              <h2 class="font-weight-medium mb-0">
                <button
                  class="wallet-recharge btn btn-circle"
                  @click="
                    () => {
                      visibleWalletRechargeModal = true;
                    }
                  "
                >
                  <span class="material-icons"> add_circle </span>
                </button>
              </h2>
            </div>
          </div>
        </div>
        <!--End overview-->
        <div v-if="tableData.length > 0">
          <div class="row">
            <div class="col-12">
              <div class="table-responsive">
                <CTable
                  class="style1 mb-0"
                  :class="tableData.length == 1 ? 't-mh-160' : ''"
                >
                  <CTableHead>
                    <CTableRow>
                      <CTableHeaderCell>{{ $t("#") }}</CTableHeaderCell>
                      <CTableHeaderCell>{{ $t("Date") }}</CTableHeaderCell>
                      <CTableHeaderCell>{{ $t("Amount") }}</CTableHeaderCell>
                      <CTableHeaderCell>{{ $t("Type") }}</CTableHeaderCell>
                      <CTableHeaderCell>{{
                        $t("Payment Option")
                      }}</CTableHeaderCell>
                      <CTableHeaderCell>{{ $t("Status") }}</CTableHeaderCell>
                    </CTableRow>
                  </CTableHead>
                  <CTableBody>
                    <CTableRow v-for="(tdata, index) in tableData" :key="index">
                      <CTableDataCell>
                        {{ index + 1 }}
                      </CTableDataCell>
                      <CTableDataCell>{{ tdata.date }}</CTableDataCell>
                      <CTableDataCell>
                        <the-currency
                          :amount="tdata.recharge_amount"
                        ></the-currency>
                      </CTableDataCell>
                      <CTableDataCell>
                        <p
                          class="text-capitalize"
                          v-if="tdata.type == 'credited'"
                        >
                          <span class="material-icons text-success">
                            arrow_upward </span
                          >{{ tdata.type }}
                        </p>
                        <p class="text-capitalize" v-else>
                          <span class="material-icons text-danger">
                            <span class="material-symbols-outlined">
                              arrow_downward
                            </span> </span
                          >{{ tdata.type }}
                        </p>
                      </CTableDataCell>
                      <CTableDataCell>
                        <p class="text-capitalize">
                          {{ tdata.payment_method }}
                        </p>
                      </CTableDataCell>
                      <CTableDataCell>
                        <p
                          :class="`status-btn badge text-capitalize ${tdata.status}`"
                        >
                          {{ tdata.status }}
                        </p>
                      </CTableDataCell>
                    </CTableRow>
                  </CTableBody>
                </CTable>
              </div>
            </div>
          </div>

          <div class="row align-items-center mt-30" v-if="tableData.length > 0">
            <div class="col-md-6">
              <!-- Showing Per Page -->
              <showing-per-page
                class="text-center text-md-start"
                :items-per-page="perPage"
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
                @paginate="getCustomerWalletTransactions"
              />
              <!-- End Pagination -->
            </div>
          </div>
        </div>
        <div v-else>
          <the-not-found title="No item found"></the-not-found>
        </div>
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

    <!--Wallet recharge modal-->
    <CModal
      :visible="visibleWalletRechargeModal"
      size="md"
      @close="
        () => {
          visibleWalletRechargeModal = false;
        }
      "
    >
      <CModalHeader>
        <CModalTitle>{{ $t("Recharge wallet") }}</CModalTitle>
        <button
          class="btn-circle bg-black size-35"
          @click="
            () => {
              visibleWalletRechargeModal = false;
            }
          "
        >
          <base-icon-svg name="close" :width="10" :height="10" />
        </button>
      </CModalHeader>
      <CModalBody>
        <div class="row">
          <div class="col-12 mb-20" v-if="minimum_recharge_error">
            <p class="alert alert-danger text-center">
              {{ $t("Minimum recharge amount") }}
              <the-currency :amount="minimum_recharge_error"></the-currency>
            </p>
          </div>
          <div class="col-12">
            <ul class="list-unstyled form-selector-list mb-3">
              <li
                class="p-1 single-form-selector w-50 m-0"
                v-if="siteSettings.enable_online_recharge == status.ACTIVE"
              >
                <span class="custom-radio-btn">
                  <label class="mb-0 p-2">
                    <input
                      type="radio"
                      class="wallet-recharge-type"
                      name="wallet-recharge-type"
                      value="1"
                      v-model="selected_recharge_type"
                    />
                    <span class="label-title">
                      {{ $t("Online Recharge") }}
                    </span>
                  </label>
                </span>
              </li>
              <li
                class="p-1 single-form-selector w-50 m-0"
                v-if="siteSettings.enable_offline_recharge == status.ACTIVE"
              >
                <span class="custom-radio-btn">
                  <label class="mb-0 p-2">
                    <input
                      type="radio"
                      class="wallet-recharge-type"
                      name="wallet-recharge-type"
                      value="2"
                      v-model="selected_recharge_type"
                    />
                    <span class="label-title">
                      {{ $t("Offline Recharge") }}
                    </span>
                  </label>
                </span>
              </li>
            </ul>
          </div>
          <!--Online recharge-->
          <div
            class="col-12"
            v-if="
              selected_recharge_type == recharge_type.ONLINE &&
              siteSettings.enable_online_recharge == status.ACTIVE
            "
          >
            <div class="row mb-20">
              <div class="form-group col-12 mb-20">
                <label class="font-weight-bold">
                  {{ $t("Select a payment option") }}
                  <span class="text-danger">*</span></label
                >
                <select
                  class="theme-input-style"
                  v-model="selected_online_payment_method"
                >
                  <option
                    v-for="(method, index) in online_payment_methods"
                    :key="index"
                    :value="method.id"
                  >
                    {{ method.name }}
                  </option>
                </select>
              </div>
              <div class="form-group col-12">
                <label class="font-weight-bold">
                  {{ $t("Recharge amount") }}
                  <span class="text-danger">*</span></label
                >
                <input
                  type="text"
                  class="theme-input-style"
                  v-model="recharge_amount"
                />
                <template v-if="errors.recharge_amount">
                  <p
                    class="fz-12 text-danger mt-1"
                    v-for="(error, index) in errors.recharge_amount"
                    :key="index"
                  >
                    {{ error }}
                  </p>
                </template>
              </div>
            </div>
          </div>
          <!--End online recharge-->
          <!--Offline recharge-->
          <div
            class="col-12"
            v-if="selected_recharge_type == recharge_type.OFFLINE"
          >
            <div class="row mb-20">
              <!--Offline Payment methods-->
              <div class="form-group col-12">
                <label class="font-weight-bold fz-12 mb-2">{{
                  $t("Select a payment option")
                }}</label>
                <ul class="list-unstyled form-selector-list mb-3">
                  <li
                    class="single-form-selector"
                    v-for="(payment, index) in offline_payment_methods"
                    :key="index"
                  >
                    <span class="custom-radio-btn">
                      <label>
                        <input
                          type="radio"
                          :value="payment"
                          class="shipping-method"
                          name="payment-method"
                          v-model="selected_offline_payment"
                        />
                        <span class="label-title" v-if="payment.logo">
                          <img :src="payment.logo" :alt="payment.name" />
                        </span>
                        <span class="label-title" v-else>
                          {{ payment.name }}
                        </span>
                      </label>
                    </span>
                  </li>
                </ul>
              </div>
              <!--End Offline Payment methods-->
              <div
                class="bg-light col-12 py-2 mb-20"
                v-if="selected_offline_payment != null"
              >
                <div
                  v-html="selected_offline_payment.instruction"
                  v-if="selected_offline_payment.instruction != null"
                ></div>

                <p v-if="selected_offline_payment.bank_name != null">
                  {{ $t("Bank Name") }} :
                  {{ selected_offline_payment.bank_name }}
                </p>
                <p v-if="selected_offline_payment.account_name != null">
                  {{ $t("Account Name") }} :
                  {{ selected_offline_payment.account_name }}
                </p>
                <p v-if="selected_offline_payment.account_number != null">
                  {{ $t("Account Number") }} :
                  {{ selected_offline_payment.account_number }}
                </p>
                <p v-if="selected_offline_payment.routing_number != null">
                  {{ $t("Routing Number") }} :
                  {{ selected_offline_payment.routing_number }}
                </p>
              </div>

              <div class="form-group col-12 mb-20">
                <label class="font-weight-bold">
                  {{ $t("Recharge amount") }}
                  <span class="text-danger">*</span></label
                >
                <input
                  type="text"
                  class="theme-input-style"
                  v-model="recharge_amount"
                  placeholder="0.00"
                />
                <template v-if="errors.recharge_amount">
                  <p
                    class="fz-12 text-danger mt-1"
                    v-for="(error, index) in errors.recharge_amount"
                    :key="index"
                  >
                    {{ error }}
                  </p>
                </template>
              </div>

              <div class="form-group col-12 mb-20">
                <label class="font-weight-bold">
                  {{ $t("Transaction ID") }}
                  <span class="text-danger">*</span></label
                >
                <input
                  type="text"
                  class="theme-input-style"
                  v-model="transaction_id"
                  v-bind:placeholder="$t('Enter transaction id')"
                />
                <template v-if="errors.transaction_id">
                  <p
                    class="fz-12 text-danger mt-1"
                    v-for="(error, index) in errors.transaction_id"
                    :key="index"
                  >
                    {{ error }}
                  </p>
                </template>
              </div>

              <div class="form-group col-12 mb-20">
                <label class="font-weight-bold">
                  {{ $t("Document") }}
                </label>
                <base-file-input
                  id="transaction_image"
                  name="transaction_image"
                  v-on:getFileInput="transactionImage($event)"
                  single
                />
                <template v-if="errors.transaction_image">
                  <p
                    class="fz-12 text-danger mt-1"
                    v-for="(error, index) in errors.transaction_image"
                    :key="index"
                  >
                    {{ error }}
                  </p>
                </template>
              </div>
            </div>
          </div>
          <!--End offline recharge-->
        </div>
      </CModalBody>
      <CModalFooter>
        <button
          class="btn btn_fill"
          @click.prevent="submitWalletRecharge"
          :disabled="wallet_recharge_submitting"
        >
          <span v-if="wallet_recharge_submitting">
            <CSpinner component="span" size="sm" aria-hidden="true" />
            {{ $t("Please wait") }}
          </span>
          <span v-else>
            {{ $t("Submit") }}
          </span>
        </button>
      </CModalFooter>
    </CModal>
    <!--End Wallet recharge modal-->
  </Dashboard>
</template>

<script>
import PageHeader from "@/components/pageheader/PageHeader.vue";
import ShowingPerPage from "@/components/ui/ShowingPerPage.vue";
import DashboardCard from "@/components/ui/DashboardCard.vue";
import Dashboard from "@/views/dashboard.vue";
import Pagination from "v-pagination-3";
import enums from "../../../enums/enums";
import axios from "axios";
import { mapState } from "vuex";
import { CSpinner } from "@coreui/vue";
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
  CPaginationItem,
  CModal,
  CModalHeader,
  CModalTitle,
  CModalBody,
  CModalFooter,
} from "@coreui/vue";
export default {
  name: "Wallet",
  components: {
    CSpinner,
    DashboardCard,
    PageHeader,
    ShowingPerPage,
    Dashboard,
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
    Pagination,
    CPaginationItem,
    CModal,
    CModalHeader,
    CModalTitle,
    CModalBody,
    CModalFooter,
  },
  computed: mapState({
    customerToken: (state) => state.customerToken,
    siteSettings: (state) => state.siteSettings,
    minimum_recharge_amount() {
      let converted_amount = 0;
      if (typeof this.siteSettings.minimum_recharge_amount == "undefined") {
        converted_amount = 0;
      } else {
        converted_amount = parseInt(this.siteSettings.minimum_recharge_amount);
      }

      converted_amount =
        converted_amount != 0
          ? (converted_amount * parseInt(this.user_currency.conversion_rate)) /
            parseInt(this.system_currency.conversion_rate)
          : 0;

      converted_amount = parseFloat(converted_amount).toFixed(
        this.user_currency.number_of_decimal
      );

      return parseFloat(converted_amount);
    },
  }),
  data() {
    return {
      pageTitle: "My wallet",
      loading: true,
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
          text: this.$t("My Wallet"),
          active: true,
        },
      ],
      visibleWalletRechargeModal: false,
      wallet_recharge_submitting: false,
      status: enums.status,
      recharge_type: enums.wallet_recharge_type,
      tableData: [],
      totalRows: 1,
      currentPage: 1,
      perPage: 10,
      filter: null,
      paginationOptions: {
        chunk: 3,
        theme: "bootstrap4",
        hideCount: true,
      },
      errors: [],
      wallet_recharge_type: [
        {
          name: this.$t("Online Recharge"),
          value: 1,
        },
        {
          name: this.$t("Offline Recharge"),
          value: 2,
        },
      ],
      selected_recharge_type: enums.wallet_recharge_type.ONLINE,
      selected_offline_payment: null,
      selected_online_payment_method: null,
      online_payment_methods: [],
      offline_payment_methods: [],
      transaction_id: "",
      recharge_amount: 0,
      transaction_image: "",
      wallet_available_balance: 0,
      wallet_pending_balance: 0,
      minimum_recharge_error: "",
      system_currency: JSON.parse(localStorage.getItem("default_currency")),
      user_currency: JSON.parse(localStorage.getItem("currency")),
    };
  },
  watch: {
    perPage() {
      if (this.perPage == null) {
        this.perPage = this.totalRows;
      }
    },
  },
  mounted() {
    document.title = this.$t("Dashboard") + " | " + this.$t("Wallet");
    if (this.$route.query.recharge) {
      if (this.$route.query.recharge == "success") {
        this.$toast.success(this.$t("Wallet recharge successfully"));
      }
      this.$router.push("/dashboard/wallet");
    }
    this.getCustomerWalletSummary();
    this.getCustomerWalletTransactions();
    this.gePaymentMethods();
  },
  methods: {
    gePaymentMethods() {
      axios
        .get("/api/wallet/v1/payment-methods")
        .then((response) => {
          if (response.data.success) {
            this.online_payment_methods = response.data.online_methods;
            this.offline_payment_methods = response.data.offline_methods.data;
          }
        })
        .catch((error) => {});
    },
    /**
     * Get customer wallet transactions
     */
    getCustomerWalletSummary() {
      axios
        .post(
          "/api/wallet/v1/customer-wallet-summary",
          {
            perPage: null,
          },
          {
            headers: {
              Authorization: `Bearer ${this.customerToken}`,
            },
          }
        )
        .then((response) => {
          if (response.data.success) {
            this.wallet_available_balance =
              response.data.summary.total_available;
            this.wallet_pending_balance = response.data.summary.total_pending;
          } else {
            this.wallet_available_balance = 0;
            this.wallet_pending_balance = 0;
          }
        })
        .catch((error) => {
          this.wallet_available_balance = 0;
          this.wallet_pending_balance = 0;
        });
    },
    /**
     * Get customer wallet transactions
     */
    getCustomerWalletTransactions() {
      this.loading = true;
      axios
        .post(
          "/api/wallet/v1/customer-wallet-transaction",
          {
            perPage: this.perPage,
            page: this.currentPage,
          },
          {
            headers: {
              Authorization: `Bearer ${this.customerToken}`,
            },
          }
        )
        .then((response) => {
          if (response.data.success) {
            this.tableData = response.data.data;
            this.totalRows = response.data.meta.total;
            this.success = true;
            this.loading = false;
          } else {
            this.totalRows = 0;
            this.loading = false;
          }
        })
        .catch((error) => {
          this.totalRows = 0;
          this.loading = false;
        });
    },
    /**
     * Submit wallet recharge form
     */
    submitWalletRecharge() {
      this.wallet_recharge_submitting = true;
      this.minimum_recharge_error = "";
      //Validate Minimum amount
      if (this.recharge_amount < this.minimum_recharge_amount) {
        this.minimum_recharge_error = this.minimum_recharge_amount;
        this.wallet_recharge_submitting = false;
        return null;
      }
      if (this.recharge_amount >= this.minimum_recharge_amount) {
        let user_currency = JSON.parse(localStorage.getItem("currency"));
        //Online Recharge
        if (this.selected_recharge_type == this.recharge_type.ONLINE) {
          if (this.selected_online_payment_method == null) {
            this.$toast.error(this.$t("Please select a payment method"));
            this.wallet_recharge_submitting = false;
            return null;
          }
          this.errors = [];
          let formData = new FormData();
          formData.append("recharge_type", this.selected_recharge_type);
          formData.append("recharge_amount", this.recharge_amount);
          formData.append(
            "payment_method",
            this.selected_online_payment_method
          );
          formData.append("currency", user_currency.id);

          axios
            .post(
              "/api/wallet/v1/generate-online-wallet-recharge-link",
              formData,
              {
                headers: {
                  Authorization: `Bearer ${this.customerToken}`,
                  "Content-Type": "multipart/form-data",
                },
              }
            )
            .then((response) => {
              if (response.data.success) {
                window.location.href = response.data.url;
              } else {
                this.$toast.error(this.$t("Wallet recharge failed"));
              }
              this.wallet_recharge_submitting = false;
            })
            .catch((error) => {
              if (error.response.status == 422) {
                this.errors = error.response.data.errors;
              } else {
                this.$toast.error(this.$t("Wallet recharge failed"));
              }
              this.wallet_recharge_submitting = false;
            });
        }

        //Offline Recharge
        if (this.selected_recharge_type == this.recharge_type.OFFLINE) {
          if (this.selected_offline_payment == null) {
            this.wallet_recharge_submitting = false;
            this.$toast.error(this.$t("Please select a payment method"));
            return null;
          }
          this.errors = [];
          let formData = new FormData();
          formData.append("recharge_type", this.selected_recharge_type);
          formData.append("recharge_amount", this.recharge_amount);
          formData.append("transaction_id", this.transaction_id);
          formData.append("payment_method", this.selected_offline_payment.id);
          formData.append("transaction_image", this.transaction_image);
          formData.append("currency", user_currency.id);

          axios
            .post("/api/wallet/v1/store-offline-payment", formData, {
              headers: {
                Authorization: `Bearer ${this.customerToken}`,
                "Content-Type": "multipart/form-data",
              },
            })
            .then((response) => {
              if (response.data.success) {
                this.visibleWalletRechargeModal = false;
                this.$toast.success(this.$t("Wallet recharge successfully"));
                this.recharge_amount = "";
                this.transaction_id = "";
                this.transaction_image = "";
                this.selected_recharge_type = this.recharge_type.ONLINE;
                this.selected_offline_payment = null;
                this.getCustomerWalletTransactions();
              } else {
                this.$toast.error(this.$t("Wallet recharge failed"));
              }
              this.wallet_recharge_submitting = false;
            })
            .catch((error) => {
              if (error.response.status == 422) {
                this.errors = error.response.data.errors;
              } else {
                this.$toast.error(this.$t("Wallet recharge failed"));
              }
              this.wallet_recharge_submitting = false;
            });
        }
      }
    },
    /**
     * load transaction image
     *
     * @param {*} e
     */
    transactionImage(e) {
      this.transaction_image = e[0];
    },
  },
};
</script>
