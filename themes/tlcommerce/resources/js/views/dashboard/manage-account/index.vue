<template>
  <Dashboard>
    <div class="reseller_manage_account">
      <page-header class="py-3 mb-3" whiteBg :items="bItems" />
      <template v-if="!loading">
        <!--Update basic info-->
        <div class="bg-white pt-20 pr-20 pb-20 pl-20">
          <h5 class="mb-20">{{ $t("Basic Information") }}</h5>

          <div class="form-row align-items-center mb-20">
            <label class="col-lg-3 col-4 font-weight-bold fz-12 mb-0">{{
              $t("Name")
            }}</label>
            <div class="col">
              <input
                name="name"
                type="text"
                placeholder="Type here"
                class="theme-input-style"
                v-model="userData.name"
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
          </div>

          <div class="form-row align-items-center mb-20">
            <label class="col-lg-3 col-4 font-weight-bold fz-12 mb-0">{{
              $t("Phone")
            }}</label>
            <div class="col">
              <input
                type="tel"
                v-bind:placeholder="$t('Phone Number')"
                class="theme-input-style"
                required
                v-model="userData.phone"
              />
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

          <div class="form-row align-items-center mb-20">
            <label class="col-lg-3 col-4 font-weight-bold fz-12 mb-0">{{
              $t("Image")
            }}</label>
            <div class="col">
              <div
                class="d-flex align-items-center flex-wrap"
                v-if="userData.image != null"
              >
                <!-- Single Preview -->
                <div
                  class="
                    single-preview-file
                    d-flex
                    align-items-center
                    justify-content-center
                    flex-column
                    radius-8
                    image
                    mr-0
                    mb-0
                  "
                >
                  <img :src="userData.image" :alt="userData.name" />
                  <button
                    title="Remove"
                    class="btn_circle"
                    @click.prevent="removeOldImage"
                  >
                    <span class="material-icons">close</span>
                  </button>
                </div>
              </div>
              <base-file-input
                v-else
                id="customerImageInput"
                name="customerImageInput"
                single
                v-on:getFileInput="customerImage($event)"
              />
            </div>
          </div>
          <div class="form-row align-items-center mb-20">
            <button
              @click.prevent="updateProfile"
              class="btn btn_fill"
              :disabled="update_form_submitted"
            >
              <span v-if="update_form_submitted">
                <CSpinner component="span" size="sm" aria-hidden="true" />
                {{ $t("Please wait") }}
              </span>
              <span v-else>
                {{ $t("Update Profile") }}
              </span>
            </button>
          </div>
        </div>
        <!--End Update basic Info-->
        <!--Change Password-->
        <div class="bg-white pt-20 pr-20 pl-20">
          <h5 class="mb-20">{{ $t("Change Password") }}</h5>

          <div class="form-row align-items-center mb-20">
            <a
              href="#"
              class="link-danger"
              v-if="password_reset_link_processing"
            >
              <CSpinner component="span" size="sm" aria-hidden="true" />
              {{ $t("Please wait") }}...
            </a>
            <a
              href="#"
              class="link-info"
              v-else
              @click.prevent="customerForgotPassword"
              >{{ $t("Generate password reset link") }}</a
            >
          </div>
        </div>
        <!--End Change Password-->
        <!--Change Email-->
        <div class="bg-white pt-20 pr-20 pl-20">
          <h5 class="mb-20">{{ $t("Change Email") }}</h5>

          <div class="form-row align-items-center mb-20">
            <a href="#" class="link-danger" v-if="email_reset_link_processing">
              <CSpinner component="span" size="sm" aria-hidden="true" />
              {{ $t("Please wait") }}...
            </a>
            <a
              v-else
              href="#"
              class="link-info"
              @click.prevent="customerResetEmailLink"
              >{{ $t("Generate email reset link") }}</a
            >
          </div>
        </div>
        <!--End Change Email-->
      </template>
      <template v-if="loading">
        <skeleton class="w-100 mb-20" height="400px"></skeleton>
        <skeleton class="w-100 mb-20" height="100px"></skeleton>
        <skeleton class="w-100" height="100px"></skeleton>
      </template>
    </div>
  </Dashboard>
</template>

<script>
import PageHeader from "@/components/pageheader/PageHeader.vue";
import Dashboard from "@/views/dashboard.vue";
import axios from "axios";
import { CSpinner } from "@coreui/vue";
import { mapState } from "vuex";
export default {
  name: "ManageAccount",
  components: {
    Dashboard,
    PageHeader,
    CSpinner,
  },
  data() {
    return {
      pageTitle: this.$t("Manage Account"),
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
          text: this.$t("Manage Account"),
          active: true,
        },
      ],
      userData: {
        name: "",
        image: "",
        phone_code: "",
        phone: "",
      },
      new_image: "",
      phone_codes: [],
      errors: [],
      password_reset_link_processing: false,
      update_form_submitted: false,
      email_reset_link_processing: false,
      loading: true,
    };
  },
  computed: mapState({
    customerToken: (state) => state.customerToken,
  }),
  mounted() {
    document.title = this.$t("Dashboard") + " | " + this.$t("Manage Account");
    this.getCustomerBasicInfo();
    this.getPhoneCodes();
  },
  methods: {
    /**
     *
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
        .catch((error) => {});
    },
    /**
     * Will get customer besic information
     */
    getCustomerBasicInfo() {
      axios
        .get("/api/v1/ecommerce-core/customer/customer-basic-info", {
          headers: {
            Authorization: `Bearer ${this.customerToken}`,
          },
        })
        .then((response) => {
          if (response.data.success) {
            this.userData = response.data.info;
          } else {
            this.$store.dispatch("customerLogout").then(() => {
              this.$router.push("/");
            });
          }
          this.loading = false;
        })
        .catch((error) => {
          this.loading = false;
          this.$store.dispatch("customerLogout").then(() => {
            this.$router.push("/");
          });
        });
    },
    /**
     * Will remove old image
     */
    removeOldImage() {
      this.userData.image = null;
    },
    /**
     * Will update customer profile
     */
    updateProfile() {
      this.update_form_submitted = true;
      let formData = new FormData();
      formData.append("name", this.userData.name);
      formData.append("id", this.userData.id);
      formData.append("phone", this.userData.phone);
      formData.append("phone_code", this.userData.phone_code);
      formData.append("image", this.new_image);
      formData.append("old_image", this.userData.image);
      axios
        .post(
          "/api/v1/ecommerce-core/customer/update-customer-basic-info",
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
            this.$store
              .dispatch("loggedCustomerInfo", response.data.customer)
              .then(() => {
                this.new_image = "";
                this.userData = response.data.customer;
                this.$toast.success(this.$t("Profile update successfully"));
              });
          } else {
            this.$toast.error(this.$t("Profile update failed"));
          }
          this.update_form_submitted = false;
        })
        .catch((error) => {
          if (error.response.status == 422) {
            this.errors = error.response.data.errors;
          } else {
            this.$toast.error(this.$t("Profile update failed"));
          }
          this.update_form_submitted = false;
        });
    },
    /**
     * Get customer image
     */
    customerImage(e) {
      this.new_image = e[0];
    },
    /**
     * customer forgot password
     */
    customerForgotPassword() {
      this.password_reset_link_processing = true;
      this.errors = [];
      axios
        .post("/api/v1/ecommerce-core/auth/customer-forgot-password", {
          email: this.userData.email,
        })
        .then((response) => {
          if (response.data.success) {
            this.$toast.success(
              this.$t("Reset password link is send to email")
            );
          } else {
            this.$toast.error(
              this.$t("Somethong went wrong. Please try again")
            );
          }
          this.password_reset_link_processing = false;
        })
        .catch((error) => {
          this.password_reset_link_processing = false;
        });
    },
    /**
     * Generate customer email reset link
     */
    customerResetEmailLink() {
      this.email_reset_link_processing = true;
      this.errors = [];
      axios
        .get("/api/v1/ecommerce-core/customer/customer-email-reset-link", {
          headers: {
            Authorization: `Bearer ${this.customerToken}`,
          },
        })
        .then((response) => {
          if (response.data.success) {
            this.$toast.success(this.$t("Email reset link is send to email"));
          } else {
            this.$toast.error(
              this.$t("Somethong went wrong. Please try again")
            );
          }
          this.email_reset_link_processing = false;
        })
        .catch((error) => {
          this.email_reset_link_processing = false;
        });
    },
  },
  head() {
    return {
      title: `${this.$t("Manage Account")}`,
    };
  },
};
</script>
