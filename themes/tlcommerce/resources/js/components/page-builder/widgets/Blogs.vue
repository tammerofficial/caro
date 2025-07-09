<template>
    <!-- Blog -->
    <section v-if="success">
        <div class="row">
            <div
                :class="blog_colum"
                v-for="(blog, index) in blogs"
                :key="`blog-${index}`"
            >
                <!-- Blog Card -->
                <blog-card :blog="blog" class="mb-30" />
                <!-- End Blog Card -->
            </div>
        </div>
    </section>
    <!-- End Blog -->
</template>

<script>
import { defineAsyncComponent } from "vue";
const BlogCard = defineAsyncComponent(() => import("../../ui/BlogCard.vue"));
import axios from "axios";

export default {
    name: "BlogSection",
    components: {
        BlogCard,
    },
    props: {
        properties: {
            type: Object,
            required: {},
        },
    },

    data() {
        return {
            blogs: [],
            success: false,
            blog_colum: ''
        };
    },

    mounted() {
        this.getSectionBlogs();
        this.blog_colum = this.properties['blog_colum'] ?? 'col-6 col-lg-3';
    },

    methods: {
        /**
         * Get Blogs
         */
        getSectionBlogs() {
            axios
                .post("/api/theme/tlcommerce/v1/home-page-blogs-list", {
                    quantity: this.properties.count,
                    content: this.properties.type,
                    category: this.properties.category,
                })
                .then((response) => {
                    if (response.data.success) {
                        this.blogs = response.data.data;
                        this.success = true;
                    } else {
                        this.success = false;
                    }
                })
                .catch((error) => {
                    this.success = false;
                });
        },
    },
};
</script>
