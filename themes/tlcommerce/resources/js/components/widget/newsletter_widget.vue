<template>
  <!-- Widget Newsletter -->
  <div
    class="widget widget_newsletter"
    :class="{
      'no-style': noStyle,
      'style--two': styleTwo,
      'style--three': styleThree,
    }"
  >
    <template v-if="newsletter_widget != null">
      <h3
        :class="
          this.footerStyle.custom_footer == 1
            ? 'custom-title-style'
            : 'widget-title'
        "
      >
        {{ newsletter_widget.widget_title }}
      </h3>

      <p>{{ newsletter_widget.newsletter_short_desc }}</p>

      <!-- Newsletter Form -->
      <form :action="newsletterAction" method="post">
        <template v-if="styleTwo">
          <div class="input-group title-font">
            <input
              v-model="email"
              :class="
                this.subscriptionFormStyle.custom_subscription == 1
                  ? 'form-control mb-15 custom-input-style'
                  : 'form-control mb-15'
              "
              type="email"
              placeholder="Enter Your Email.."
            />
            <button
              @click="subscribe"
              type="submit"
              :class="
                this.subscriptionFormStyle.custom_subscription == 1
                  ? 'custom-subs-btn'
                  : 'btn'
              "
            >
              {{ $t("Subscribe") }}
            </button>
          </div>
        </template>

        <template v-else>
          <input
            type="email"
            v-model="email"
            :class="
              this.subscriptionFormStyle.custom_subscription == 1
                ? 'form-control mb-15 custom-input-style'
                : 'form-control mb-15'
            "
            :placeholder="
              this.subscriptionFormStyle.custom_subscription == 1
                ? this.subscriptionFormStyle.subscribe_form_placeholder
                : $t('Enter your email')
            "
          />
          <button
            @click="subscribe"
            type="button"
            :class="
              this.subscriptionFormStyle.custom_subscription == 1
                ? 'custom-subs-btn btn rounded-0'
                : 'btn c3-bg rounded-0'
            "
          >
            <span v-if="this.subscriptionFormStyle.custom_subscription == 1">{{
              this.subscriptionFormStyle.subscribe_form_button_text
            }}</span>
            <span v-else>{{ $t("Subscribe") }}</span>
          </button>
        </template>
      </form>
      <!-- End Newsletter Form -->
    </template>
  </div>
</template>
<script>
const axios = require("axios").default;
export default {
  name: "newsletter_widget",
  props: {
    styleTwo: {
      type: Boolean,
      default: false,
    },
    styleThree: {
      type: Boolean,
      default: false,
    },
    newsletterAction: {
      type: String,
      default: "#",
    },
    footerStyle: {
      type: Object,
      required: false,
      default: () => {
        return {};
      },
    },
    subscriptionFormStyle: {
      type: Object,
      required: false,
      default: () => {
        return {};
      },
    },
    newsletter_widget: {
      type: Object,
      required: false,
      default: () => {
        return {};
      },
    },
  },
  data() {
    return {
      email: "",
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
