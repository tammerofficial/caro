<template>
  <div class="sorting-dropdown">
    <div class="d-flex justify-content-lg-end" v-if="!dataLoading">
      <ul
        class="filter-wrap list-unstyled inline-links d-grid d-lg-flex flex-wrap align-items-center mb-3 mb-lg-0"
      >
        <li class="d-none d-lg-block me-2">
          <strong>{{ $t("Sort By") }} :</strong>
        </li>
        <li>
          <select
            class="theme-input-style"
            v-on:change="getProducts"
            v-model="selectedItem"
          >
            <option
              v-for="sortItem in sortLists"
              :key="sortItem.value"
              :value="sortItem.value"
            >
              {{ $t(sortItem.name) }}
            </option>
          </select>
        </li>
        <li>
          <button
            type="button"
            class="filter_btn d-inline-flex d-lg-none align-items-center justify-content-center border-0 ms-3"
            @click.prevent="filterToggle"
          >
            <span class="material-icons"> filter_alt </span>
          </button>
        </li>
      </ul>
    </div>
    <div v-if="dataLoading" class="desktop">
      <skeleton
        border-radius="5px"
        height="30px"
        class="w-50 float-end"
      ></skeleton>
    </div>
  </div>
</template>
<script>
export default {
  name: "SortingOption",
  emits: ["sorting-items", "filter-toggle"],
  props: {
    dataLoading: {
      type: Boolean,
      default: false,
    },
  },
  data() {
    return {
      selectedItem: "newest",
      sortLists: [
        {
          name: "Newest items",
          value: "newest",
        },
        {
          name: "Popular items",
          value: "popular",
        },

        {
          name: "Price low to high",
          value: "lowToHigh",
        },
        {
          name: "Price high to low",
          value: "highToLow",
        },
      ],
    };
  },
  methods: {
    getProducts() {
      this.$emit("sorting-items", this.selectedItem);
    },
    filterToggle() {
      this.$emit("filter-toggle");
    },
  },
};
</script>