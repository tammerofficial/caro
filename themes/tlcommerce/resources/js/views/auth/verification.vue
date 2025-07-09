<template>
  <div class="">
    <page-header class="pt-3 pb-3" :items="bItems" />
    <div class="pt-60 pb-60 light-bg">
      <div class="custom-container2">
        <div class="loginForm white-box px-3 py-4 p-md-5">
          <a v-if="processing">
            <CSpinner component="span" size="sm" aria-hidden="true" />
            {{ $t("verify your email, please wait") }}...
          </a>
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
  name: "CustomerEmailVerification",
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
          text: this.$t("Email Verification"),
          active: true,
        },
      ],
      processing: false,
    };
  },
  computed: {
    identifier() {
      return this.$route.query.u || null;
    },
  },
  mounted() {
    this.verifyCustomerEmail();
    document.title = this.$t("Email Verification");
  },
  methods: {
    /**
     * Verify customer email
     */
    verifyCustomerEmail() {
      if (this.identifier != null) {
        this.processing = true;
        axios
          .post("/api/v1/ecommerce-core/auth/verify-customer-email", {
            identifier: this.identifier,
          })
          .then((response) => {
            if (response.data.success) {
              this.processing = true;
              this.$toast.success(this.$t("Email verification successful"));
              this.$router.push("/login");
            } else {
              this.processing = false;
              this.$toast.error(this.$t("Invalid request"));
              this.$router.push("/");
            }
          })
          .catch((error) => {
            this.processing = false;
            this.$toast.error(this.$t("Invalid request"));
            this.$router.push("/");
          });
      } else {
        this.$router.push("PageNotExist");
      }
    },
  },
};
</script>