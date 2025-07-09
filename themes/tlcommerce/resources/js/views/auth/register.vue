<template>
  <div class="">
      <page-header class="pt-3 pb-3" :items="bItems" />
      <div class="pt-60 pb-60 light-bg">
          <div class="custom-container2">
              <template v-if="$store.state.siteProperties.customer_limit_over == 0">
                  <div class="col-lg-5 mx-auto p-md-5 px-3 py-4 white-box">
                      <p v-bind:class="notificationClass" v-if="notification">
                          {{ notification }}
                      </p>
                      <div class="row">
                          <h2 class="mb-4">{{ $t("Registration") }}</h2>
                          <div class="col-lg-12">
                              <div class="form-group mb-20">
                                  <label class="font-weight-bold fz-12 mb-2">
                                      {{ $t("Name") }}
                                      <span class="text-danger"
                                          >*</span
                                      ></label
                                  >
                                  <div class="">
                                      <input
                                          type="text"
                                          v-bind:placeholder="$t('Name')"
                                          class="theme-input-style"
                                          v-model="customerData.name"
                                      />
                                      <template v-if="errors.name">
                                          <p
                                              class="fz-12 text-danger mt-1"
                                              v-for="(
                                                  error, index
                                              ) in errors.name"
                                              :key="index"
                                          >
                                              {{ error }}
                                          </p>
                                      </template>
                                  </div>
                              </div>
                          </div>
                          <div class="col-lg-12">
                              <div class="form-group mb-20">
                                  <label class="font-weight-bold fz-12 mb-2">
                                      {{ $t("Email") }}
                                      <span class="text-danger"
                                          >*</span
                                      ></label
                                  >
                                  <div class="">
                                      <input
                                          type="email"
                                          v-bind:placeholder="$t('Email')"
                                          class="theme-input-style"
                                          required
                                          v-model="customerData.email"
                                      />
                                      <template v-if="errors.email">
                                          <p
                                              class="fz-12 text-danger mt-1"
                                              v-for="(
                                                  error, index
                                              ) in errors.email"
                                              :key="index"
                                          >
                                              {{ error }}
                                          </p>
                                      </template>
                                  </div>
                              </div>
                          </div>
                          <div class="col-lg-12">
                              <div class="form-group mb-20">
                                  <label class="font-weight-bold fz-12 mb-2">
                                      {{ $t("Phone") }}
                                      <span class="text-danger"
                                          >*</span
                                      ></label
                                  >
                                  <div class="">
                                      <div class="phone-number-wrap d-flex">
                                          <input
                                              type="tel"
                                              v-bind:placeholder="
                                                  $t('Phone Number')
                                              "
                                              class="theme-input-style"
                                              required
                                              v-model="customerData.phone"
                                          />
                                      </div>
                                      <template v-if="errors.phone">
                                          <p
                                              class="fz-12 text-danger mt-1"
                                              v-for="(
                                                  error, index
                                              ) in errors.phone"
                                              :key="index"
                                          >
                                              {{ error }}
                                          </p>
                                      </template>
                                  </div>
                              </div>
                          </div>
                          <div class="col-lg-12">
                              <div class="form-group mb-20">
                                  <label class="font-weight-bold fz-12 mb-2">
                                      {{ $t("Password")
                                      }}<span class="text-danger"
                                          >*</span
                                      ></label
                                  >
                                  <div class="">
                                      <input
                                          type="password"
                                          v-bind:placeholder="$t('Password')"
                                          class="theme-input-style"
                                          required
                                          v-model="customerData.password"
                                      />
                                      <template v-if="errors.password">
                                          <p
                                              class="fz-12 text-danger mt-1"
                                              v-for="(
                                                  error, index
                                              ) in errors.password"
                                              :key="index"
                                          >
                                              {{ error }}
                                          </p>
                                      </template>
                                  </div>
                              </div>
                          </div>
                          <div class="col-lg-12">
                              <div class="form-group mb-20">
                                  <label
                                      for="confirmPassword"
                                      class="font-weight-bold fz-12 mb-2"
                                  >
                                      {{ $t("Confirm Password")
                                      }}<span class="text-danger"
                                          >*</span
                                      ></label
                                  >
                                  <div class="">
                                      <input
                                          id="confirmPassword"
                                          type="password"
                                          v-bind:placeholder="
                                              $t('Confirm Password')
                                          "
                                          class="theme-input-style"
                                          required
                                          v-model="
                                              customerData.password_confirmation
                                          "
                                      />
                                  </div>
                              </div>
                          </div>
                      </div>
                      <div class="row form-group align-items-center">
                          <div class="col-12 d-flex align-items-center">
                              <input
                                  type="checkbox"
                                  id="term"
                                  v-model="term_condition_agreement"
                              />
                              <label class="checkmark" for="term">
                                  <span>
                                      {{
                                          $t("I have read and agree to the ")
                                      }}
                                  </span>
                                  <router-link
                                      :to="`/page/${siteSettings.customer_term_condition_page_slug}`"
                                      target="_blank"
                                      class="c1"
                                  >
                                      {{ $t("terms and conditions") }}
                                  </router-link>
                              </label>
                          </div>
                          <p
                              class="fz-12 text-danger mt-1"
                              v-if="term_condition_agreement_error"
                          >
                              {{ term_condition_agreement_error }}
                          </p>
                      </div>
                      <div class="row">
                          <div class="col-12 mt-3">
                              <button
                                  @click.prevent="customerRegister"
                                  :disabled="formSubmitting"
                                  class="btn btn-fill"
                              >
                                  <span v-if="formSubmitting">
                                      <CSpinner
                                          component="span"
                                          size="sm"
                                          aria-hidden="true"
                                      />
                                      {{ $t("Please wait") }}
                                  </span>
                                  <span v-else>
                                      {{ $t("Register") }}
                                  </span>
                              </button>
                          </div>
                          <div class="col-12 mt-3">
                              {{ $t("Already have an account") }} ?
                              <router-link to="/login" class="btn_underline">
                                  {{ $t("Login Here") }}
                              </router-link>
                          </div>
                      </div>
                  </div>
              </template>
              <template v-else>
                <div class="col-lg-5 mx-auto p-md-5 px-3 py-4 white-box">
                      <h6>
                        {{ $t("Customer registration service is currently unavailable, please contact with admin") }}
                      </h6>
                </div>
              </template>
          </div>
      </div>
  </div>
</template>

<script>
import { mapState } from "vuex";
import PageHeader from "@/components/pageheader/PageHeader.vue";
import { CSpinner } from "@coreui/vue";
import axios from "axios";
export default {
  components: {
      PageHeader,
      CSpinner,
  },
  data() {
      return {
          pageTitle: "Register",
          bItems: [
              {
                  text: this.$t("Home"),
                  href: "/",
              },
              {
                  text: this.$t("Register"),
                  active: true,
              },
          ],
          customerData: {
              name: "",
              email: "",
              phone: "",
              phone_code:
                  localStorage.getItem("country") != null
                      ? JSON.parse(localStorage.getItem("country")).phone_code
                      : "",
              password: "",
              password_confirmation: "",
          },
          term_condition_agreement: false,
          term_condition_agreement_error: "",
          notification: "",
          notificationClass: "alert alert-info",
          errors: [],
          phone_codes: [],
          formSubmitting: false,
      };
  },
  computed: mapState({
      siteSettings: (state) => state.siteSettings,
  }),
  mounted() {
      document.title = this.$t("Registration");
      this.getPhoneCodes();
  },
  methods: {
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
       * Will register a new customer
       *
       */
      customerRegister() {
          this.formSubmitting = true;
          this.term_condition_agreement_error = "";
          this.notification = "";
          this.errors = [];
          if (this.term_condition_agreement) {
              axios
                  .post("/api/v1/ecommerce-core/auth/customer-registration", {
                      name: this.customerData.name,
                      email: this.customerData.email,
                      phone_code: this.customerData.phone_code,
                      phone: this.customerData.phone,
                      password: this.customerData.password,
                      password_confirmation:
                          this.customerData.password_confirmation,
                  })
                  .then((response) => {
                      if (
                          response.data.success &&
                          response.data.customer != null
                      ) {
                          if (
                              response.data.customer.verified_at == null &&
                              response.data.customer.status == 2
                          ) {
                              this.notification = this.$t(
                                  "Registration successful. check your email to verify your email"
                              );
                              this.notificationClass = "alert alert-success";
                              this.customerData.name = "";
                              this.customerData.email = "";
                              this.customerData.phone = "";
                              this.customerData.password = "";
                              this.customerData.password_confirmation = "";
                              this.term_condition_agreement = false;
                          } else {
                              this.$toast.success(
                                  this.$t("Registration successful")
                              );
                              this.$router.push("Login");
                          }
                      } else {
                          this.$toast.error(this.$t("Registration failed"));
                      }
                      this.formSubmitting = false;
                  })
                  .catch((error) => {
                      if (error.response.status == 422) {
                          this.errors = error.response.data.errors;
                      }
                      this.formSubmitting = false;
                  });
          } else {
              this.term_condition_agreement_error = this.$t(
                  "Check terms and conditions"
              );
              this.formSubmitting = false;
          }
      },
  },
};
</script>