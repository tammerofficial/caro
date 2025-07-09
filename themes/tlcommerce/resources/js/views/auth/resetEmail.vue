<template>
  <div class="">
    <page-header class="pt-3 pb-3" :items="bItems" />
    <div class="pt-60 pb-60 light-bg" v-if="is_checked">
      <div class="custom-container2">
        <div class="login-form-wrap">
          <form class="loginForm white-box px-3 py-4 p-md-5">
            <h3 class="mb-4">{{ $t("Change Email") }}</h3>
            <template v-if="is_valid">
              <div class="row">
                <div class="col-12">
                  <div class="form-group mb-20">
                    <label class="font-weight-bold fz-12 mb-2">
                      {{ $t("New Email")
                      }}<span class="text-danger">*</span></label
                    >
                    <div class="">
                      <input
                        type="email"
                        v-bind:placeholder="$t('Email')"
                        class="theme-input-style"
                        required
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
                  <button
                    @click.prevent="resetCustomerEmail"
                    class="btn btn-fill"
                  >
                    {{ $t("Update Email") }}
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
import { mapState } from "vuex";
export default {
  name: "ResetEmail",
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
          text: this.$t("Change Email"),
          active: true,
        },
      ],
      email: "",
      is_checked: true,
      is_valid: true,
      errors: [],
    };
  },

  computed: mapState({
    customerToken: (state) => state.customerToken,
    identifier() {
      return this.$route.query.u || null;
    },
  }),
  mounted() {
    document.title = this.$t("Email reset");
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
     * Will reset customer email
     */
    resetCustomerEmail() {
      this.errors = [];
      axios
        .post("/api/v1/ecommerce-core/auth/customer-reset-email", {
          identifier: this.identifier,
          email: this.email,
        })
        .then((response) => {
          if (response.data.success) {
            this.$toast.success(this.$t("Email reset successfully"));
            this.$store.dispatch("customerLogout").then(() => {
              this.$router.push("/login");
            });
          } else {
            this.$toast.error(this.$t("Email reset failed"));
          }
        })
        .catch((error) => {
          if (error.response.status == 422) {
            this.errors = error.response.data.errors;
          } else {
            this.$toast.error(this.$t("Email reset failed"));
          }
        });
    },
  },
};
</script>
