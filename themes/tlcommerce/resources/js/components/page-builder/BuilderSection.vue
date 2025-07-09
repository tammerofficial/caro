<template>
  <!-- Section Loop -->
  <section
    v-for="(section, index) in sections"
    :id="'section_' + section['id'] + '_' + section['page_id']"
    :key="index"
  >
    <div :class="sectionContainer(section)">
      <div :class="'row ' + sectionVertical(section)">
        <!-- Section Layouts Loop -->
        <div
          v-for="(section_layouts, index) in section['layouts']"
          :class="'col-sm-' + section_layouts['col_value'] + ' p-0'"
          :key="index"
        >
          <!-- Section Layouts Widgets Loop -->
          <div
            v-for="(layout_widget, index) in section_layouts['layout_widgets']"
            :key="index"
            :class="
              'widget w-100 mb-0 ' +
              widgetAlignment(layout_widget) +
              Rtl(layout_widget) +
              ' ' +
              isListBlog(layout_widget)
            "
            :id="'section_' + section['id'] + '_widget_' + layout_widget['id']"
          >
            <component
              :is="modifiedWidgetName(layout_widget['widget']['name'])"
              v-if="
                !isEmpty(layout_widget['properties']) &&
                !isEmpty(layout_widget['properties']['properties'])
              "
              :properties="layout_widget['properties']['properties']"
            />
          </div>
        </div>
      </div>
    </div>
  </section>
</template>
<script>
import { defineAsyncComponent } from "vue";
const Ads = defineAsyncComponent(() => import("./widgets/Ads.vue"));
const Banner = defineAsyncComponent(() => import("./widgets/Banner.vue"));
const Blogs = defineAsyncComponent(() => import("./widgets/Blogs.vue"));
const Button = defineAsyncComponent(() => import("./widgets/Button.vue"));
const CategorySlider = defineAsyncComponent(() =>
  import("./widgets/CategorySlider.vue")
);
const CustomProduct = defineAsyncComponent(() =>
  import("./widgets/CustomProduct.vue")
);
const FeaturedProduct = defineAsyncComponent(() =>
  import("./widgets/FeaturedProduct.vue")
);
const FlashDeal = defineAsyncComponent(() => import("./widgets/FlashDeal.vue"));
const HeadingTag = defineAsyncComponent(() =>
  import("./widgets/HeadingTag.vue")
);
const Image = defineAsyncComponent(() => import("./widgets/Image.vue"));
const ListBlog = defineAsyncComponent(() => import("./widgets/ListBlog.vue"));
const Newsletter = defineAsyncComponent(() =>
  import("./widgets/Newsletter.vue")
);
const ProductCollection = defineAsyncComponent(() =>
  import("./widgets/ProductCollection.vue")
);
const SellerList = defineAsyncComponent(() =>
  import("./widgets/SellerList.vue")
);
const TextEditor = defineAsyncComponent(() =>
  import("./widgets/TextEditor.vue")
);

export default {
  name: "BuilderSection",
  components: {
    Ads,
    Banner,
    Blogs,
    Button,
    CategorySlider,
    CustomProduct,
    FeaturedProduct,
    FlashDeal,
    HeadingTag,
    Image,
    ListBlog,
    Newsletter,
    ProductCollection,
    SellerList,
    TextEditor,
  },
  data() {
    return {
      RTL: document.querySelector("html").className == "rtl" ? "-rtl" : "",
    };
  },

  props: {
    page: {
      type: Object,
      default: {},
    },
    sections: {
      type: Array,
      default: [],
    },
    widgets: {
      type: Array,
      default: [],
    },
  },

  beforeMount() {
    setTimeout(() => {
      this.$emit("sectionLoaded");
    }, 1000);
  },

  methods: {
    /**
     * Widget Name Change
     */
    modifiedWidgetName(name) {
      return name
        .split("_")
        .map((str) => str.charAt(0).toUpperCase() + str.slice(1))
        .join("");
    },

    /**
     * Check Properties
     */
    isEmpty(value) {
      return (
        value == null ||
        value === "" ||
        (typeof value === "object" && Object.keys(value).length === 0)
      );
    },

    /**
     * Check Container
     */
    sectionContainer(section) {
      if (
        !this.isEmpty(section["properties"]) &&
        !this.isEmpty(section["properties"]["properties"])
      ) {
        if (!this.isEmpty(section["properties"]["properties"]["container"])) {
          if (section["properties"]["properties"]["container"] == "container") {
            return "custom-container2";
          }
          return section["properties"]["properties"]["container"];
        }
      }
      return "custom-container2";
    },

    /**
     * Section Vertical Alignment
     */
    sectionVertical(section) {
      if (
        !this.isEmpty(section["properties"]) &&
        !this.isEmpty(section["properties"]["properties"])
      ) {
        if (!this.isEmpty(section["properties"]["properties"]["vertical"])) {
          return (
            "align-items-" + section["properties"]["properties"]["vertical"]
          );
        }
      }
      return "align-items-start";
    },

    /**
     * Widget Horizontal Alignment
     */
    widgetAlignment(widget) {
      if (
        !this.isEmpty(widget["properties"]) &&
        !this.isEmpty(widget["properties"]["properties"])
      ) {
        if (!this.isEmpty(widget["properties"]["properties"]["alignment"])) {
          return "text-" + widget["properties"]["properties"]["alignment"];
        }
      }
      return "text-start";
    },

    /**
     * Check If Widget is List Blog
     */
    isListBlog(widget) {
      if (
        !this.isEmpty(widget["widget"]) &&
        !this.isEmpty(widget["widget"]["name"])
      ) {
        if (widget["widget"]["name"] === "list_blog") {
          return "widget_recent_entries";
        }
      }
      return "";
    },

    /**
     * RTL Check
     */
    Rtl(widget) {
      if (this.widgetAlignment(widget) != "text-center") {
        return this.RTL;
      } else {
        return "";
      }
    },
  },
};
</script>
<style scoped>
.text-start-rtl {
  text-align: right !important;
}
.text-end-rtl {
  text-align: left !important;
}
</style>
