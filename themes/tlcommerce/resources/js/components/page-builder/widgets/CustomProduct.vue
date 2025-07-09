<template>
    <section class="collection-section home-page-section">
        <swiper
            v-if="products.length && properties.style == 'slider'"
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
                v-for="(item, index) in products"
                :key="`slide-${index}`"
            >
                <single-product :item="item" />
            </swiper-slide>
        </swiper>
        <div class="row mx-0" v-else>
            <div
                v-for="(item, index) in products"
                :key="`product-${index}`"
                :class="product_column + ' ' + 'px-1'"
            >
                <single-product :item="item" />
            </div>
        </div>
    </section>
</template>

<script>
import { defineAsyncComponent } from "vue";
import { Swiper, SwiperSlide } from "swiper/vue";
import { Autoplay, Pagination } from "swiper";
const SingleProduct = defineAsyncComponent(() =>
    import("../../product/SingleProduct.vue")
);

export default {
    name: "CustomProduct",
    components: {
        Swiper,
        SwiperSlide,
        SingleProduct,
    },

    props: {
        properties: {
            type: Object,
            default: {},
        },
    },

    setup() {
        return {
            modules: [Autoplay, Pagination],
        };
    },

    data() {
        return {
            products: [],
            slider_items: {
                mobile: 2,
                tab: 3,
                desktop: 6
            },
            product_column: "col-6 col-sm-6 col-md-4 col-lg-3 col-xl-2",
            pagination: { clickable: true }
        };
    },

    mounted() {
        this.products =
            this.properties["products"] && this.properties["products"]["data"]
                ? this.properties["products"]["data"]
                : [];
        
        this.product_column = this.properties["column"] ?? this.product_column;
        this.pagination = this.properties["pagination"] ? this.pagination : false;

        this.slider_items.mobile = this.properties['slide_item_sm'] ? parseInt(this.properties['slide_item_sm']) : this.slider_items.mobile;
        this.slider_items.tab = this.properties['slide_item_md'] ? parseInt(this.properties['slide_item_md']) : this.slider_items.tab;
        this.slider_items.desktop = this.properties['slide_item_lg'] ? parseInt(this.properties['slide_item_lg']) : this.slider_items.desktop;
    },

    methods: {},
};
</script>
