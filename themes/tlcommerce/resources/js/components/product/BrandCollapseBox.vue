<template>
  <div
    class="d-flex align-items-start justify-content-between mt-10"
    v-if="!brandLoading && brands.length > 0"
  >
    <div class="brands-collapse-box" :class="{ showFull: showFull }">
      <ul class="list-unstyled inline-links d-flex flex-wrap mb-0">
        <li v-for="(brand, index) in brands" :key="index">
          <button class="fz-12" @click.prevent="addBrandFilter(brand)">
            <img :src="brand.logo" :alt="brand.name" class="mr-1" />{{
              brand.name
            }}
          </button>
        </li>
      </ul>
    </div>
    <!-- Load More Button -->
    <button
      v-if="!brandLoading && brands.length > 3"
      class="btn_loadmore"
      @click.prevent="brandBoxCollapse()"
    >
      <span class="material-icons">{{ showFull ? "remove" : "add" }}</span>

      {{ showFull ? $t("Less") : $t("More") }}
    </button>
    <!-- End Load More Button -->
  </div>
</template>
<script>
export default {
  name: "BrandCollapseBox",
  emits: ["select-brand"],
  props: {
    brands: {
      type: Array,
      require: true,
      default: [],
    },
    brandLoading: {
      type: Boolean,
      default: true,
    },
  },
  data() {
    return {
      showFull: false,
    };
  },
  methods: {
    brandBoxCollapse() {
      this.showFull = !this.showFull;
    },

    addBrandFilter(item) {
      this.$emit("select-brand", item);
    },
  },
};
</script>
