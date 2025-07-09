<template>
  <div class="blog-page">
    <page-header :items="bItems" />
    <!-- Blog list with sidebar -->
    <div class="pt-30 pt-lg-60 pb-60 light-bg">
      <div class="custom-container2">
        <div class="row" v-if="!blog_page_style_loading">
          <div :class="blogsListLayoutClass">
            <template v-if="!blogs_loading">
              <div class="row mobile-gap-10">
                <div
                  v-for="(blog, index) in blogs"
                  :key="`blog-${index}`"
                  :class="[
                    blogOptionStyle.blog_colum != null
                      ? blogOptionStyle.blog_colum
                      : 'col-lg-4 col-6',
                  ]"
                >
                  <blog-card
                    :blog="blog"
                    :blogOptionStyle="blogOptionStyle"
                    styleTwo
                    class="mb-30"
                  />
                </div>
              </div>
              <div
                class="row mobile-gap-10"
                v-if="blogs != null && blogs.length == 0"
              >
                <h3>{{ $t("No Content Found") }}</h3>
              </div>
              <div class="row align-items-center mt-10">
                <div class="col-md-12">
                  <ul
                    class="tl-pagination custom-pagination"
                    v-if="blogs.length > 0"
                  >
                    <li v-if="currentPage == 1">
                      <a class="" href="#" aria-disabled="true">«</a>
                    </li>
                    <li v-else>
                      <a class="" href="#" @click="paginate('prev')">«</a>
                    </li>

                    <template v-if="currentPage == 1">
                      <li>
                        <a
                          href="#"
                          @click="paginate(currentPage)"
                          class="active"
                          >{{ currentPage }}</a
                        >
                      </li>
                      <li>
                        <a href="#" v-if="endingPage > 1" @click="paginate(2)"
                          >2</a
                        >
                      </li>
                      <li>
                        <a href="#" v-if="endingPage > 2" @click="paginate(3)"
                          >3</a
                        >
                      </li>
                    </template>

                    <template v-else-if="currentPage == endingPage">
                      <li>
                        <a href="#" v-if="endingPage > 1" @click="paginate(1)"
                          >1</a
                        >
                      </li>
                      <li>
                        <a href="#" v-if="endingPage > 2" @click="paginate(2)"
                          >2</a
                        >
                      </li>
                      <li>
                        <a
                          href="#"
                          @click="paginate(currentPage)"
                          class="active"
                          >{{ currentPage }}</a
                        >
                      </li>
                    </template>

                    <template v-else>
                      <li>
                        <a
                          href="#"
                          v-if="endingPage > 1"
                          @click="paginate(currentPage - 1)"
                          >{{ currentPage - 1 }}</a
                        >
                      </li>
                      <li>
                        <a
                          href="#"
                          @click="paginate(currentPage)"
                          class="active"
                          >{{ currentPage }}</a
                        >
                      </li>
                      <li>
                        <a
                          href="#"
                          v-if="endingPage > 2"
                          @click="paginate(currentPage + 1)"
                          >{{ currentPage + 1 }}</a
                        >
                      </li>
                    </template>

                    <li v-if="currentPage == endingPage">
                      <a href="#" aria-disabled="true">»</a>
                    </li>
                    <li v-else><a href="#" @click="paginate('next')">»</a></li>
                  </ul>
                </div>
              </div>
            </template>
            <div class="row mobile-gap-10" v-if="blogs_loading">
              <div
                class="col-lg-4 col-6"
                v-for="(item, index) in blogsSkeletons"
                :key="index"
              >
                <skeleton :height="item.height" class="w-100 mb-10"> </skeleton>
              </div>
            </div>
          </div>
          <div
            class="col-lg-3"
            v-if="blogOptionStyle.blog_layout != 'full_layout'"
          >
            <blog-side-bar></blog-side-bar>
          </div>
        </div>
      </div>
    </div>
    <!-- /Blog list with sidebar -->
  </div>
</template>

<script>
import PageHeader from "@/components/pageheader/PageHeader.vue";
import BlogCard from "../../../components/ui/BlogCard.vue";
import BlogSideBar from "../../../components/ui/BlogSideBar.vue";
const axios = require("axios").default;
export default {
  name: "BlogSearch",
  components: {
    PageHeader,
    BlogCard,
    BlogSideBar,
  },

  data() {
    return {
      pageTitle: "Blog",
      bItems: [
        {
          text: this.$t("Home"),
          href: "/",
        },
        {
          text: this.$t("Blog"),
          active: true,
          href: "/blog",
        },
      ],
      blogs: null,

      blogOptionStyle: [],
      searchKey: "",
      blogs_loading: true,
      blog_page_style_loading: true,
      blogsSkeletons: [
        {
          height: "370px",
        },
        {
          height: "370px",
        },
        {
          height: "370px",
        },
      ],
      endingPage: 1,
      currentPage: 1,
    };
  },
  computed: {
    /**
     * Compute blog layout classes
     */
    blogsListLayoutClass() {
      if (
        this.blogOptionStyle.custom_blog != 1 ||
        this.blogOptionStyle.blog_layout == null
      ) {
        return "col-lg-9";
      } else {
        if (this.blogOptionStyle.blog_layout == "full_layout") {
          return "col-lg-12";
        }
        if (this.blogOptionStyle.blog_layout == "right_sidebar_layout") {
          return "col-lg-9 order-first";
        }
        if (this.blogOptionStyle.blog_layout == "left_sidebar_layout") {
          return "col-lg-9 order-last";
        }
      }
      return "col-lg-9";
    },
  },
  mounted() {
    this.searchKey = this.$route.query.searchKey;
    this.getBlogThemeStyle();
    this.searchBlogs();
  },

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
          }
          this.blog_page_style_loading = false;
        })
        .catch((error) => {
          this.blog_page_style_loading = false;
        });
    },

    /**
     * Pagination
     */
    paginate(status) {
      if (status == "next") {
        this.currentPage = this.currentPage + 1;
      } else if (status == "prev") {
        this.currentPage = this.currentPage - 1;
      } else {
        this.currentPage = status;
      }

      this.searchBlogs();
    },

    /**Search blogs by keywords */
    searchBlogs() {
      this.blogs_loading = true;
      axios
        .get(
          "/api/theme/tlcommerce/v1/blog/search" +
            "?page=" +
            this.currentPage +
            "&search=" +
            this.searchKey
        )
        .then((response) => {
          if (response.data.success) {
            let info = response.data;
            this.blogs = info.blogs.data;
            this.endingPage = info.blogs.last_page;
            this.currentPage = info.blogs.current_page;
            document.title = this.$t("Blog Search Result");
          }
          this.blogs_loading = false;
        })
        .catch((error) => {
          this.blogs_loading = false;
        });
    },
  },
};
</script>
