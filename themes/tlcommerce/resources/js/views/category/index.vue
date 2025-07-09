<template>
  <div class="">
    <page-header class="pt-3 pb-3" :items="bItems" />
    <div class="pt-60 pb-60 light-bg">
      <div class="custom-container2">
        <div class="row">
          <div class="col-12" v-if="!categoryLoading">
            <div
              class="card mb-30"
              v-for="(cat, index) in megaCategories"
              :key="index"
            >
              <div class="card-header">
                <h5 class="mb-0 py-1">
                  <router-link :to="`/products/category/${cat.slug}`">
                    {{ cat.name }}
                  </router-link>
                </h5>
              </div>
              <div class="card-body">
                <div v-if="cat.childs.data" class="sub-categories">
                  <div class="row gx-0">
                    <div class="col-12">
                      <div class="row child-category-wrapper">
                        <div
                          v-for="(subCatGroup, i) in cat.childs.data"
                          :key="`subCatGroup-${i}`"
                          class="col-lg-2 child-category"
                        >
                          <!-- Sub Category Group -->
                          <div class="sub-category-group">
                            <h6 class="sub-category-title">
                              <router-link
                                :to="`/products/category/${subCatGroup.slug}`"
                              >
                                {{ subCatGroup.name }}
                              </router-link>
                            </h6>

                            <ul class="sub-category list-unstyled mb-0">
                              <li
                                v-for="(item, j) in subCatGroup.childs.data"
                                :key="`item-${j}`"
                                class="sub-category-link"
                              >
                                <router-link
                                  :to="`/products/category/${item.slug}`"
                                >
                                  {{ item.name }}
                                </router-link>
                              </li>
                            </ul>
                          </div>
                          <!-- End Sub Category Group -->
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-12" v-if="categoryLoading">
            <skeleton class="w-100 mb-20" height="300px"></skeleton>
            <skeleton class="w-100 mb-20" height="300px"></skeleton>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import PageHeader from "@/components/pageheader/PageHeader.vue";
import axios from "axios";
export default {
  name: "Categories",
  components: {
    PageHeader,
  },
  data() {
    return {
      bItems: [
        {
          text: this.$t("Home"),
          href: "/",
        },
        {
          text: this.$t("Categories"),
          active: true,
        },
      ],
      megaCategories: [],
      categoryLoading: true,
    };
  },
  mounted() {
    document.title = this.$t("All Categories");
    this.getMegaCategories();
  },
  methods: {
    /**
     * Get Mega categories
     */
    getMegaCategories() {
      const headers = {
        "Content-Type": "application/json",
        "Accept-Language": localStorage.getItem("locale") || "en",
      };

      axios
        .get("/api/v1/ecommerce-core/mega-categories", {
          headers: headers,
        })
        .then((response) => {
          if (response.data.success) {
            this.megaCategories = response.data.data;
          }
          this.categoryLoading = false;
        })
        .catch((error) => {
          this.categoryLoading = false;
        });
    },
  },
};
</script>
<style scoped>
.child-category-wrapper .child-category:not(:last-child) {
  margin-bottom: 2rem !important;
}
</style>
