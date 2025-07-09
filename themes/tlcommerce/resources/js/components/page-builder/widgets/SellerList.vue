<template>
    <!-- Top Sellers -->
    <section class="top-seller-section home-page-section">
        <swiper
            v-if="sellers.length && properties.style == 'slider'"
            :slidesPerView="slider_items.desktop"
            :modules="modules"
            :spaceBetween="1"
            :autoplay="{
                delay: 2500,
                disableOnInteraction: false,
                pauseOnMouseEnter: true,
            }"
            :loop="true"
            :pagination="pagination"
            class="product-grid-slider theme-slider-dots"
            :breakpoints="{
                '0': {
                    slidesPerView: slider_items.mobile,
                },
                '768': {
                    slidesPerView: slider_items.tab,
                },
                '1024': {
                    slidesPerView: slider_items.desktop,
                },
            }"
        >
            <swiper-slide
                v-for="(shop, index) in sellers"
                :key="`slide-${index}`"
            >
                <single-shop :shop="shop" hasBanner v-if="banner"></single-shop>
                <single-shop :shop="shop" v-else></single-shop>
            </swiper-slide>
        </swiper>
        <div class="row mx-0" v-else>
            <div
                v-for="(shop, index) in sellers"
                :key="`shop-${index}`"
                :class="seller_column + ' ' + 'px-1'"
            >
                <single-shop :shop="shop" hasBanner v-if="banner"></single-shop>
                <single-shop :shop="shop" v-else></single-shop>
            </div>
        </div>
    </section>
    <!-- End Top Sellers -->
</template>
<script>
import { defineAsyncComponent } from "vue";
import { Swiper, SwiperSlide } from "swiper/vue";
import { Autoplay, Pagination } from "swiper";
const SingleShop = defineAsyncComponent(() =>
    import("../../shop/SingleShop.vue")
);

export default {
    name: "SellerList",
    components: {
        Swiper,
        SwiperSlide,
        SingleShop,
    },
    setup() {
        return {
            modules: [Autoplay, Pagination],
        };
    },

    props: {
        properties: {
            type: Array,
            required: false,
        },
    },

    data() {
        return {
            sellers: [],
            banner: false,
            slider_items: {
                mobile: 2,
                tab: 3,
                desktop: 6,
            },
            seller_column: "col-6 col-sm-6 col-md-4 col-lg-3 col-xl-2",
            pagination: { clickable: true },
        };
    },

    mounted() {
        this.sellers =
            this.properties["sellers"] && this.properties["sellers"]["data"]
                ? this.properties["sellers"]["data"]
                : [];
        this.banner =
            this.properties["banner_option"] &&
            this.properties["banner_option"] === "with_banner"
                ? true
                : false;

        this.seller_column = this.properties["column"] ?? this.seller_column;
        this.pagination = this.properties["pagination"]
            ? this.pagination
            : false;

        this.slider_items.mobile = this.properties["slide_item_sm"]
            ? parseInt(this.properties["slide_item_sm"])
            : this.slider_items.mobile;
        this.slider_items.tab = this.properties["slide_item_md"]
            ? parseInt(this.properties["slide_item_md"])
            : this.slider_items.tab;
        this.slider_items.desktop = this.properties["slide_item_lg"]
            ? parseInt(this.properties["slide_item_lg"])
            : this.slider_items.desktop;
    },
};
</script>
