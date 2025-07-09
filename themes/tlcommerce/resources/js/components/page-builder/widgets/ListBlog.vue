<template>
    <!-- Blog -->
    <section v-if="success">
        <ul>
            <li v-for="(blog, index) in blogs" :key="index">
                <!-- Single Recent Post -->
                <div class="post-summary">
                    <h5 class="post-title mt-2 title-excerpt">
                        <a :href="'/blog/' + blog.permalink">
                            {{ blog.title }}
                        </a>
                    </h5>

                    <span class="posted-on"
                        ><a :href="'/blog/' + blog.permalink">
                            {{ blog.date }}
                        </a>
                    </span>
                </div>
                <!-- End Single Recent Post -->
            </li>
        </ul>
    </section>
    <!-- End Blog -->
</template>

<script>
import axios from "axios";

export default {
    name: "ListBlog",
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
        };
    },

    mounted() {
        this.getSectionBlogs();
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
