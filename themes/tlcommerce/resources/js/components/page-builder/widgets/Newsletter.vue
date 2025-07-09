<template>
    <p>{{ properties["short_desc_t_"] }}</p>

    <!-- Newsletter Form -->
    <form action="#" method="post" @submit.prevent>
        <input
            v-model="email"
            type="email"
            class="form-control mb-15"
            :placeholder="properties['email_placeholder_t_']"
        />
        <button
            ref="newsletterBtn"
            @click="subscribe"
            type="submit"
            class="btn rounded-0"
        >
            {{ properties["btn_text_t_"] }}
        </button>
    </form>
    <!-- End Newsletter Form -->
</template>

<script>
const axios = require("axios").default;

export default {
    name: "Newsletter",
    props: {
        properties: {
            type: Object,
            default: {},
        },
    },

    data() {
        return {
            email: "",
        };
    },

    methods: {
        /**
         * Newsletter Subscription
         */
        subscribe() {
            this.$refs.newsletterBtn.blur();

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
