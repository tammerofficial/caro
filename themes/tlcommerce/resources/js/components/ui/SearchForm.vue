<template>
  <div class="search-form-wrapper custom-search-btn-mobile">
    <!-- Search Toggle -->
    <button
      v-if="mobileStyle"
      class="p-0 bg-transparent border-0 text-white"
      @click="toggleSearchForm"
    >
      <base-icon-svg name="search" :height="21" :width="21" />
    </button>
    <!-- End Search Toggle -->

    <form
      class="search-form"
      :class="[
        mobileStyle
          ? 'mobile-search-form position-absolute w-100 h-100 d-flex align-items-center'
          : '',
        { active: searchFormActive },
      ]"
      action="#"
    >
      <button
        v-if="mobileStyle"
        type="button"
        class="goback border-0 mr-20 d-inline-flex align-items-center justify-content-center"
        @click="toggleSearchForm"
      >
        <base-icon-svg name="undo" :height="20" :width="20" />
      </button>

      <div
        class="input-group"
        :class="[
          { 'style--rounded': rounded },
          { 'style--two': styleTwo },
          { 'style--three': styleThree },
          { 'style--four': styleFour },
        ]"
      >
        <input
          type="text"
          v-bind:placeholder="$t('Enter your search key')"
          class="form-control"
          v-model="searching_Key"
          v-on:keyup="getSearchSuggestions"
        />
        <button
          v-if="!styleFour"
          type="submit"
          class="btn btn_fill custom-search-btn"
          @click.prevent="searchProducts"
        >
          {{ $t("Search") }}
        </button>
        <button
          v-else
          type="submit"
          class="search-icon-btn"
          @click.prevent="searchProducts"
        >
          <span class="material-icons"> search </span>
        </button>
      </div>
    </form>
  </div>
</template>

<script>
export default {
  name: "SearchForm",
  emits: ["search-suggestions"],
  props: {
    rounded: {
      type: Boolean,
      default: false,
    },
    styleTwo: {
      type: Boolean,
      default: false,
    },
    styleThree: {
      type: Boolean,
      default: false,
    },
    styleFour: {
      type: Boolean,
      default: false,
    },
    mobileStyle: {
      type: Boolean,
      default: false,
    },
  },
  data() {
    return {
      searchFormActive: false,
      searching_Key: "",
    };
  },
  watch: {
    $route(to, from) {
      const destinationRouteName = to.name;
      if (destinationRouteName != "searchProduct") {
        this.searching_Key = "";
      }
    },
  },
  methods: {
    /**
     * get search suggestions
     */
    getSearchSuggestions(event) {
      if (event.key != "Enter") {
        this.$emit("search-suggestions", this.searching_Key);
      }
    },
    /**
     * Search Products
     *
     */
    searchProducts() {
      this.searchFormActive = false;
      this.$router.push("/product/search?search_key=" + this.searching_Key);
    },
    toggleSearchForm() {
      this.searchFormActive = !this.searchFormActive;
    },
  },
};
</script>
