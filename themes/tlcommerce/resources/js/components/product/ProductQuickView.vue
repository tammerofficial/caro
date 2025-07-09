<template>
  <teleport to="body">
    <CModal
      scrollable
      :visible="visibleQuickView"
      size="lg"
      @close="
        () => {
          visibleQuickView = false;
        }
      "
    >
      <CModalHeader>
        <button class="btn-circle bg-black size-35" @click="close()">
          <base-icon-svg name="close" :width="10" :height="10" />
        </button>
      </CModalHeader>

      <CModalBody>
        <div class="row">
          <div class="col-lg-6 mb-30 mb-lg-0">
            <details-gallery
              :id="product.id"
              :gallery-images="product.galleryImages"
              :name="product.name"
              :description="product.shortDescription"
              :voucher-list="product.voucher_list"
            />
          </div>

          <div class="col-lg-6">
            <details-content
              :product="product"
              @color-variant-images="colorVariantImages"
            />
          </div>
        </div>
      </CModalBody>
    </CModal>
  </teleport>
</template>
<script>
import DetailsGallery from "@/components/product/DetailsGallery.vue";
import DetailsContent from "@/components/product/DetailsContent.vue";
import axios from "axios";
import {
  CModal,
  CButton,
  CModalHeader,
  CModalTitle,
  CModalBody,
} from "@coreui/vue";
export default {
  name: "ProductQuickView",
  components: {
    CModal,
    CButton,
    CModalHeader,
    CModalTitle,
    CModalBody,
    DetailsGallery,
    DetailsContent,
  },
  props: {
    slug: {
      type: String,
      required: true,
    },
    isVisible: {
      type: Boolean,
      default: false,
      required: false,
    },
  },
  data() {
    return {
      product: {},
      visibleQuickView: false,
    };
  },
  mounted() {
    if (this.isVisible) {
      this.productQuickView();
    }
  },
  methods: {
    /**
     * Product quick view
     */
    productQuickView() {
      axios
        .post("/api/v1/ecommerce-core/product-details", {
          permalink: this.slug,
        })
        .then((response) => {
          if (response.data.success) {
            this.product = response.data.data;
            this.visibleQuickView = true;
          } else {
            this.$toast.error(this.$t("Product Loading Failed"));
          }
        })
        .catch((error) => {
          this.$toast.error(this.$t("Product Loading Failed"));
        });
    },
    /**
     * Color variant gallery images
     */
    colorVariantImages(color_id) {
      this.$store.dispatch("showPreloader", true);
      this.galleryKey = this.galleryKey + 1;
      axios
        .post("/api/v1/ecommerce-core/color-variant-images", {
          product_id: this.product.id,
          color_id: color_id,
        })
        .then((response) => {
          if (response.data.success) {
            this.product.galleryImages = response.data.images;
            this.$store.dispatch("showPreloader", false);
          } else {
            this.$store.dispatch("showPreloader", false);
          }
        })
        .catch((error) => {
          this.$store.dispatch("showPreloader", false);
        });
    },
    close() {
      this.visibleQuickView = false;
    },
  },
};
</script>
