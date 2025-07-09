<template>
  <!-- Widget -->
  <div class="widget widget-style-1 widget_brand mb-4">
    <h5>
      <span>{{ $t("Brand") }}</span>
      <span
        @click="showBrandWidget = !showBrandWidget"
        class="widget-collapse-toggle"
        ><span class="material-icons">
          {{ showBrandWidget ? "expand_less" : "expand_more" }}
        </span></span
      >
    </h5>
    <ul class="list-unstyled mb-0" v-if="showBrandWidget">
      <template v-for="(brand, index) in brands">
        <li :key="index" v-if="index <= max_brand">
          <input
            type="radio"
            name="brand_group"
            class="brand-filter"
            :id="brand.name + index"
            :value="brand.name"
            :checked="brand == selectedBrand"
            @change="filter(brand)"
          />
          <label :for="brand.name + index">{{ brand.name }} </label>
        </li>
      </template>

      <li v-if="brands.length > max_brand">
        <button class="btn_underline" @click.prevent="ViewMore('brand')">
          {{ $t("View More") }}
        </button>
      </li>
      <li v-if="max_brand > 6">
        <button class="btn_underline" @click.prevent="ViewLess('brand')">
          {{ $t("View Less") }}
        </button>
      </li>
    </ul>
  </div>
  <!-- Widget -->
</template>

<script>
export default {
  emits: ["filter"],
  props: {
    brands: {
      type: Array,
      required: false,
    },
    selectedBrand: {
      type: Object,
      required: false,
    },
  },
  data() {
    return {
      showBrandWidget: true,
      max_brand: 3,
    };
  },
  methods: {
    ViewMore(item) {
      if (item === "brand") {
        this.max_brand = this.brands.length;
      }
    },
    ViewLess(item) {
      if (item === "brand") {
        this.max_brand = 3;
      }
    },
    filter(brand) {
      this.$emit("filter", brand);
    },
  },
};
</script>
