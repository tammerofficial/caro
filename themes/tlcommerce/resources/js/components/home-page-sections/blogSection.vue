<template>
  <!-- Blog -->
  <section
    :style="cssVars"
    class="pb-15 pt-15 blog-section home-page-section"
    v-if="success"
  >
    <div class="custom-container2">
      <div class="row align-items-center">
        <div class="col-md-6">
          <section-title
            class="mb-30"
            :title="section_title"
            :titleColor="properties.title_color"
          />
        </div>
        <div class="col-md-6 text-md-end">
          <router-link
            class="btn btn-sm rounded-0 mb-30 blog-section-btn"
            to="/blog"
          >
            {{
              properties.btn_title != null
                ? properties.btn_title
                : $t("View All")
            }}
          </router-link>
        </div>
      </div>

      <div class="row">
        <div
          class="col-lg-3 col-6"
          v-for="(blog, index) in blogs"
          :key="`blog-${index}`"
        >
          <!-- Blog Card -->
          <blog-card :blog="blog" class="mb-30" />
          <!-- End Blog Card -->
        </div>
      </div>
    </div>
  </section>
  <!-- End Blog -->
</template>
<script>
import { defineAsyncComponent } from "vue";
const BlogCard = defineAsyncComponent(() => import("../ui/BlogCard.vue"));
import axios from "axios";
export default {
  name: "BlogSection",
  components: {
    BlogCard,
  },
  props: {
    content: {
      type: String,
      required: false,
    },
    properties: {
      type: Array,
      required: false,
    },
  },
  computed: {
    cssVars() {
      return {
        //Section
        "--section-background-color": this.properties.bg_color,
        "--section-background-image": `url(${this.properties.bg_image})`,
        "--section-background-image-position":
          this.properties.background_position,
        "--section-background-image-size": this.properties.background_size,
        "--section-background-image-repeat": this.properties.background_repeat,
        "--section-padding": `${
          this.properties.padding_top +
          "px " +
          this.properties.padding_right +
          "px " +
          this.properties.padding_bottom +
          "px " +
          this.properties.padding_left +
          "px"
        }`,
        "--section-margin": `${
          this.properties.margin_top +
          "px " +
          this.properties.margin_right +
          "px " +
          this.properties.margin_bottom +
          "px " +
          this.properties.margin_left +
          "px"
        }`,
        //Button
        "--button-color": this.properties.btn_color,
        "--button-background-color": this.properties.btn_bg_color,
        "--button-border":
          this.properties.btn_border != null
            ? this.properties.btn_border + "px solid"
            : 0 + "px",
        "--button-border-color": this.properties.btn_border_color,
        "--button-hover-border-color": this.properties.btn_border_hover_color,
        "--button-hover-bg-color": this.properties.btn_bg_hover_color,
        "--button-hover-color": this.properties.btn_hover_color,
      };
    },
  },
  data() {
    return {
      blogs: [],
      success: false,
      section_title: this.$t(this.properties.title),
    };
  },
  mounted() {
    this.getSectionBlogs();
  },
  methods: {
    /**
     * Blogs
     */
    getSectionBlogs() {
      axios
        .post("/api/theme/tlcommerce/v1/home-page-blogs-list", {
          quantity: this.properties.number_of_blogs,
          content: this.properties.content,
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
<style scoped>
.blog-section-btn {
  color: var(--button-color);
  background-color: var(--button-background-color);
  border: var(--button-border);
  border-color: var(--button-border-color);
}
.blog-section-btn:hover {
  color: var(--button-hover-color);
  background-color: var(--button-hover-bg-color);
  border-color: var(--button-hover-border-color);
}
.blog-section {
  background-image: var(--section-background-image);
  background-color: var(--section-background-color);
  padding: var(--section-padding) !important;
  margin: var(--section-margin) !important;
  background-position: var(--section-background-image-position);
  background-size: var(--section-background-image-size);
  background-repeat: var(--section-background-image-repeat);
}
</style>
