<template>
  <div class="blog-details-page">
    <page-header :items="bItems" />
    <div class="pt-30 pt-lg-60 pb-60 light-bg">
      <div class="custom-container2">
        <div class="row">
          <div :class="blogsListLayoutClass">
            <!-- Post Details -->
            <article class="post-details" v-if="!blog_details_loading">
              <!-- Post Header -->
              <header class="entry-header">
                <template
                  v-if="
                    singleBlogPageStyle.blog_post_title_position == null ||
                    singleBlogPageStyle.blog_post_title_position ==
                      'below_thumbnail'
                  "
                >
                  <div class="entry-thumbnail" v-if="blog.image">
                    <img :src="blog.image" alt="" />
                  </div>

                  <h1 class="entry-title">
                    {{ blog.name }}
                  </h1>

                  <ul
                    class="list-inline list-unstyled entry-meta d-flex align-items-center"
                  >
                    <li v-if="singleBlogPageStyle.date == 1">
                      <span>{{ $t("Posted On:") }}</span>
                      <a :href="'/blog/' + blog.permalink"
                        ><time
                          class="entry-date"
                          datetime="2018-08-26T05:00:16+00:00"
                          >{{ blog.publish_at }}</time
                        ></a
                      >
                    </li>

                    <li v-if="singleBlogPageStyle.author == 1">
                      <span>{{ $t("Posted By:") }}</span>
                      <a href="#">
                        {{ blog.user_name }}
                      </a>
                    </li>
                  </ul>
                </template>
                <template v-else>
                  <h1 class="entry-title">
                    {{ blog.name }}
                  </h1>
                  <div class="entry-thumbnail" v-if="blog.image">
                    <img :src="blog.image" alt="" />
                  </div>

                  <ul
                    class="list-inline list-unstyled entry-meta d-flex align-items-center"
                  >
                    <li v-if="singleBlogPageStyle.date == 1">
                      <span>{{ $t("Posted On:") }}</span>
                      <a :href="'/blog/' + blog.permalink"
                        ><time
                          class="entry-date"
                          datetime="2018-08-26T05:00:16+00:00"
                          >{{ blog.publish_at }}</time
                        ></a
                      >
                    </li>

                    <li v-if="singleBlogPageStyle.author == 1">
                      <span>{{ $t("Posted By:") }}</span>
                      <a href="#">
                        {{ blog.user_name }}
                      </a>
                    </li>
                  </ul>
                </template>
              </header>
              <!-- End Post Header -->

              <!-- Post Content -->
              <div class="entry-content mb-40" v-html="blog.content"></div>
              <!-- End Post Content -->
            </article>
            <div class="post-details" v-if="blog_details_loading">
              <skeleton height="300px" class="w-100 mb-20"></skeleton>
              <skeleton height="500px" class="w-100"></skeleton>
            </div>
            <!-- /Post Details -->
          </div>
          <div
            class="col-lg-3"
            v-if="singleBlogPageStyle.blog_layout != 'full_layout'"
          >
            <blog-side-bar></blog-side-bar>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
  
  <script>
import PageHeader from "@/components/pageheader/PageHeader.vue";
import BlogCard from "../../components/ui/BlogCard.vue";
import BlogSideBar from "../../components/ui/BlogSideBar.vue";
import VRuntimeTemplate from "vue3-runtime-template";
import { mapState } from "vuex";
import { scroller } from "vue-scrollto/src/scrollTo";

const axios = require("axios").default;
export default {
  name: "BlogDetails",
  components: {
    PageHeader,
    BlogCard,
    BlogSideBar,
    VRuntimeTemplate,
  },

  data() {
    return {
      pageTitle: "Blog Details",
      bItems: [
        {
          text: this.$t("Home"),
          href: "/",
        },
        {
          text: this.$t("Blogs"),
          href: "/blog",
        },
      ],
      blog: {},
      blogs: [],
      blogOptionStyle: {},
      singleBlogPageStyle: {},
      blog_details_loading: true,
    };
  },
  watch: {
    $route: {
      deep: true,
      handler(to, from) {
        this.getBlogDetails();
        window.scrollTo(0, 0);
      },
    },
  },
  mounted() {
    this.getBlogThemeStyle();
    this.getBlogDetails();
  },
  computed: mapState({
    isCustomerLogin: (state) => state.isCustomerLogin,
    blogsListLayoutClass() {
      if (
        this.singleBlogPageStyle.custom_blog_page != 1 ||
        this.singleBlogPageStyle.single_blog_page_layout == null
      ) {
        return "col-lg-9";
      } else {
        if (this.singleBlogPageStyle.single_blog_page_layout == "full_layout") {
          return "col-lg-12";
        }
        if (
          this.singleBlogPageStyle.single_blog_page_layout == "right_sidebar"
        ) {
          return "col-lg-9 order-first";
        }
        if (
          this.singleBlogPageStyle.single_blog_page_layout == "left_sidebar"
        ) {
          return "col-lg-9 order-last";
        }
      }
      return "col-lg-9";
    },
  }),
  methods: {
    /**
     * Get blog theme style
     */
    getBlogThemeStyle() {
      axios
        .get("/api/theme/tlcommerce/v1/get-blog-theme-style")
        .then((response) => {
          if (response.data.success) {
            this.blogOptionStyle = response.data.blogOptions;
            this.singleBlogPageStyle = response.data.singleBlogPageStyle;
          }
        })
        .catch((error) => {});
    },

    /**
     * Get blog details
     */
    getBlogDetails() {
      let slug = this.$route.query.name;

      axios
        .get("/api/theme/tlcommerce/v1/preview-blog/" + slug)
        .then((response) => {
          if (response.data.success) {
            this.blog = response.data.blog;
            this.bItems = [
              {
                text: "Home",
                href: "/",
              },
              {
                text: "Blog",
                href: "/blog",
              },
              {
                text: this.blog.name,
                active: true,
              },
            ];
          }
          this.blog_details_loading = false;
        })
        .catch((error) => {
          this.blog_details_loading = false;
        });
    },
  },
};
</script>
  <style scoped>
.error {
  margin-top: -25px;
  display: block;
}
</style>
  