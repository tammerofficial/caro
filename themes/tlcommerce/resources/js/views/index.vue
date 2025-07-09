<template>
    <div class="light-bg" v-if="pageLoading">
        <skeleton height="100vh" class="w-100 pt-20"></skeleton>
    </div>

    <!-- From Page Builder -->
    <builder-section
        :page="page"
        :sections="page_section"
        :widgets="page_builder_widgets"
        @section-loaded="loaded"
        v-if="active_pagebuilder && page.page_type == 'builder'"
    />

    <div class="pt-30 pt-lg-60 pb-60 light-bg" v-else-if="active_pagebuilder && page.page_type == 'default'">
        <div class="custom-container2">
            <div class="row">
                <div class="col-lg-12">
                    <!-- Page Details -->
                    <article class="post-details">
                        <!-- Page Header -->
                        <header class="entry-header">
                            <div
                                class="entry-thumbnail"
                                v-if="page.page_image != null"
                            >
                                <img :src="page.page_image" alt="" />
                            </div>

                            <h1 class="entry-title">
                                {{ page.title }}
                            </h1>
                        </header>
                        <!-- End Page Header -->

                        <!-- Page Content -->
                        <div
                            class="entry-content mb-40"
                            v-html="page.content"
                        ></div>
                        <!-- End Page Content -->
                    </article>
                </div>
            </div>
        </div>
    </div>

    <div class="home__two" v-else>
        <!-- Banner -->
        <section
            class="product-banner product-banner-overflow-auto mt-30 mb-30"
           v-if="dataAvailable"
        >
            <div v-if="sliderLoading">
                <div class="desktop">
                    <div class="d-flex">
                        <skeleton height="450px" class="w-25"></skeleton>
                        <skeleton
                            height="450px"
                            class="slider-container mx-4 skeleton"
                        ></skeleton>
                        <skeleton height="450px" class="w-25"></skeleton>
                    </div>
                </div>
                <div class="mobile">
                    <skeleton height="120px" class="w-100"></skeleton>
                </div>
            </div>
            <div class="slider-container" v-else>
                <swiper
                    v-if="banners && banners.length > 0"
                    :slidesPerView="'auto'"
                    :loop="true"
                    :spaceBetween="20"
                    :centeredSlides="true"
                    :modules="modules"
                    :autoplay="{
                        delay: 4000,
                        disableOnInteraction: false,
                        pauseOnMouseEnter: true,
                    }"
                    :pagination="{
                        clickable: true,
                    }"
                    class="mySwiper theme-slider-dots dots-bottom-30"
                >
                    <swiper-slide
                        v-for="(slide, index) in banners"
                        :key="`slide-${index}`"
                    >
                        <product-banner :content="slide" />
                    </swiper-slide>
                </swiper>
            </div>
        </section>
        <!-- End Banner -->
        <!--Dynamic Sections-->
        <div v-for="(section, index) in sections" :key="index">
            <deal-section
                v-if="section.layout === 'flashdeal'"
                :content="section.content"
                :properties="section.properties"
            ></deal-section>

            <collection-section
                v-if="section.layout === 'product_collection'"
                :content="section.content"
                :properties="section.properties"
            >
            </collection-section>

            <custom-product-section
                v-if="section.layout === 'custom_product_section'"
                :content="section.content"
                :properties="section.properties"
            >
            </custom-product-section>

            <category-section
                v-if="section.layout === 'category_slider'"
                :content="section.content"
                :properties="section.properties"
            ></category-section>

            <ads-section
                v-if="section.layout === 'ads'"
                :content="section.content"
                :properties="section.properties"
            ></ads-section>

            <cta-section
                v-if="section.layout === 'featured_product'"
                :content="section.content"
                :properties="section.properties"
            ></cta-section>

            <blog-section
                v-if="section.layout === 'blogs'"
                :content="section.content"
                :properties="section.properties"
            ></blog-section>

            <top-sellers
                v-if="section.layout === 'seller_list'"
                :content="section.content"
                :properties="section.properties"
            ></top-sellers>
        </div>
        <!--End Dynamic Sections-->
    </div>
</template>

<script>
import { defineAsyncComponent } from "vue";
import { Swiper, SwiperSlide } from "swiper/vue";
import { Autoplay, Pagination } from "swiper";

const BuilderSection = defineAsyncComponent(() =>
    import("@/components/page-builder/BuilderSection.vue")
);

const ProductBanner = defineAsyncComponent(() =>
    import("@/components/ui/ProductBanner.vue")
);

const DealSection = defineAsyncComponent(() =>
    import("@/components/home-page-sections/dealSection.vue")
);

const collectionSection = defineAsyncComponent(() =>
    import("@/components/home-page-sections/collectionSection.vue")
);

const CategorySection = defineAsyncComponent(() =>
    import("@/components/home-page-sections/categorySection.vue")
);

const adsSection = defineAsyncComponent(() =>
    import("@/components/home-page-sections/adsSection.vue")
);

const ctaSection = defineAsyncComponent(() =>
    import("@/components/home-page-sections/ctaSection.vue")
);

const blogSection = defineAsyncComponent(() =>
    import("@/components/home-page-sections/blogSection.vue")
);

const CustomProductSection = defineAsyncComponent(() =>
    import("@/components/home-page-sections/CustomProductSection.vue")
);

const TopSellers = defineAsyncComponent(() =>
    import("@/components/home-page-sections/TopSellers.vue")
);
const axios = require("axios").default;
export default {
    components: {
        Swiper,
        SwiperSlide,
        ProductBanner,
        DealSection,
        collectionSection,
        CategorySection,
        adsSection,
        ctaSection,
        blogSection,
        CustomProductSection,
        TopSellers,
        BuilderSection,
    },
    setup() {
        return {
            modules: [Autoplay, Pagination],
        };
    },
    name: "HomeView",
    data() {
        return {
            pageLoading: true,
            banners: [],
            sections: [],
            dataAvailable: false,
            sliderLoading: true,
            page: {},
            page_section: {},
            active_pagebuilder: false,
            page_builder_widgets: {},
        };
    },
    mounted() {
        document.title = localStorage.getItem("site_title");
        this.getSections();
    },

    async created() {
        try {
            const response = await axios.get(
                "/api/theme/tlcommerce/v1/active-sliders"
            );
            if (response.status === 200) {
                this.banners = response.data.data;
                this.sliderLoading = false;
            }
        } catch (error) {
            this.sliderLoading = false;
        }
    },

    methods: {
        /**
         * Get active sections
         */
        getSections() {
            axios
                .get("/api/theme/tlcommerce/v1/active-home-page-sections")
                .then((response) => {
                    if (response.data.success) {
                        this.dataAvailable = true;
                        this.sections = response.data.data ?? [];
                        this.page = response.data.page ?? {};
                        this.page_section = response.data.page_sections ?? {};
                        this.active_pagebuilder =
                            response.data.active_pagebuilder ?? false;
                        this.page_builder_widgets =
                            response.data.page_builder_widgets ?? {};
                        if(!this.active_pagebuilder){
                            this.loaded();
                        }
                    }
                })
                .catch((error) => {
                    this.sections = [];
                });
        },
        /**
         * Make Preloader False
         */
         loaded() {
            this.pageLoading = false;
        }
    },
};
</script>
<style lang="scss">
.product-banner-overflow-auto {
    overflow: hidden;
    .swiper {
        overflow: initial;
    }
}
</style>
