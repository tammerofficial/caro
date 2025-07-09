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

                  <h1 class="entry-title mbi-20">
                    {{ blog.name }}
                  </h1>

                  <ul
                    class="list-inline list-unstyled entry-meta d-flex align-items-center"
                    v-if="
                      singleBlogPageStyle.date == 1 ||
                      singleBlogPageStyle.author == 1
                    "
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

              <!-- Post Footer -->
              <footer class="entry-footer">
                <div class="row border-top border-bottom pt-3 pb-3">
                  <div class="col-lg-6">
                    <!-- Tags -->
                    <div class="entry-tags">
                      <ul
                        class="align-items-center d-flex gap-2 list-inline mb-0"
                      >
                        <li class="mr-0">{{ $t("Tags:") }}</li>
                        <template v-if="blog.tag != null">
                          <li
                            v-for="(tag, index) in blog.tag_list"
                            :key="index"
                            class="mt-half"
                          >
                            <a
                              class="text-capitalize"
                              :href="'/blog/tag/' + tag.permalink"
                            >
                              {{ tag.name }}
                              <span v-if="index < blog.tag_list.length - 1"
                                >,</span
                              >
                            </a>
                          </li>
                        </template>

                        <li class="media-body" v-else>
                          <i class="fa fa-ban"></i>
                        </li>
                      </ul>
                    </div>
                    <!-- End Tags -->
                  </div>
                  <div class="col-lg-6">
                    <!-- Categories -->
                    <div class="entry-categories">
                      <ul
                        class="align-items-center d-flex gap-2 list-inline mb-0"
                      >
                        <li class="mr-0">
                          {{ $t("Categories:") }}
                        </li>
                        <template v-if="blog.category != null">
                          <li
                            v-for="(cat, index) in blog.category_list"
                            :key="index"
                            class="mt-half"
                          >
                            <a
                              class="text-capitalize"
                              :href="'/blog/category/' + cat.permalink"
                            >
                              {{ cat.name }}
                              <span v-if="index < blog.category_list.length - 1"
                                >,</span
                              >
                            </a>
                          </li>
                        </template>
                        <li class="media-body" v-else>
                          <i class="fa fa-ban"></i>
                        </li>
                      </ul>
                    </div>
                    <!-- End Categories -->
                  </div>
                </div>
              </footer>
              <!-- End Post Footer -->
            </article>
            <div class="post-details" v-if="blog_details_loading">
              <skeleton height="300px" class="w-100 mb-20"></skeleton>
              <skeleton height="500px" class="w-100"></skeleton>
            </div>
            <!-- /Post Details -->

            <!-- Related Post -->
            <div class="related-post pt-5">
              <h3 class="title">{{ $t("You May Like It") }}</h3>
              <div class="row">
                <div
                  v-for="(blog, index) in blogs"
                  :key="`blog-${index}`"
                  class="col-md-4 col-6"
                >
                  {{ blogs.title }}
                  <blog-card
                    :blog="blog"
                    :blogOptionStyle="blogOptionStyle"
                    styleTwo
                    class="mb-30"
                  />
                </div>
              </div>
            </div>
            <!-- /Related Post -->

            <!--Blog Comments-->
            <div
              class="comments-area pt-4"
              id="comment-list-01"
              v-if="commentList"
            >
              <div>
                <v-runtime-template
                  :template="commentList"
                ></v-runtime-template>
              </div>
              <!--Comment Pagination-->
              <div class="row align-items-center mt-10" v-if="endingPage > 1">
                <div
                  class="col-md-12"
                  v-if="commentSettings.page_comments == 1"
                >
                  <ul
                    class="tl-pagination custom-pagination"
                    v-if="commentList != ''"
                  >
                    <li v-if="currentPage == 1">
                      <a class="" href="#" aria-disabled="true">«</a>
                    </li>
                    <li v-else>
                      <a
                        class=""
                        href="#"
                        @click="paginate('prev', 'comment-list-01')"
                        >«</a
                      >
                    </li>

                    <template v-if="currentPage == 1">
                      <li>
                        <a
                          href="#"
                          @click="paginate(currentPage, 'comment-list-01')"
                          class="active"
                          >{{ currentPage }}</a
                        >
                      </li>
                      <li>
                        <a
                          href="#"
                          v-if="endingPage > 1"
                          @click="paginate(2, 'comment-list-01')"
                          >2</a
                        >
                      </li>
                      <li>
                        <a
                          href="#"
                          v-if="endingPage > 2"
                          @click="paginate(3, 'comment-list-01')"
                          >3</a
                        >
                      </li>
                    </template>

                    <template v-else-if="currentPage == endingPage">
                      <li>
                        <a
                          href="#"
                          v-if="endingPage > 1"
                          @click="paginate(1, 'comment-list-01')"
                          >1</a
                        >
                      </li>
                      <li>
                        <a
                          href="#"
                          v-if="endingPage > 2"
                          @click="paginate(2, 'comment-list-01')"
                          >2</a
                        >
                      </li>
                      <li>
                        <a
                          href="#"
                          @click="paginate(currentPage, 'comment-list-01')"
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
                          @click="paginate(currentPage - 1, 'comment-list-01')"
                          >{{ currentPage - 1 }}</a
                        >
                      </li>
                      <li>
                        <a
                          href="#"
                          @click="paginate(currentPage, 'comment-list-04')"
                          class="active"
                          >{{ currentPage }}</a
                        >
                      </li>
                      <li>
                        <a
                          href="#"
                          v-if="endingPage > 2"
                          @click="paginate(currentPage + 1, 'comment-list-01')"
                          >{{ currentPage + 1 }}</a
                        >
                      </li>
                    </template>

                    <li v-if="currentPage == endingPage">
                      <a href="#" aria-disabled="true">»</a>
                    </li>
                    <li v-else>
                      <a href="#" @click="paginate('next', 'comment-list-01')"
                        >»</a
                      >
                    </li>
                  </ul>
                </div>
              </div>
              <!--End Comment pagination-->
            </div>

            <div
              class="comment-respond pt-4"
              v-if="
                commentSettings.should_auto_close_comment &&
                commentSettings.default_comment_status == 1
              "
            >
              <template
                v-if="
                  (commentSettings.comment_registration == 1 &&
                    (isCustomerLogin || isAdminLogin)) ||
                  commentSettings.comment_registration == 0
                "
              >
                <template v-if="parent != ''">
                  <input type="hidden" name="parent" v-model="parent" />
                  <h3>
                    {{ $t("Leave A Reply To") }}
                    {{ replayComment }}
                    <a
                      href="javascript:void(0)"
                      @click="cancelReplay()"
                      class="btn-link fz-14 text-danger"
                    >
                      {{ $t("Cancel") }}</a
                    >
                  </h3>
                </template>
                <template v-else>
                  <h3 class="default-title">
                    {{ $t("Leave Your Thought") }}
                  </h3>
                </template>
                <div class="comment-form" ref="comment">
                  <div class="row">
                    <template v-if="!(isCustomerLogin || isAdminLogin)">
                      <p class="comment-notes">
                        <span>
                          {{ $t("Your email address will not be published.") }}
                        </span>
                        {{ $t("Required fields are marked") }}
                        <span class="required">*</span>
                      </p>
                      <div class="col-lg-6">
                        <input
                          class="theme-input-style"
                          type="text"
                          placeholder="Your Name"
                          required="required"
                          v-model="userName"
                        />
                        <span v-if="errors" class="text-danger error">{{
                          errors.user_name
                        }}</span>
                      </div>
                      <div class="col-lg-6">
                        <input
                          class="theme-input-style"
                          type="email"
                          placeholder="Your Email"
                          required="required"
                          v-model="userEmail"
                        />
                        <span v-if="errors" class="text-danger error">{{
                          errors.user_email
                        }}</span>
                      </div>
                      <div class="col-lg-12">
                        <input
                          class="theme-input-style"
                          type="text"
                          placeholder="Website Name"
                          v-model="websiteName"
                        />
                      </div>
                    </template>

                    <div class="col-12">
                      <textarea
                        class="theme-input-style"
                        required="required"
                        placeholder="Message here"
                        v-model="comment"
                      ></textarea>
                      <span v-if="errors" class="text-danger error">{{
                        errors.comment
                      }}</span>
                    </div>
                  </div>

                  <button
                    type="button"
                    class="btn btn-fill"
                    @click="postComment()"
                  >
                    {{ $t("Submit") }}
                  </button>
                </div>
              </template>
            </div>
            <!--End blog comment-->
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
import BlogCard from "../../../components/ui/BlogCard.vue";
import BlogSideBar from "../../../components/ui/BlogSideBar.vue";

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

      userName: "",
      userEmail: "",
      websiteName: "",
      commentSettings: {},
      comment: "",
      commentList: ``,
      parent: "",
      replayComment: "",
      errors: null,

      isAdminLogin: "",
      endingPage: 1,
      currentPage: 1,
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
    this.getBlogComments();
    this.getRelatedBlogs();
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
      let slug = this.$route.params.id;

      axios
        .get("/api/theme/tlcommerce/v1/blog/" + slug)
        .then((response) => {
          if (response.data.success) {
            if (response.data.blog != null) {
              this.blog = response.data.blog;
              this.bItems = [
                {
                  text: this.$t("Home"),
                  href: "/",
                },
                {
                  text: this.$t("Blog"),
                  href: "/blog",
                },
                {
                  text: this.blog.name,
                  active: true,
                },
              ];
              document.title = this.blog.name;
            } else {
              this.$router.push({ path: "/404" });
            }
          }
          this.blog_details_loading = false;
        })
        .catch((error) => {
          this.blog_details_loading = false;
        });
    },

    /**
     * Post comment
     */
    postComment() {
      let slug = this.$route.params.id;
      let customerId = null;

      if (this.$store.state.isCustomerLogin) {
        customerId = this.$store.state.customerInfo.id;
      }

      let request = {
        user_name: this.userName,
        user_email: this.userEmail,
        comment: this.comment,
        blog_permalink: slug,
        user_website: this.websiteName,
        customerId: customerId,
      };

      if (this.parent != "") {
        request = {
          user_name: this.userName,
          user_email: this.userEmail,
          comment: this.comment,
          blog_permalink: slug,
          user_website: this.websiteName,
          customerId: customerId,
          parent: this.parent,
        };
      }

      axios
        .post("/api/theme/tlcommerce/v1/blog/comment/create", request)
        .then((response) => {
          if (response.data.success) {
            this.comment = "";
            if (this.parent != "") {
              this.$toast.success("Replay added successfully");
            } else {
              this.$toast.success("Comment added successfully");
            }
            setTimeout(() => {
              this.getBlogComments();
            }, 3000);
          } else if (response.data.violation) {
            this.$toast.error(response.data.violationMessage);
          } else if (response.data.is_validation_error) {
            this.errors = response.data.error;
          }
        })
        .catch((error) => {});
    },

    /**
     * paginate
     */
    paginate(status, id) {
      if (status == "next") {
        this.currentPage = this.currentPage + 1;
      } else {
        if (status == "prev") {
          this.currentPage = this.currentPage - 1;
        } else {
          this.currentPage = status;
        }
      }

      this.getBlogComments();
      const scrollTo = scroller();
      scrollTo("#" + id);
    },

    /**
     * Get blog comments
     */
    getBlogComments() {
      let slug = this.$route.params.id;
      let request = {
        permalink: slug,
        page: this.currentPage,
      };

      if (this.$store.state.isCustomerLogin) {
        request = {
          permalink: slug,
          page: this.currentPage,
          customerId: this.$store.state.customerInfo.id,
        };
      }

      axios
        .post("/api/theme/tlcommerce/v1/blog/comment", request)
        .then((response) => {
          if (response.data.success) {
            this.commentList = response.data.view;
            this.currentPage = response.data.currentPage;
            this.endingPage = response.data.lastPage;
            this.isAdminLogin = response.data.isAdminLoggedIn;
            this.commentSettings = response.data.commentSettings;
          }
        })
        .catch((error) => {
          this.commentList = [];
        });
    },

    /**
     * show replays
     */
    moreCommentButton(id, iconId) {
      const element = this.$el.querySelector(id);
      const iconElement = this.$el.querySelector(iconId);
      if (element.classList.contains("d-none")) {
        element.classList.remove("d-none");
        if (iconElement != null) {
          iconElement.classList.remove("fa-angle-down");
          iconElement.classList.add("fa-angle-up");
        }
      } else {
        element.classList.add("d-none");
        if (iconElement != null) {
          iconElement.classList.remove("fa-angle-up");
          iconElement.classList.add("fa-angle-down");
        }
      }
    },

    /**
     * replay comment
     */
    replyComment(comment_id, replayComment) {
      this.parent = comment_id;
      this.replayComment = replayComment;
      this.goto("comment");
    },

    /**
     * Execute cancel replay
     */
    cancelReplay() {
      this.parent = "";
      this.replayComment = "";
    },

    /**
     * Go to specific element
     */
    goto(refName) {
      var element = this.$refs[refName];
      var top = element.offsetTop;
      window.scrollTo(0, top - 300);
    },
    /**
     * Get all related blogs
     */
    getRelatedBlogs() {
      let slug = this.$route.params.id;
      axios
        .get("/api/theme/tlcommerce/v1/get-related-blogs?slug=" + slug)
        .then((response) => {
          if (response.data.success) {
            this.blogs = response.data.blogs;
          }
        })
        .catch((error) => {
          this.blogs = [];
        });
    },
  },
};
</script>
<style scoped>
.mbi-20 {
  margin-bottom: 20px !important;
}
.error {
  margin-top: -25px;
  display: block;
}
.related-post .title {
  margin-bottom: 20px;
  font-size: 30px;
  line-height: 1.333;
}
.default-title {
  margin-bottom: 20px;
  font-size: 30px;
  line-height: 1.333;
}
.mt-half {
  margin-top: 0.5px !important;
}
.mr-0 {
  margin-right: 0px !important;
}
</style>
