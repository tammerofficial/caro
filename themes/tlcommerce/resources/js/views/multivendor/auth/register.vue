<template>
  <div class="">
    <page-header class="pt-3 pb-3" :items="bItems" />
    <div class="pt-60 pb-60 light-bg">
      <div class="custom-container2">
        <div class="col-lg-5 mx-auto p-md-5 px-3 py-4 white-box">
          <p v-bind:class="notificationClass" v-if="notification">
            {{ notification }}
          </p>
          <!--Seller Information-->
          <div class="row">
            <h3 class="mb-4">{{ $t("Seller Registration") }}</h3>
            <h4 class="mb-4 text-secondary">
              {{ $t("Personal Information") }}
            </h4>
            <div class="col-lg-12">
              <div class="form-group mb-20">
                <label class="font-weight-bold fz-12 mb-2">
                  {{ $t("Name") }} <span class="text-danger">*</span>
                </label>
                <div class="">
                  <input
                    type="text"
                    v-bind:placeholder="$t('Name')"
                    class="theme-input-style"
                    v-model="sellerData.name"
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
            </div>
            <div class="col-lg-12">
              <div class="form-group mb-20">
                <label class="font-weight-bold fz-12 mb-2">
                  {{ $t("Email") }} <span class="text-danger">*</span>
                </label>
                <div class="">
                  <input
                    type="email"
                    v-bind:placeholder="$t('Email')"
                    class="theme-input-style"
                    required
                    v-model="sellerData.email"
                  />
                  <template v-if="errors.email">
                    <p
                      class="fz-12 text-danger mt-1"
                      v-for="(error, index) in errors.email"
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
                  {{ $t("Phone") }} <span class="text-danger">*</span>
                </label>
                <div class="">
                  <div class="phone-number-wrap d-flex">
                    <input
                      type="tel"
                      v-bind:placeholder="$t('Phone Number')"
                      class="theme-input-style"
                      required
                      v-model="sellerData.phone"
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
            <div class="col-lg-12">
              <div class="form-group mb-20">
                <label class="font-weight-bold fz-12 mb-2">
                  {{ $t("Password") }}<span class="text-danger">*</span>
                </label>
                <div class="">
                  <input
                    type="password"
                    v-bind:placeholder="$t('Password')"
                    class="theme-input-style"
                    required
                    v-model="sellerData.password"
                  />
                  <template v-if="errors.password">
                    <p
                      class="fz-12 text-danger mt-1"
                      v-for="(error, index) in errors.password"
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
                  {{ $t("Confirm Password") }}<span class="text-danger">*</span>
                </label>
                <div class="">
                  <input
                    id="confirmPassword"
                    type="password"
                    v-bind:placeholder="$t('Confirm Password')"
                    class="theme-input-style"
                    required
                    v-model="sellerData.password_confirmation"
                  />
                </div>
              </div>
            </div>
          </div>
          <!--End Seller Information-->
          <!--Shop Information-->
          <div class="row">
            <h4 class="mb-4 text-secondary">{{ $t("Shop Information") }}</h4>

            <div class="col-lg-12">
              <div class="form-group mb-20">
                <label class="font-weight-bold fz-12 mb-2">
                  {{ $t("Shop Name") }} <span class="text-danger">*</span>
                </label>
                <div class="">
                  <input
                    type="text"
                    v-bind:placeholder="$t('Shop Name')"
                    class="theme-input-style"
                    v-model="sellerData.shop_name"
                    @change="generateShopSlug('name')"
                  />
                  <template v-if="errors.shop_name">
                    <p
                      class="fz-12 text-danger mt-1"
                      v-for="(error, index) in errors.shop_name"
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
                  {{ $t("Shop Url") }} <span class="text-danger">*</span>
                </label>
                <div class="">
                  <div class="align-items-center d-flex shop-url">
                    <p class="link-info mb-0">
                      {{ shop_base_url }}<b>{{ sellerData.shop_url }}</b>
                    </p>
                    <button
                      class="btn btn-sm fz-14 ml-10"
                      @click.prevent="
                        () => {
                          edit_slug = !edit_slug;
                        }
                      "
                    >
                      {{ $t("Edit") }}
                    </button>
                  </div>

                  <div class="slug-input mt-2" v-if="edit_slug">
                    <input
                      type="text"
                      v-bind:placeholder="$t('Shop Url')"
                      class="theme-input-style mb-2"
                      required
                      v-model="sellerData.shop_url"
                      @change="generateShopSlug('slug')"
                    />
                    <button
                      class="btn btn-sm fz-14"
                      @click.prevent="generateShopSlug('slug')"
                    >
                      {{ $t("Save Change") }}
                    </button>
                  </div>

                  <template v-if="errors.shop_url">
                    <p
                      class="fz-12 text-danger mt-1"
                      v-for="(error, index) in errors.shop_url"
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
                  {{ $t("Shop Phone") }} <span class="text-danger">*</span>
                </label>
                <div class="">
                  <input
                    type="text"
                    v-bind:placeholder="$t('Shop Phone')"
                    class="theme-input-style"
                    required
                    v-model="sellerData.shop_phone"
                  />
                  <template v-if="errors.shop_phone">
                    <p
                      class="fz-12 text-danger mt-1"
                      v-for="(error, index) in errors.shop_phone"
                      :key="index"
                    >
                      {{ error }}
                    </p>
                  </template>
                </div>
              </div>
            </div>
          </div>
          <!--End Shop Information-->
          <div class="row form-group align-items-center">
            <div class="col-12 d-flex align-items-center">
              <input
                type="checkbox"
                id="term"
                v-model="term_condition_agreement"
              />
              <label class="checkmark" for="term">
                <span>
                  {{ $t("I have read and agree to the ") }}
                </span>
                <router-link
                  :to="`/page/${siteSettings.seller_term_condition_page_slug}`"
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
                @click.prevent="sellerRegistration"
                :disabled="formSubmitting"
                class="btn btn-fill"
              >
                <span v-if="formSubmitting">
                  <CSpinner component="span" size="sm" aria-hidden="true" />
                  {{ $t("Please wait") }}
                </span>
                <span v-else>
                  {{ $t("Register") }}
                </span>
              </button>
            </div>
            <div class="col-12 mt-3">
              {{ $t("Already have an account") }} ?
              <a href="/seller/login" class="btn_underline">
                {{ $t("Login Here") }}
              </a>
            </div>
          </div>
        </div>
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
      pageTitle: "Seller Register",
      bItems: [
        {
          text: this.$t("Home"),
          href: "/",
        },
        {
          text: this.$t("Seller Register"),
          active: true,
        },
      ],
      sellerData: {
        name: "",
        email: "",
        phone: "",
        password: "",
        password_confirmation: "",
        shop_name: "",
        shop_url: "",
        shop_phone: "",
      },

      term_condition_agreement: false,
      term_condition_agreement_error: "",
      notification: "",
      notificationClass: "alert alert-info",
      errors: [],
      phone_codes: [],
      edit_slug: false,
      formSubmitting: false,
      shop_base_url: window.location.origin + "/shop/",
    };
  },
  computed: mapState({
    siteSettings: (state) => state.siteSettings,
  }),
  mounted() {
    document.title = this.$t("Seller Registration");
  },
  methods: {
    /**
     * Will generate shop slug
     *
     */
    generateShopSlug(input) {
      this.$store.dispatch("showPreloader", true);
      let slug = this.sellerData.shop_url;
      if (input == "name") {
        slug = this.sellerData.shop_name;
      }
      axios
        .post("api/v1/multivendor/seller-shop-availability-checking", {
          slug: slug,
        })
        .then((response) => {
          if (response.data.success) {
            this.sellerData.shop_url = response.data.slug;
          }
          this.$store.dispatch("showPreloader", false);
        })
        .catch((error) => {
          if (error.response.status == 422) {
            this.errors = error.response.data.errors;
          }
          this.$store.dispatch("showPreloader", false);
        });
    },
    /**
     * Will register a new seller
     *
     */
    sellerRegistration() {
      this.formSubmitting = true;
      this.term_condition_agreement_error = "";
      this.notification = "";
      this.errors = [];
      if (this.term_condition_agreement) {
        axios
          .post("api/v1/multivendor/seller-registration", {
            name: this.sellerData.name,
            email: this.sellerData.email,
            phone: this.sellerData.phone,
            password: this.sellerData.password,
            password_confirmation: this.sellerData.password_confirmation,
            shop_name: this.sellerData.shop_name,
            shop_phone: this.sellerData.shop_phone,
            shop_url: this.sellerData.shop_url,
          })
          .then((response) => {
            if (response.data.success) {
              this.$toast.success(this.$t("Registration successful"));
              this.sellerData.name = "";
              this.sellerData.email = "";
              this.sellerData.phone = "";
              this.sellerData.password = "";
              this.sellerData.password_confirmation = "";
              this.sellerData.shop_name = "";
              this.sellerData.shop_phone = "";
              this.sellerData.shop_url = "";
              this.term_condition_agreement = false;
              window.location.href = "/seller/login";
            } else {
              this.$toast.error(this.$t("Registration failed"));
              this.formSubmitting = false;
            }
          })
          .catch((error) => {
            if (error.response.status == 422) {
              this.errors = error.response.data.errors;
            }
            this.formSubmitting = false;
          });
      } else {
        this.term_condition_agreement_error = this.$t(
          "Check terms and condition"
        );
        this.formSubmitting = false;
      }
    },
  },
};
</script>
