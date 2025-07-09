<template>
  <!-- Widget -->
  <div class="widget widget-style-1 widget_top_category mb-4">
    <h5>
      <span>{{ $t("Top Categories") }}</span>
      <span
        @click.prevent="showCategoryWidget = !showCategoryWidget"
        class="widget-collapse-toggle"
        ><span class="material-icons">
          {{ showCategoryWidget ? "expand_less" : "expand_more" }}
        </span></span
      >
    </h5>
    <ul class="list-unstyled mb-0" v-if="showCategoryWidget">
      <template v-for="(cat, index) in categories">
        <li :key="index" v-if="index <= max_cat">
          <div v-if="link">
            <router-link :to="`/products/category/${cat.slug}`">{{
              cat.name
            }}</router-link>
          </div>
          <div v-else>
            <input
              type="radio"
              name="category_group"
              :id="cat.name"
              :value="cat.name"
              :checked="cat == selectedCat"
              @change="filter(cat)"
            />
            <label :for="cat.name">{{ cat.name }}</label>
          </div>
        </li>
      </template>

      <li v-if="categories.length > max_cat">
        <button class="btn_underline" @click.prevent="ViewMore('cat')">
          {{ $t("View More") }}
        </button>
      </li>
      <li v-if="max_cat > 6">
        <button class="btn_underline" @click.prevent="ViewLess('cat')">
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
  data() {
    return {
      showCategoryWidget: true,
      max_cat: 6,
    };
  },
  props: {
    categories: {
      type: Array,
      required: false,
    },
    selectedCat: {
      type: Object,
      required: false,
    },
    link: {
      type: Boolean,
      default: false,
      required: false,
    },
  },
  methods: {
    ViewMore(item) {
      if (item === "cat") {
        this.max_cat = this.categories.length;
      }
    },
    ViewLess(item) {
      if (item === "cat") {
        this.max_cat = 6;
      }
    },
    filter(category) {
      this.$emit("filter", category);
    },
  },
};
</script>
