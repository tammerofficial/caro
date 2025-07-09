<template>
  <Dashboard>
    <div class="address">
      <page-header class="py-3 mb-3" whiteBg :items="bItems" />
      <template v-if="!loading">
        <div class="row">
          <div class="col-12 mb-3" v-if="tableData.length > 0">
            <div class="table-responsive">
              <CTable
                class="style1 mb-0"
                :class="tableData.length == 1 ? 't-mh-160' : ''"
              >
                <CTableHead>
                  <CTableRow>
                    <CTableHeaderCell>{{ $t("Name") }}</CTableHeaderCell>
                    <CTableHeaderCell>{{ $t("Address") }}</CTableHeaderCell>
                    <CTableHeaderCell>{{ $t("Phone") }}</CTableHeaderCell>
                    <CTableHeaderCell>{{ $t("Status") }}</CTableHeaderCell>
                    <CTableHeaderCell>{{ $t("Actions") }}</CTableHeaderCell>
                  </CTableRow>
                </CTableHead>
                <CTableBody>
                  <CTableRow v-for="tdata in tableData" :key="tdata.id">
                    <CTableDataCell>{{ tdata.name }}</CTableDataCell>
                    <CTableDataCell>{{ tdata.address }}</CTableDataCell>
                    <CTableDataCell>
                      {{ tdata.phone_code + "" + tdata.phone }}</CTableDataCell
                    >

                    <CTableDataCell
                      ><button
                        type="button"
                        class="status-btn badge"
                        :class="tdata.status"
                      >
                        {{ tdata.status }}
                      </button>
                      <p
                        v-if="tdata.default_shipping == 1"
                        class="text-info mb-0"
                      >
                        {{ $t("Default Shipping") }}
                      </p>
                      <p
                        v-if="tdata.default_billing == 1"
                        class="text-info mb-0"
                      >
                        {{ $t("Default Billing") }}
                      </p>
                    </CTableDataCell>
                    <CTableDataCell>
                      <CDropdown>
                        <CDropdownToggle
                          ><span class="material-icons">
                            more_vert
                          </span></CDropdownToggle
                        >
                        <CDropdownMenu>
                          <CDropdownItem
                            href="#"
                            @click="EditAddress(tdata.id)"
                            >{{ $t("Edit") }}</CDropdownItem
                          >
                        </CDropdownMenu>
                      </CDropdown>
                    </CTableDataCell>
                  </CTableRow>
                </CTableBody>
              </CTable>
            </div>
          </div>
          <div v-else>
            <the-not-found title="No item found"></the-not-found>
          </div>

          <div class="col-12 mb-3">
            <button
              class="btn btn_fill"
              @click.prevent="
                () => {
                  visibleNewAddressModal = true;
                  errors = [];
                }
              "
            >
              {{ $t("Add new address") }}
            </button>
          </div>
        </div>
      </template>
      <template v-if="loading">
        <skeleton class="w-100 mb-20" height="70px"></skeleton>
        <skeleton class="w-100" height="500px"></skeleton>
      </template>
    </div>
    <!--New Address Modal -->
    <CModal
      scrollable
      :visible="visibleNewAddressModal"
      size="lg"
      @close="
        () => {
          visibleNewAddressModal = false;
        }
      "
    >
      <CModalHeader>
        <CModalTitle>{{ $t("Address Information") }}</CModalTitle>
        <button
          class="btn-circle bg-black size-35"
          @click="
            () => {
              visibleNewAddressModal = false;
            }
          "
        >
          <base-icon-svg name="close" :width="10" :height="10" />
        </button>
      </CModalHeader>
      <CModalBody>
        <div class="row mb-20">
          <div class="form-group col-sm-6">
            <label class="font-weight-bold fz-12 mb-2">
              {{ $t("Name") }} <span class="text-danger">*</span></label
            >
            <input
              type="text"
              v-bind:placeholder="$t('Your Name')"
              class="theme-input-style"
              v-model="addressInfo.name"
            />
            <template v-if="errors.name">
              <p
                class="fz-12 text-danger mt-1"
                v-for="(error, index) in errors.name"
                :key="index"
              >
                {{ error }}
              </p>
            </template>
          </div>
          <div class="form-group col-sm-6">
            <label class="font-weight-bold fz-12 mb-2">
              {{ $t("Phone") }} <span class="text-danger">*</span></label
            >
            <div class="">
              <div class="phone-number-wrap d-flex">
                <input
                  type="tel"
                  v-bind:placeholder="$t('Phone Number')"
                  class="theme-input-style"
                  required
                  v-model="addressInfo.phone"
                />
              </div>
              <template v-if="errors.phone">
                <p
                  class="fz-12 text-danger mt-1"
                  v-for="(error, index) in errors.phone"
                  :key="index"
                >
                  {{ error }}
                </p>
              </template>
            </div>
          </div>
        </div>
        <div
          class="row mb-20"
          v-if="configuration.hide_country_state_city_in_checkout != 1"
        >
          <div class="form-group col-lg-6 mb-20" v-if="countries.length > 1">
            <label class="font-weight-bold fz-12 mb-2">
              {{ $t("Country") }} <span class="text-danger">*</span>
            </label>
            <div class="col">
              <v-select
                :options="countries"
                v-model="addressInfo.country"
                label="name"
              ></v-select>
              <template v-if="errors.country">
                <p
                  class="fz-12 text-danger mt-1"
                  v-for="(error, index) in errors.country"
                  :key="index"
                >
                  {{ error }}
                </p>
              </template>
            </div>
          </div>

          <div class="form-group col-lg-6 mb-20">
            <label class="font-weight-bold fz-12 mb-2">
              {{ $t("State") }} <span class="text-danger">*</span>
            </label>
            <div class="col">
              <v-select
                :options="addressInfo.states_options"
                v-model="addressInfo.state"
                label="name"
              ></v-select>
              <template v-if="errors.state">
                <p
                  class="fz-12 text-danger mt-1"
                  v-for="(error, index) in errors.state"
                  :key="index"
                >
                  {{ error }}
                </p>
              </template>
            </div>
          </div>

          <div
            class="form-group col-lg-6 mb-20"
            v-if="configuration.hide_country_state_city_in_checkout != 1"
          >
            <label class="font-weight-bold fz-12 mb-2">
              {{ $t("City") }} <span class="text-danger">*</span>
            </label>
            <div class="col">
              <v-select
                :options="addressInfo.cities_options"
                v-model="addressInfo.city"
                label="name"
              ></v-select>
              <template v-if="errors.city">
                <p
                  class="fz-12 text-danger mt-1"
                  v-for="(error, index) in errors.city"
                  :key="index"
                >
                  {{ error }}
                </p>
              </template>
            </div>
          </div>

          <div
            :class="
              configuration.hide_country_state_city_in_checkout == 1
                ? 'form-group col-lg-12 mb-20'
                : 'form-group col-lg-6 mb-20'
            "
          >
            <label class="font-weight-bold fz-12 mb-2">
              {{ $t("Postal Code") }}
              <span
                class="text-danger"
                v-if="configuration.post_code_required_in_checkout == 1"
                >*</span
              >
            </label>
            <input
              type="text"
              v-bind:placeholder="$t('Postal code')"
              class="theme-input-style"
              v-model="addressInfo.postal_code"
            />
            <template v-if="errors.postal_code">
              <p
                class="fz-12 text-danger mt-1"
                v-for="(error, index) in errors.postal_code"
                :key="index"
              >
                {{ error }}
              </p>
            </template>
          </div>
        </div>

        <div class="row mb-20">
          <div class="form-group col-12">
            <label class="font-weight-bold fz-12 mb-2">
              {{ $t("Address") }} <span class="text-danger">*</span></label
            >
            <textarea class="theme-input-style" v-model="addressInfo.address">
            </textarea>
            <template v-if="errors.address">
              <p
                class="fz-12 text-danger mt-1"
                v-for="(error, index) in errors.address"
                :key="index"
              >
                {{ error }}
              </p>
            </template>
          </div>
        </div>
      </CModalBody>
      <CModalFooter>
        <button
          class="btn btn_fill"
          @click.prevent="saveAddress"
          :disabled="new_address_submitting"
        >
          <span v-if="new_address_submitting">
            <CSpinner component="span" size="sm" aria-hidden="true" />
            {{ $t("Please wait") }}
          </span>
          <span v-else>
            {{ $t("Save address") }}
          </span>
        </button>
      </CModalFooter>
    </CModal>
    <!-- End New Address Modal -->

    <!--Edit Address Modal -->
    <CModal
      :visible="visibleEditAddressModal"
      size="lg"
      @close="
        () => {
          visibleEditAddressModal = false;
        }
      "
    >
      <CModalHeader>
        <CModalTitle>{{ $t("Address Details") }}</CModalTitle>
        <button
          class="btn-circle bg-black size-35"
          @click="
            () => {
              visibleEditAddressModal = false;
            }
          "
        >
          <base-icon-svg name="close" :width="10" :height="10" />
        </button>
      </CModalHeader>
      <CModalBody>
        <div class="row mb-20">
          <div class="form-group col-sm-6">
            <label class="font-weight-bold fz-12 mb-2">
              {{ $t("Name") }} <span class="text-danger">*</span></label
            >
            <input
              type="text"
              v-bind:placeholder="$t('Your Name')"
              class="theme-input-style"
              v-model="editAddressInfo.name"
            />
            <template v-if="errors.name">
              <p
                class="fz-12 text-danger mt-1"
                v-for="(error, index) in errors.name"
                :key="index"
              >
                {{ error }}
              </p>
            </template>
          </div>

          <div class="form-group col-sm-6">
            <label class="font-weight-bold fz-12 mb-2">
              {{ $t("Phone") }} <span class="text-danger">*</span></label
            >
            <div class="">
              <div class="phone-number-wrap d-flex">
                <input
                  type="tel"
                  v-bind:placeholder="$t('Phone Number')"
                  class="theme-input-style"
                  required
                  v-model="editAddressInfo.phone"
                />
              </div>
              <template v-if="errors.phone">
                <p
                  class="fz-12 text-danger mt-1"
                  v-for="(error, index) in errors.phone"
                  :key="index"
                >
                  {{ error }}
                </p>
              </template>
            </div>
          </div>
        </div>
        <div
          class="row mb-20"
          v-if="configuration.hide_country_state_city_in_checkout != 1"
        >
          <div class="form-group col-lg-6" v-if="countries.length > 1">
            <label class="font-weight-bold fz-12 mb-2">
              {{ $t("Country") }} <span class="text-danger">*</span>
            </label>
            <div class="col">
              <v-select
                :options="countries"
                v-model="editAddressInfo.country"
                @update:modelValue="changeAddressCountry"
                label="name"
              ></v-select>
              <template v-if="errors.country">
                <p
                  class="fz-12 text-danger mt-1"
                  v-for="(error, index) in errors.country"
                  :key="index"
                >
                  {{ error }}
                </p>
              </template>
            </div>
          </div>
          <div class="form-group col-lg-6">
            <label class="font-weight-bold fz-12 mb-2">
              {{ $t("State") }} <span class="text-danger">*</span>
            </label>
            <div class="col">
              <v-select
                :options="editAddressInfo.states_options"
                v-model="editAddressInfo.state"
                label="name"
              ></v-select>
              <template v-if="errors.state">
                <p
                  class="fz-12 text-danger mt-1"
                  v-for="(error, index) in errors.state"
                  :key="index"
                >
                  {{ error }}
                </p>
              </template>
            </div>
          </div>

          <div
            class="form-group col-lg-6"
            v-if="configuration.hide_country_state_city_in_checkout != 1"
          >
            <label class="font-weight-bold fz-12 mb-2">
              {{ $t("City") }} <span class="text-danger">*</span>
            </label>
            <div class="col">
              <v-select
                :options="editAddressInfo.cities_options"
                v-model="editAddressInfo.city"
                label="name"
              ></v-select>
              <template v-if="errors.city">
                <p
                  class="fz-12 text-danger mt-1"
                  v-for="(error, index) in errors.city"
                  :key="index"
                >
                  {{ error }}
                </p>
              </template>
            </div>
          </div>

          <div
            :class="
              configuration.hide_country_state_city_in_checkout == 1
                ? 'form-group col-lg-12'
                : 'form-group col-lg-6'
            "
          >
            <label class="font-weight-bold fz-12 mb-2">
              {{ $t("Postal Code") }}
              <span
                class="text-danger"
                v-if="configuration.post_code_required_in_checkout == 1"
                >*</span
              >
            </label>
            <input
              type="text"
              v-bind:placeholder="$t('Postal code')"
              class="theme-input-style"
              v-model="editAddressInfo.postal_code"
            />
            <template v-if="errors.postal_code">
              <p
                class="fz-12 text-danger mt-1"
                v-for="(error, index) in errors.postal_code"
                :key="index"
              >
                {{ error }}
              </p>
            </template>
          </div>
        </div>

        <div class="row mb-20">
          <div class="form-group col-12">
            <label class="font-weight-bold fz-12 mb-2">
              {{ $t("Address") }} <span class="text-danger">*</span></label
            >
            <textarea
              class="theme-input-style"
              v-model="editAddressInfo.address"
            >
            </textarea>
            <template v-if="errors.address">
              <p
                class="fz-12 text-danger mt-1"
                v-for="(error, index) in errors.address"
                :key="index"
              >
                {{ error }}
              </p>
            </template>
          </div>
        </div>
        <div class="row mb-20">
          <div class="form-group col-12">
            <label class="font-weight-bold fz-12 mb-2">
              {{ $t("Status") }}</label
            >
            <div class="col">
              <input
                id="active"
                type="radio"
                name="status"
                class="me-2"
                value="1"
                v-model="editAddressInfo.status"
                :checked="editAddressInfo.status == 1"
              />
              <label for="active" class="mr-30">{{ $t("Active") }}</label>
              <input
                id="inactive"
                type="radio"
                name="status"
                class="me-2"
                value="2"
                v-model="editAddressInfo.status"
                :checked="editAddressInfo.status == 2"
              /><label for="inactive">{{ $t("Inactive") }}</label>
            </div>
          </div>
        </div>
        <div class="row mb-20">
          <div class="form-group col-12">
            <label class="font-weight-bold fz-12 mb-2">
              {{ $t("Default Shipping Address") }}</label
            >
            <div class="col">
              <input
                id="active_default_shipping"
                type="radio"
                name="default_shipping"
                class="me-2"
                value="1"
                v-model="editAddressInfo.default_shipping"
                :checked="editAddressInfo.default_shipping == 1"
              />
              <label for="active_default_shipping" class="mr-30">{{
                $t("Active")
              }}</label>
              <input
                id="inactive_default_shipping"
                type="radio"
                name="default_shipping"
                class="me-2"
                value="2"
                v-model="editAddressInfo.default_shipping"
                :checked="editAddressInfo.default_shipping == 2"
              /><label for="inactive_default_shipping">{{
                $t("Inactive")
              }}</label>
            </div>
          </div>
        </div>
        <div class="row mb-20">
          <div class="form-group col-12">
            <label class="font-weight-bold fz-12 mb-2">
              {{ $t("Default Billing Address") }}</label
            >
            <div class="col">
              <input
                id="active_default_billing"
                type="radio"
                name="default_billing"
                class="me-2"
                value="1"
                v-model="editAddressInfo.default_billing"
                :checked="editAddressInfo.default_billing == 1"
              />
              <label for="active_default_billing" class="mr-30">{{
                $t("Active")
              }}</label>
              <input
                id="inactive_default_billing"
                type="radio"
                name="default_billing"
                class="me-2"
                value="2"
                v-model="editAddressInfo.default_billing"
                :checked="editAddressInfo.default_billing == 2"
              /><label for="inactive_default_billing">{{
                $t("Inactive")
              }}</label>
            </div>
          </div>
        </div>
      </CModalBody>
      <CModalFooter>
        <button
          class="btn btn_fill"
          @click.prevent="updateAddress"
          :disabled="update_address_submitting"
        >
          <span v-if="update_address_submitting">
            <CSpinner component="span" size="sm" aria-hidden="true" />
            {{ $t("Please wait") }}
          </span>
          <span v-else>
            {{ $t("Save Changes") }}
          </span>
        </button>
      </CModalFooter>
    </CModal>
    <!-- End Edit Address Modal -->
  </Dashboard>
</template>

<script>
import PageHeader from "@/components/pageheader/PageHeader.vue";
import ShowingPerPage from "@/components/ui/ShowingPerPage.vue";
import Dashboard from "@/views/dashboard.vue";
import axios from "axios";
import { CSpinner } from "@coreui/vue";
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
  CModal,
  CButton,
  CModalHeader,
  CModalTitle,
  CModalBody,
  CModalFooter,
} from "@coreui/vue";

export default {
  name: "CustomerAddress",
  components: {
    CSpinner,
    CModal,
    CButton,
    CModalHeader,
    CModalTitle,
    CModalBody,
    CModalFooter,
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
    CPagination,
    CPaginationItem,
  },
  watch: {
    "addressInfo.country"() {
      this.addressInfo.state = this.$t("Select State");
      this.addressInfo.city = this.$t("Select City");
      this.addressInfo.cities_options = [];
      this.getStates("new");
    },
    "addressInfo.state"() {
      this.addressInfo.city = this.$t("Select City");
      this.getCities("new");
    },
    "editAddressInfo.country"() {
      this.getStates("edit");
    },
    "editAddressInfo.state"() {
      this.getCities("edit");
    },
  },
  computed: mapState({
    customerToken: (state) => state.customerToken,
    configuration: (state) => state.siteSettings,
  }),
  data() {
    return {
      loading: false,
      pageTitle: "Purchase History",
      bItems: [
        {
          text: this.$t("Home"),
          href: "/",
        },
        {
          text: this.$t("Dashboard"),
          href: "/",
        },
        {
          text: this.$t("Address"),
          active: true,
        },
      ],
      visibleNewAddressModal: false,
      visibleEditAddressModal: false,
      new_address_submitting: false,
      update_address_submitting: false,
      tableData: [],
      totalRows: 1,
      currentPage: 1,
      perPage: 10,
      countries: [],
      errors: [],
      phone_codes: [],
      addressInfo: {
        name: "",
        phone: "",
        phone_code:
          localStorage.getItem("country") != null
            ? JSON.parse(localStorage.getItem("country")).phone_code
            : "",
        postal_code: "",
        address: "",
        country: this.$t("Select Country"),
        state: this.$t("Select State"),
        city: this.$t("Select City"),
        states_options: [],
        cities_options: [],
      },
      editAddressInfo: {
        name: "",
        phone: "",
        phone_code:
          localStorage.getItem("country") != null
            ? JSON.parse(localStorage.getItem("country")).phone_code
            : "",
        postal_code: "",
        address: "",
        country: this.$t("Select Country"),
        state: this.$t("Select State"),
        city: this.$t("Select City"),
        states_options: [],
        cities_options: [],
        addressDeleteId: "",
      },
    };
  },
  mounted() {
    document.title = this.$t("Dashboard") + " | " + this.$t("Addresses");
    this.getCustomerAddress();
    this.getCounties();
    this.getPhoneCodes();
  },
  methods: {
    ///Select country
    changeAddressCountry() {
      this.editAddressInfo.state = this.$t("Select State");
      this.editAddressInfo.city = this.$t("Select City");
    },
    /**
     * Will get customer all address
     */
    getCustomerAddress() {
      this.loading = true;
      axios
        .get("/api/v1/ecommerce-core/customer/get-customer-all-address", {
          headers: {
            Authorization: `Bearer ${this.customerToken}`,
          },
        })
        .then((response) => {
          if (response.data.success) {
            this.tableData = response.data.data;
            this.loading = false;
          } else {
            this.loading = false;
            this.$toast.error(this.$t("No address found"));
          }
        })
        .catch((error) => {
          this.loading = false;
          this.$toast.error(this.$t("No address found"));
        });
    },
    /**
     * Will save customer  address
     */
    saveAddress() {
      this.new_address_submitting = true;
      let formData = new FormData();
      formData.append("name", this.addressInfo.name);
      formData.append("phone_code", this.addressInfo.phone_code);
      formData.append("phone", this.addressInfo.phone);
      formData.append("postal_code", this.addressInfo.postal_code);
      formData.append("address", this.addressInfo.address);
      formData.append(
        "country",
        this.addressInfo.country.hasOwnProperty("id")
          ? this.addressInfo.country.id
          : ""
      );
      formData.append(
        "state",
        this.addressInfo.state.hasOwnProperty("id")
          ? this.addressInfo.state.id
          : ""
      );
      formData.append(
        "city",
        this.addressInfo.city.hasOwnProperty("id")
          ? this.addressInfo.city.id
          : ""
      );
      axios
        .post(
          "/api/v1/ecommerce-core/customer/store-customer-address",
          formData,
          {
            headers: {
              Authorization: `Bearer ${this.customerToken}`,
            },
          }
        )
        .then((response) => {
          if (response.data.success) {
            this.visibleNewAddressModal = false;
            this.getCustomerAddress();
            this.resetData();
            this.$toast.success(this.$t("Address added successfully"));
          } else {
            this.$toast.error(this.$t("Address adding failed"));
            this.visibleNewAddressModal = false;
            this.resetData();
          }
          this.new_address_submitting = false;
        })
        .catch((error) => {
          if (error.response.status == 422) {
            this.errors = error.response.data.errors;
          } else {
            this.$toast.error(this.$t("Address adding failed"));
            this.visibleNewAddressModal = false;
            this.resetData();
          }
          this.new_address_submitting = false;
        });
    },
    /**
     * Will get address details
     *
     * @param {*} id
     */
    EditAddress(id) {
      this.errors = [];
      axios
        .post(
          "/api/v1/ecommerce-core/customer/get-customer-address-details",
          {
            id: id,
          },
          {
            headers: {
              Authorization: `Bearer ${this.customerToken}`,
            },
          }
        )
        .then((response) => {
          if (response.data.success) {
            this.visibleEditAddressModal = true;
            this.editAddressInfo = response.data.data;
          } else {
            this.$toast.error(this.$t("Address not found"));
          }
        })
        .catch((error) => {
          this.$toast.error(this.$t("Address not found"));
        });
    },
    /**
     * Will update customer  address
     */
    updateAddress() {
      this.update_address_submitting = true;
      let formData = new FormData();
      formData.append("id", this.editAddressInfo.id);
      formData.append("name", this.editAddressInfo.name);
      formData.append("phone_code", this.editAddressInfo.phone_code);
      formData.append("phone", this.editAddressInfo.phone);
      formData.append("postal_code", this.editAddressInfo.postal_code);
      formData.append("address", this.editAddressInfo.address);
      formData.append("status", this.editAddressInfo.status);
      formData.append(
        "default_shipping",
        this.editAddressInfo.default_shipping
      );
      formData.append("default_billing", this.editAddressInfo.default_billing);
      formData.append(
        "country",
        this.editAddressInfo.country ? this.editAddressInfo.country.id : ""
      );
      formData.append(
        "state",
        this.editAddressInfo.state ? this.editAddressInfo.state.id : ""
      );
      formData.append(
        "city",
        this.editAddressInfo.city ? this.editAddressInfo.city.id : ""
      );
      axios
        .post(
          "/api/v1/ecommerce-core/customer/update-customer-address",
          formData,
          {
            headers: {
              Authorization: `Bearer ${this.customerToken}`,
            },
          }
        )
        .then((response) => {
          if (response.data.success) {
            this.visibleEditAddressModal = false;
            this.getCustomerAddress();
            this.$toast.success(this.$t("Address updated successfully"));
          } else {
            this.$toast.error(this.$t("Address updating failed"));
            this.visibleEditAddressModal = false;
            this.resetData();
          }
          this.update_address_submitting = false;
        })
        .catch((error) => {
          if (error.response.status == 422) {
            this.errors = error.response.data.errors;
          } else {
            this.$toast.error(this.$t("Address updating failed"));
            this.visibleEditAddressModal = false;
            this.resetData();
          }
          this.update_address_submitting = false;
        });
    },
    /**
     * Will get countries phone code
     */
    getPhoneCodes() {
      axios
        .get("/api/v1/ecommerce-core/phone-codes")
        .then((response) => {
          if (response.data.success) {
            this.phone_codes = response.data.phone_codes;
          }
        })
        .catch((error) => {
          this.phone_codes = [];
        });
    },
    /**
     * Get counties list
     */
    getCounties() {
      axios
        .get("/api/v1/ecommerce-core/get-countries")
        .then((response) => {
          if (response.data.success) {
            this.countries = response.data.data.countries;
            if (this.countries.length == 1) {
              this.addressInfo.country = this.countries[0];
              getStates("new");
            }
          }
        })
        .catch((error) => {
          this.countries = [];
        });
    },
    /**
     * Will get state list of a country
     */
    getStates(origin) {
      let country_id = "";
      if (origin === "new") {
        country_id = this.addressInfo.country
          ? this.addressInfo.country.id
          : "";
      } else if (origin === "edit") {
        country_id = this.editAddressInfo.country
          ? this.editAddressInfo.country.id
          : "";
      }
      axios
        .post("/api/v1/ecommerce-core/get-states-of-countries", {
          country_id: country_id,
        })
        .then((response) => {
          if (response.data.success) {
            if (origin === "new") {
              this.addressInfo.states_options = response.data.data.states;
            } else if (origin === "edit") {
              this.editAddressInfo.states_options = response.data.data.states;
            }
          }
        })
        .catch((error) => {});
    },
    /**
     * Will get cities list of a state
     */
    getCities(origin) {
      let state = "";
      if (origin === "new") {
        state = this.addressInfo.state ? this.addressInfo.state.id : "";
      }

      if (origin === "edit") {
        state = this.editAddressInfo.state ? this.editAddressInfo.state.id : "";
      }
      axios
        .post("/api/v1/ecommerce-core/get-cities-of-state", {
          state_id: state,
        })
        .then((response) => {
          if (response.data.success) {
            if (origin === "new") {
              this.addressInfo.cities_options = response.data.data.cities;
            }
            if (origin === "edit") {
              this.editAddressInfo.cities_options = response.data.data.cities;
            }
          }
        })
        .catch((error) => {});
    },
    resetData() {
      this.addressInfo.name = "";
      this.addressInfo.phone = "";
      this.addressInfo.address = "";
      this.addressInfo.postal_code = "";
    },
  },
};
</script>
