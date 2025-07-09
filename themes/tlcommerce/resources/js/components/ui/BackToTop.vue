<template>
    <div
        v-if="backToTopStyle.back_to_top_button==1"
        :class="{ active: scY > 300 }"
        class="custom-back-to-top back-to-top d-flex align-items-center justify-content-center"
        @click="toTop"
    >
        <template v-if="backToTopStyle.custom_back_to_top_button == 0 || backToTopStyle.custom_back_to_top_button_icon == null">
          <base-icon-svg name="angleTop" :width="16" :height="16" />
        </template>
        <template v-else>
            <i :class="'fa '+backToTopStyle.custom_back_to_top_button_icon"></i>
        </template>
    </div>
</template>

<script>
import axios from "axios";
export default {
    data() {
        return {
            backToTopStyle:{},
            scTimer: 0,
            scY: 0,
        };
    },
    mounted() {
        window.addEventListener("scroll", this.handleScroll);
        this.getBackToTopStyle();
    },

    methods: {
        handleScroll() {
            if (this.scTimer) return;
            this.scTimer = setTimeout(() => {
                this.scY = window.scrollY;
                clearTimeout(this.scTimer);
                this.scTimer = 0;
            }, 100);
        },
        toTop() {
            window.scrollTo({
                top: 0,
                behavior: "smooth",
            });
        },
        /**
         * Get back to top style
         */
        getBackToTopStyle() {
            const headers = {
                "Content-Type": "application/json",
                "Accept-Language": localStorage.getItem("locale") || "en",
            };

            axios
                .get("/api/theme/tlcommerce/v1/get-back-to-top-style", {
                    headers: headers,
                })
                .then((response) => {
                    if (response.data.success) {
                        this.backToTopStyle = response.data.style;
                    }
                })
                .catch((error) => {});
        },
    },
};
</script>

<style lang="scss" scoped>
@import "../../assets/sass/00-abstracts/01-variables";
.back-to-top {
    position: fixed;
    bottom: 50px;
    right: 50px;
    background-color: $c1;
    border-radius: 50%;
    transition: 0.3s ease-in;
    cursor: pointer;
    transform: translateX(10px);
    opacity: 0;
    visibility: hidden;
    font-size: 16px;
    width: 50px;
    height: 50px;
    color: #fff !important;
    z-index: 1000;
    @media only screen and (max-width: 767px) {
        display: none !important;
    }
    &.active {
        transform: translateX(0);
        opacity: 1;
        visibility: visible;
    }
    &:hover {
        background-color: #22303f;
        color: #fff !important;
    }
}
</style>