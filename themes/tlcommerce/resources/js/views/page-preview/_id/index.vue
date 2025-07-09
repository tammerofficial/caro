<template>
  <div class="">
    <div class="light-bg" v-if="pageLoading">
      <skeleton height="100vh" class="w-100 pt-20"></skeleton>
    </div>

    <page-header :items="bItems" v-if="is_breadcrumb" :title="page.title" />

    <builder-section
      :page="page"
      :sections="page_section"
      :widgets="page_builder_widgets"
      @section-loaded="loaded"
      v-if="active_pagebuilder && page.page_type == 'builder'"
    />

    <div class="pt-30 pt-lg-60 pb-60 light-bg" v-else>
      <div class="custom-container2">
        <div class="row">
          <div class="col-lg-12">
            <!-- Page Details -->
            <article class="post-details">
              <!-- Page Header -->
              <header class="entry-header mb-40" v-if="page.page_image != null">
                <div class="entry-thumbnail">
                  <img :src="page.page_image" :alt="page.title" />
                </div>
              </header>
              <!-- End Page Header -->

              <!-- Page Content -->
              <div class="entry-content" v-html="page.content"></div>
              <!-- End Page Content -->
            </article>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import { defineAsyncComponent } from "vue";
const PageHeader = defineAsyncComponent(() =>
  import("@/components/pageheader/PageHeader.vue")
);

const BuilderSection = defineAsyncComponent(() =>
  import("@/components/page-builder/BuilderSection.vue")
);

const axios = require("axios").default;
export default {
  name: "Products",
  components: {
    PageHeader,
    BuilderSection,
  },

  data() {
    return {
      pageTitle: "Page Details",
      wToggle: false,
      bItems: [
        {
          text: "Home",
          href: "/",
        },
        {
          text: "Preview",
          active: true,
        },
      ],
      pageLoading: true,
      is_breadcrumb: false,
      page: {},
      page_section: {},
      active_pagebuilder: false,
      page_builder_widgets: {},
    };
  },

  mounted() {
    this.getPageDetails();
  },

  methods: {
    /**
     * Get page details
     */
    getPageDetails() {
      let slug = this.$route.params.id;

      const headers = {
        "Content-Type": "application/json",
        "Accept-Language": localStorage.getItem("locale") || "en",
      };
      axios
        .get("/api/theme/tlcommerce/v1/preview-page/" + slug, {
          headers: headers,
        })
        .then((response) => {
          if (response.data.success) {
            this.page = response.data.page;
            this.page_section = response.data.page_sections ?? {};
            this.active_pagebuilder = response.data.active_pagebuilder;
            this.page_builder_widgets =
              response.data.page_builder_widgets ?? {};
            this.is_breadcrumb = !(
              this.active_pagebuilder && this.page.page_type == "builder"
            );
            this.loaded();
          }
        })
        .catch((error) => {
          this.loaded();
        });
    },
    /**
     * Make Preloader False
     */
    loaded() {
      this.pageLoading = false;
    },
  },
};
</script>
