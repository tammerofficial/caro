<template>
  <div class="">
    <page-header class="pt-3 pb-3" :items="bItems" />
    <div class="pt-60 pb-60 light-bg" v-if="is_checked">
      <div class="custom-container2">
        <div class="login-form-wrap">
          <form class="loginForm white-box px-3 py-4 p-md-5">
            <h3 class="mb-4">{{ $t("Reset password") }}</h3>
            <template v-if="is_valid">
              <div class="row">
                <div class="col-12">
                  <div class="form-group mb-20">
                    <label class="font-weight-bold fz-12 mb-2">
                      {{ $t("New Password")
                      }}<span class="text-danger">*</span></label
                    >
                    <div class="">
                      <input
                        type="password"
                        v-bind:placeholder="$t('Password')"
                        class="theme-input-style"
                        required
                        v-model="password"
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
                  <div class="form-group mb-20">
                    <label
                      for="confirmPassword"
                      class="font-weight-bold fz-12 mb-2"
                    >
                      {{ $t("Confirm Password")
                      }}<span class="text-danger">*</span></label
                    >
                    <div class="">
                      <input
                        id="confirmPassword"
                        type="password"
                        v-bind:placeholder="$t('Confirm Password')"
                        class="theme-input-style"
                        required
                        v-model="password_confirmation"
                      />
                    </div>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-12 my-3">
                  <button
                    @click.prevent="resetCustomerPassword"
                    class="btn btn-fill"
                  >
                    {{ $t("Change Password") }}
                  </button>
                </div>
              </div>
            </template>
            <template v-else>
              <div class="col-12">
                <span class="d-block mt-3">
                  {{ $t("This link has expired") }}.
                  <router-link to="/password/forgot" class="btn_underline">
                    {{ $t("Regenerate Link") }}
                  </router-link>
                </span>
              </div>
            </template>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import PageHeader from "@/components/pageheader/PageHeader.vue";
import axios from "axios";
export default {
  name: "ResetPassword",
  components: {
    PageHeader,
  },
  data() {
    return {
      bItems: [
        {
          text: this.$t("Home"),
          href: "/",
        },
        {
          text: this.$t("Reset password"),
          active: true,
        },
      ],
      password: "",
      password_confirmation: "",
      is_checked: false,
      is_valid: false,
      errors: [],
    };
  },
  computed: {
    identifier() {
      return this.$route.query.u || null;
    },
  },
  mounted() {
    document.title = this.$t("Reset password");
    if (this.identifier == null) {
      this.$router.push("PageNotExist");
    }
    this.verifyResetPasswordLink();
  },
  methods: {
    /**
     * Verify reset password link
     */
    verifyResetPasswordLink() {
      axios
        .post(
          "/api/v1/ecommerce-core/auth/verify-customer-reset-password-token",
          {
            identifier: this.identifier,
          }
        )
        .then((response) => {
          if (response.data.success) {
            this.is_checked = true;
            this.is_valid = true;
          } else {
            this.is_checked = true;
            this.is_valid = false;
          }
        })
        .catch((error) => {
          this.is_checked = true;
          this.is_valid = false;
        });
    },
    /**
     * Will reset customer password
     */
    resetCustomerPassword() {
      this.errors = [];
      axios
        .post("/api/v1/ecommerce-core/auth/customer-reset-password", {
          identifier: this.identifier,
          password: this.password,
          password_confirmation: this.password_confirmation,
        })
        .then((response) => {
          if (response.data.success) {
            this.$toast.success(this.$t("Password reset successful"));
            this.$router.push("/login");
          } else {
            this.$toast.error(this.$t("Password reset failed"));
          }
        })
        .catch((error) => {
          if (error.response.status == 422) {
            this.errors = error.response.data.errors;
          } else {
            this.$toast.error(this.$t("Password reset failed"));
          }
        });
    },
  },
};
</script>
