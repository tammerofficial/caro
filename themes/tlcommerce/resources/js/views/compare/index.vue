<template>
  <div class="">
    <page-header :items="bItems" />

    <div class="pt-60 pb-60 light-bg">
      <div class="custom-container2">
        <div class="row" v-if="success">
          <!--Compare table-->
          <div class="col-12" v-if="tableData.length > 0">
            <div class="">
              <div class="table-responsive">
                <CTable class="compare-table border-bottom-0 mb-0">
                  <CTableBody>
                    <CTableRow v-for="tdata in tableData" :key="tdata.id">
                      <CTableHeaderCell colspan="2">{{
                        tdata.title
                      }}</CTableHeaderCell>
                      <CTableDataCell
                        v-for="data in tdata.data"
                        :key="data.name"
                      >
                        <div>
                          <span
                            v-if="data.search"
                            class="mb-20 d-block position-relative"
                          >
                            <div class="align-items-center btn-wraper d-flex">
                              <input
                                placeholder="Search Product"
                                class="theme-input-style"
                                v-model="data.search_key"
                                v-on:keyup="searchItemsFromList(data.id)"
                              />
                              <button
                                @click.prevent="removeItem(data.id)"
                                class="align-items-center d-flex ml-10 remove-btn"
                              >
                                <span class="material-icons">delete</span>
                              </button>
                            </div>

                            <div
                              class="search-suggestion box-shadow bg-white"
                              v-if="
                                data.search_result &&
                                data.search_result.length > 0
                              "
                            >
                              <ul class="list-unstyled mb-0">
                                <li
                                  class="d-block text-left sugesstion_list"
                                  v-for="(product, index) in data.search_result"
                                  :key="index"
                                  @click.prevent="
                                    changeCompareItem(data.id, product.id)
                                  "
                                >
                                  {{ product.name }}
                                </li>
                              </ul>
                            </div>
                          </span>
                          <span
                            v-if="data.image"
                            class="product-img compare-image d-block mb-2"
                            ><img :src="data.image" :alt="data.name" />
                          </span>
                          <span v-if="data.name">{{ data.name }}</span>
                          <div v-if="data.summary" v-html="data.summary"></div>
                          <div v-if="data.price">
                            <the-currency :amount="data.price"></the-currency>
                          </div>
                          <div v-if="data.rating">
                            <div class="star-rating">
                              <div class="product-rating-wrapper">
                                <i
                                  :data-star="data.rating"
                                  :title="data.rating"
                                ></i>
                              </div>
                            </div>
                          </div>
                          <div v-if="data.btn">
                            <single-product :item="data.btn" compareStyle />
                          </div>
                        </div>
                      </CTableDataCell>
                    </CTableRow>
                  </CTableBody>
                </CTable>
              </div>
            </div>
          </div>
          <!--End compare table-->
          <!--Select product box-->
          <div class="bg-light col-lg-4 col-12 offset-lg-4 p-4" v-else>
            <div class="mb-20 text-center">
              <h5>{{ $t("Product Comparison") }}</h5>
            </div>
            <!--First Item-->
            <div class="input-group mb-20">
              <input
                list="product-list-1"
                placeholder="Search Product"
                class="theme-input-style"
                v-model="search_key_1"
                v-on:keyup="searchItems('first')"
              />
              <div
                class="search-suggestion box-shadow bg-white"
                v-if="
                  products_suggestions_first &&
                  products_suggestions_first.length > 0
                "
              >
                <ul class="list-unstyled mb-0 first-item-search-result">
                  <li
                    class="d-block text-left sugesstion_list"
                    v-for="(product, index) in products_suggestions_first"
                    :key="index"
                    @click.prevent="setCompareItem(product, 'first')"
                  >
                    <single-product :item="product" compareSearch />
                  </li>
                </ul>
              </div>
            </div>
            <!--End First Item-->
            <!--Second Item -->
            <div class="input-group mb-20">
              <input
                list="product-list-2"
                placeholder="Search Product"
                class="theme-input-style"
                v-model="search_key_2"
                v-on:keyup="searchItems('last')"
              />
              <div
                class="search-suggestion box-shadow bg-white"
                v-if="
                  products_suggestions_last &&
                  products_suggestions_last.length > 0
                "
              >
                <ul class="list-unstyled mb-0 first-item-search-result">
                  <li
                    class="d-block text-left sugesstion_list"
                    v-for="(product, index) in products_suggestions_last"
                    :key="index"
                    @click.prevent="setCompareItem(product, 'last')"
                  >
                    <single-product :item="product" compareSearch />
                  </li>
                </ul>
              </div>
            </div>
            <!--End Second Item-->
            <div class="mb-20 text-center">
              <button class="btn btn-block" @click.prevent="viewComparison">
                {{ $t("View Comparison") }}
              </button>
            </div>
          </div>
          <!--End select product box-->
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import PageHeader from "@/components/pageheader/PageHeader.vue";
import axios from "axios";
import SingleProduct from "../../components/product/SingleProduct.vue";
import { mapState } from "vuex";
import {
  CTable,
  CTableBody,
  CTableRow,
  CTableDataCell,
  CTableHeaderCell,
} from "@coreui/vue";
export default {
  name: "Comapre",
  components: {
    SingleProduct,
    PageHeader,
    CTable,
    CTableBody,
    CTableRow,
    CTableDataCell,
    CTableHeaderCell,
  },
  computed: mapState({
    compareItems: (state) => state.compareItems,
    site_setting: (state) => state.siteSettings,
  }),
  data() {
    return {
      success: false,
      pageTitle: "Compare",
      bItems: [
        {
          text: this.$t("Home"),
          href: "/",
        },
        {
          text: this.$t("Products"),
          href: "/products",
        },
        {
          text: this.$t("Compare"),
          active: true,
        },
      ],
      tableData: [],
      productList: [],
      search_key_1: "",
      first_selected_item: "",
      products_suggestions_first: [],
      search_key_2: "",
      last_selected_item: "",
      products_suggestions_last: [],
    };
  },
  mounted() {
    if (this.site_setting.enable_product_compare != 1) {
      this.$router.push("/");
    }
    document.title = this.$t("Compare Products");
    this.getCompareItems();
  },
  methods: {
    /**
     * Will set compare item
     *
     * @param {*} item
     * @param {*} type
     */
    setCompareItem(item, type) {
      if (type == "first") {
        if (item.id == this.last_selected_item) {
          this.$toast.error(this.$t("Product is already added to compare"));
        } else {
          this.search_key_1 = item.name;
          this.first_selected_item = item.id;
          this.products_suggestions_first = [];
        }
      } else {
        if (item.id == this.first_selected_item) {
          this.$toast.error(this.$t("Product is already added to compare"));
        } else {
          this.search_key_2 = item.name;
          this.last_selected_item = item.id;
          this.products_suggestions_last = [];
        }
      }
    },
    /**
     * Will get compare item details
     *
     */
    getCompareItems() {
      let formData = new FormData();
      formData.append("items", JSON.stringify(this.compareItems));
      axios
        .post("/api/v1/ecommerce-core/compare-items-details", formData)
        .then((response) => {
          this.success = true;
          if (response.data.success && response.data.data.length > 0) {
            this.search_key_1 = "";
            this.first_selected_item = "";
            this.products_suggestions_first = [];
            this.products_suggestions_last = [];
            this.search_key_2 = "";
            this.last_selected_item = "";
            this.productList = response.data.data;
            let data = [
              {
                title: this.$t("Name"),
                data: this.getData("name"),
              },
              {
                title: this.$t("Brand"),
                data: this.getData("brand"),
              },
              {
                title: this.$t("Category"),
                data: this.getData("category"),
              },

              {
                title: this.$t("Rating"),
                data: this.getData("avg_rating"),
              },
              {
                title: this.$t("Price"),
                data: this.getData("price"),
              },
              {
                title: this.$t("Warranty"),
                data: this.getData("has_warranty"),
              },

              {
                title: this.$t("Authentic"),
                data: this.getData("is_authentic"),
              },
              {
                title: this.$t("Refund"),
                data: this.getData("is_refundable"),
              },
              {
                title: this.$t("Cash on delivery"),
                data: this.getData("is_active_cod"),
              },
              {
                title: this.$t("Summary"),
                data: this.getData("summary"),
              },
              {
                title: this.$t("Availability"),
                data: this.getData("quantity"),
              },
              {
                data: this.getData("btn"),
              },
            ];
            this.tableData = data;
          } else {
            this.tableData = [];
          }
        })
        .catch((error) => {
          this.success = true;
          this.tableData = [];
        });
    },
    /**
     * Manipulate data
     *
     * @param {*} key
     */
    getData(key) {
      let items = [];
      for (let i = 0; i < this.productList.length; i++) {
        let temp = [];
        if (key == "name") {
          temp.id = this.productList[i].id;
          temp.name = this.productList[i].name;
          temp.search = true;
          temp.search_key = "";
          temp.search_result = [];
          temp.image = this.productList[i].thumbnail_image;
        } else if (key == "summary") {
          temp.summary = this.productList[i].summary;
        } else if (key == "btn") {
          temp.btn = this.productList[i];
        } else if (key == "avg_rating") {
          temp.rating = this.productList[i][key];
        } else if (key == "price") {
          temp.price = this.productList[i][key];
        } else if (key == "quantity") {
          temp.name =
            this.productList[i][key] > 0
              ? this.$t("In Stock")
              : this.$t("Stock out");
        } else {
          temp.name = this.productList[i][key];
        }
        items.push(temp);
      }
      return items;
    },
    /**
     * Search product
     *
     * @param {*} id
     */
    searchItemsFromList(id) {
      let match_item = "";
      let name_array = this.tableData.find((item) => item.title == "Name");
      if (name_array) {
        let data = name_array.data;
        match_item = data.find((item) => item.id == id);
      }
      let search_key = match_item.search_key;
      if (!search_key) {
        match_item.search_result = [];
      } else {
        axios
          .post("/api/v1/ecommerce-core/search-suggestions", {
            search_key: search_key,
          })
          .then((response) => {
            if (response.data.success) {
              match_item.search_result = response.data.products.data;
            }
          })
          .catch((error) => {
            match_item.search_result = [];
          });
      }
    },
    /**
     * Change compare item
     *
     * @param {*} previous_item
     * @param {*} current_item
     */
    changeCompareItem(previous_item, current_item) {
      let data = this.compareItems;
      data = data.map(function (item) {
        return item == previous_item ? current_item : item;
      });

      this.$store.dispatch("updateCompareItems", data).then((res) => {
        this.getCompareItems();
      });
    },
    /**
     * Search items
     * @param {*} item
     */
    searchItems(item) {
      if (item == "first") {
        this.products_suggestions_first = [];
        this.first_selected_item = "";
      } else {
        this.last_selected_item = "";
        this.products_suggestions_last = [];
      }

      axios
        .post("/api/v1/ecommerce-core/search-suggestions", {
          search_key: item == "first" ? this.search_key_1 : this.search_key_2,
        })
        .then((response) => {
          if (response.data.success) {
            if (item == "first") {
              this.products_suggestions_first = response.data.products.data;
            } else {
              this.products_suggestions_last = response.data.products.data;
            }
          }
        })
        .catch((error) => {
          if (item == "first") {
            this.products_suggestions_first = [];
          } else {
            this.products_suggestions_last = [];
          }
        });
    },
    /**
     * Compare selected products
     */
    viewComparison() {
      let items = [];
      if (this.first_selected_item != "") {
        items.push(this.first_selected_item);
      }
      if (this.last_selected_item != "") {
        items.push(this.last_selected_item);
      }

      if (items.length < 1) {
        this.$toast.error("Please select items to compare");
      }
      this.$store.dispatch("updateCompareItems", items).then((res) => {
        this.getCompareItems();
      });
    },
    /**
     * Remove item from compare list
     * @param {*} id
     */
    removeItem(id) {
      let data = this.compareItems;
      let updatedData = data.filter((item) => item !== id);
      this.$store.dispatch("updateCompareItems", updatedData).then((res) => {
        this.getCompareItems();
      });
    },
  },
};
</script>
<style lang="scss" scoped>
@import "../../assets/sass/00-abstracts/01-variables";
.remove-btn {
  padding: 11px 10px;
  background: #e92441;
  border: 1px solid #e6e6e6;
  color: white;
}
.search-suggestion {
  position: absolute;
  box-shadow: 7px 7px 60px rgb(0 0 0 / 7%);
  width: 100%;
  z-index: 99;
  max-height: 500px;
  min-height: 100px;
  overflow-y: scroll;
  overflow-x: hidden;
}
.search-suggestion .sugesstion_list {
  transition: 0.4s;
}
.search-suggestion .sugesstion_list:hover {
  color: $c1;
}

.compare-table td {
  font-weight: 400 !important;
}
</style>
