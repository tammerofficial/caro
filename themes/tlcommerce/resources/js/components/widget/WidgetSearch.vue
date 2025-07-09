<template>
  <div class="widget blog-widget widget_search">
    <div class="search-form">
      <div class="theme-input-group">
        <input
          type="search"
          class="theme-input-style"
          v-bind:placeholder="$t('Search Here')"
          v-model="searchKey"
        />
        <a
          :href="'/blogs/search-result?searchKey=' + searchKey"
          class="submit-btn btn btn-sm"
        >
          <span class="material-icons"> search </span>
        </a>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  data() {
    return {
      searchKey: "",
    };
  },
};
</script>
