<template>
  <div class="col-10 mx-auto">
    <form :action="newsletterAction" method="post">
      <div class="row mb-20">
        <div class="form-group col-12">
          <input
            type="email"
            v-model="email"
            class="theme-input-style"
            :placeholder="$t('Enter your email')"
          />
        </div>
      </div>
      <div class="mb-45 mx-0 row">
        <button @click="subscribe" type="button" class="btn d-block">
          {{ $t("Subscribe") }}
        </button>
      </div>
    </form>
  </div>
</template>
<script>
const axios = require("axios").default;
export default {
  name: "SubscribeForm",
  data() {
    return {
      email: "",
      newsletterAction: "#",
    };
  },
  methods: {
    subscribe() {
      axios
        .post("/api/theme/tlcommerce/v1/newsletter-store", {
          email: this.email,
        })
        .then((response) => {
          if (response.data.success) {
            this.$toast.success(response.data.message);
          } else {
            this.$toast.error(response.data.message);
          }
        })
        .catch((error) => {});
    },
  },
};
</script>
