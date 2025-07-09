<template>
    <section class="cta-section home-page-section container">
        <div class="row align-items-center">
            <div
                v-if="properties.video_url"
                class="col-lg-4 d-flex justify-content-center"
            >
                <video-card :src="properties.video_url" />
            </div>
            <div v-if="properties.cta_image" class="col-lg-4">
                <!-- CTA Image -->
                <div
                    class="cta-image position-relative text-center my-50 my-lg-0"
                >
                    <img :src="properties.cta_image" alt="Featured Image" />
                </div>
                <!-- End CTA Image -->
            </div>
            <div class="col-lg-4">
                <!-- CTA Content -->
                <div
                    class="cta-content position-relative text-white text-center text-lg-start"
                >
                    <span class="d-inline-block section_title" v-if="properties.meta_title_t_">
                        {{ properties.meta_title_t_ }}
                    </span>
                    <h2 class="text-white section_title" v-if="properties.title_t_">
                        {{ properties.title_t_ }}
                    </h2>
                    <p
                        class="mb-3 section_title"
                        v-if="properties.paragraph_t_"
                    >
                        {{ properties.paragraph_t_ }}
                    </p>
                    <router-link
                        v-if="properties.button_text_t_"
                        :to="`/products/${properties.permalink}`"
                        class="text-white btn-underline section_btn"
                    >
                        {{ properties.button_text_t_ }}
                    </router-link>
                </div>
                <!-- End CTA Content -->
            </div>
        </div>
    </section>
</template>
<script>
import { defineAsyncComponent } from "vue";
const VideoCard = defineAsyncComponent(() => import("../../ui/VideoCard.vue"));
export default {
    name: "FeaturedProduct",
    components: {
        VideoCard,
    },
    props: {
        properties: {
            type: Array,
            required: false,
        },
    },

    mounted() {
    },

};
</script>

<style lang="scss" scoped>
@import "../../../assets/sass/00-abstracts/01-variables";
.cta {
    &-section {
        padding: 80px 0;
        background-repeat: no-repeat;
        z-index: 99;
        @media (max-width: 991px) {
            padding: 60px 10px;
        }
        @media (min-width: 992px) {
            background-size: cover;
            &::before {
                width: 50%;
                height: 100%;
                clip-path: polygon(0 0, 100% 0%, 100% 100%, 20% 100%);
            }
        }
    }
    &-content {
        span,
        p {
            font-size: 18px;
            line-height: 24px;
            font-weight: 500;
        }
        h2 {
            font-size: 42px;
            $lh: 1.19;
            line-height: $lh;
            margin: 6px 0;
        }
        .slide-price {
            margin-bottom: 6px;
        }
    }
    &-shape {
        opacity: 0.6;
        &.top {
            left: 55%;
            top: 0;
        }
        &.bottom {
            right: 0;
            bottom: 0;
        }
    }
}

.btn-underline {
    font-size: 24px;
    font-weight: bold;
    font-family: $title-font;
    &:hover {
        text-decoration: underline;
        opacity: 0.9;
    }
}
</style>
