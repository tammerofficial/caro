<template>
    <div class="side-bar">
        <div class="blog-sidebar mt-5 mt-lg-0" v-if="!blog_widget_loading">
            <!-- Widget Search -->
            <WidgetSearch @searchBlogs="searchBlogs" />

            <v-runtime-template :template="widget_html"></v-runtime-template>
        </div>
        <div class="blog-sidebar mt-5 mt-lg-0" v-if="blog_widget_loading">
            <skeleton height="370px" class="w-100 mb-10"> </skeleton>
            <skeleton height="370px" class="w-100 mb-10"> </skeleton>
        </div>
    </div>
</template>
<script>
const axios = require("axios").default;
import VRuntimeTemplate from "vue3-runtime-template";
import WidgetSearch from "../widget/WidgetSearch.vue";
import featured_blog_widget from "../widget/featured_blog_widget.vue";
import recent_blog_widget from "../widget/recent_blog_widget.vue";
import address_widget from "../widget/address_widget.vue";
import footer_left_menu from "../widget/footer_left_menu.vue";
import footer_right_menu from "../widget/footer_right_menu.vue";
import newsletter_widget from "../widget/newsletter_widget.vue";
import social_links from "../widget/social_links.vue";

export default {
    name: "BlogSideBar",
    components: {
        VRuntimeTemplate,
        WidgetSearch,
        featured_blog_widget,
        recent_blog_widget,
        address_widget,
        footer_left_menu,
        footer_right_menu,
        newsletter_widget,
        social_links,
    },
    data() {
        return {
            widget_options: [],
            widget_html: "",
            socialStyle: {},
            subscriptionFormStyle: {},
            blog_widget_loading: true,
        };
    },
    mounted() {
        this.getBlogSidebarWidgets();
        this.getThemeStyle();
    },
    methods: {
        /**
         * Get All Blog Sidebar Widgets
         */
        getBlogSidebarWidgets() {
            axios
                .get("/api/theme/tlcommerce/v1/get-blog-sidebar-widgets")
                .then((response) => {
                    if (response.data.success) {
                        this.widget_options = response.data.widget_options;
                        for (const [key, value] of Object.entries(
                            this.widget_options
                        )) {
                            if (key == "address_widget") {
                                this.widget_html =
                                    this.widget_html +
                                    "<" +
                                    key +
                                    " :" +
                                    key +
                                    '="widget_options.' +
                                    key +
                                    '"/>';
                                this.widget_html =
                                    this.widget_html +
                                    '<social_links class="widget" :social_links="widget_options.address_widget.social_links" :social-style="socialStyle"/>';
                            } else if (key == "newsletter_widget") {
                                this.widget_html =
                                    this.widget_html +
                                    '<' +
                                    key +
                                    " :" +
                                    key +
                                    '="widget_options.' +
                                    key +
                                    '" :subscription-form-style="subscriptionFormStyle"/>';
                            } else {
                                this.widget_html =
                                    this.widget_html +
                                    "<" +
                                    key +
                                    " :" +
                                    key +
                                    '="widget_options.' +
                                    key +
                                    '"/>';
                            }
                        }
                    }
                    this.blog_widget_loading = false;
                })
                .catch((error) => {
                    this.blog_widget_loading = false;
                });
        },

        /**
         * Get theme style
         */
        getThemeStyle() {
            const headers = {
                "Content-Type": "application/json",
                "Accept-Language": localStorage.getItem("locale") || "en",
            };

            axios
                .get("/api/theme/tlcommerce/v1/get-theme-style", {
                    headers: headers,
                })
                .then((response) => {
                    if (response.data.success) {
                        this.socialStyle = response.data.socialStyle;
                        this.subscriptionFormStyle =
                            response.data.subscriptionFormStyle;
                    }
                })
                .catch((error) => {});
        },
    },
};
</script>
