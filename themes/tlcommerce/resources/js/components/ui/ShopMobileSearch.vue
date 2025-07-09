<template>
  <div class="search-form-wrapper">
    <form
      class="shop-mobile-search-form"
      :class="{ active: searchFormActive }"
      action="#"
    >
      <button
        type="button"
        class="goback d-inline-flex align-items-center justify-content-center"
        @click.prevent="toggleSearchForm"
      >
        <base-icon-svg name="undo" :height="20" :width="20" />
      </button>

      <div class="w-100 d-flex align-items-center">
        <input
          type="text"
          placeholder="Search in Store…"
          class="form-control"
        />
        <button type="submit" class="search-icon-btn">
          <span class="material-icons"> search </span>
        </button>
      </div>
    </form>
    <button
      type="submit"
      class="mobile-search-toggle"
      @click.prevent="toggleSearchForm"
    >
      <span class="material-icons"> search </span>
    </button>
  </div>
</template>

<script>
export default {
  name: "ShopMobileSearchForm",
  data() {
    return {
      searchFormActive: false,
    };
  },
  methods: {
    toggleSearchForm() {
      this.searchFormActive = !this.searchFormActive;
    },
  },
};
</script>
