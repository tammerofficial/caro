<template>
  <div class="">
    <page-header class="pt-3 pb-3" :items="bItems" />
    <div class="pt-60 pb-60 light-bg">
      <div class="custom-container2">
        <div class="login-form-wrap">
          <form class="loginForm white-box px-3 py-4 p-md-5">
            <h3 class="mb-0">{{ $t("Forgot password") }} ?</h3>
            <p class="mb-4">
              {{ $t("Enter your email address to recover your password") }}.
            </p>
            <p v-bind:class="notificationClass" v-if="notification">
              {{ notification }}
            </p>
            <div class="row">
              <div class="col-12">
                <div class="form-group mb-20">
                  <label class="font-weight-bold fz-12 mb-2">
                    {{ $t("Email") }} <span class="text-danger">*</span></label
                  >
                  <div class="">
                    <input
                      type="email"
                      v-bind:placeholder="$t('Email')"
                      class="theme-input-style"
                      v-model="email"
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
            </div>

            <div class="row">
              <div class="col-12 my-3">
                <button class="btn btn-fill col-12 d-block" v-if="submitted">
                  <CSpinner component="span" size="sm" aria-hidden="true" />
                  {{ $t("Please wait") }}...
                </button>
                <button
                  @click.prevent="customerForgotPassword"
                  class="btn btn-fill col-12 d-block"
                  v-else
                >
                  {{ $t("Send Password Reset Link") }}
                </button>
              </div>

              <div class="col-12">
                <span class="d-block mt-3">
                  <router-link to="/login" class="btn_underline">{{
                    $t("Back to Login")
                  }}</router-link>
                </span>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import PageHeader from "@/components/pageheader/PageHeader.vue";
import { CSpinner } from "@coreui/vue";
import axios from "axios";
export default {
  name: "ForgotPassword",
  components: {
    PageHeader,
    CSpinner,
  },
  data() {
    return {
      bItems: [
        {
          text: this.$t("Home"),
          href: "/",
        },
        {
          text: this.$t("Forgot password"),
          active: true,
        },
      ],
      email: "",
      errors: [],
      notification: "",
      notificationClass: "alert alert-info",
      submitted: false,
    };
  },
  mounted() {
    document.title = this.$t("Forgot password");
  },
  methods: {
    /**
     * customer forgot password
     */
    customerForgotPassword() {
      this.submitted = true;
      this.errors = [];
      axios
        .post("/api/v1/ecommerce-core/auth/customer-forgot-password", {
          email: this.email,
        })
        .then((response) => {
          if (response.data.success) {
            this.$toast.success(
              this.$t("Reset password link is send to email")
            );
            this.email = "";
          } else {
            this.$toast.error(
              this.$t("Something went wrong. Please try again")
            );
          }
          this.submitted = false;
        })
        .catch((error) => {
          this.submitted = false;
          if (error.response.status == 422) {
            this.errors = error.response.data.errors;
          }
        });
    },
  },
};
</script>

