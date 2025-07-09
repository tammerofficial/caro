<template>
  <div class="showing-per-page">
    <slot :total="totalItems">
      <span v-if="totalItems > 0">
        Showing {{ start + 1 }} to {{ end }} of {{ totalItems }}
      </span>
      <span v-else class="text-danger">{{ $t("There is no item to show") }}</span>
    </slot>
  </div>
</template>

<script>
export default {
  props: {
    itemsPerPage: {
      type: Number,
      default: 10,
      validator: (itemsPerPage) => {
        return itemsPerPage > 0;
      },
    },
    currentPage: {
      type: Number,
      default: 1,
    },
    totalItems: {
      type: Number,
      required: true,
      validator: (totalItems) => {
        return totalItems >= 0;
      },
    },
  },
  computed: {
    start() {
      return this.currentPage * this.itemsPerPage - this.itemsPerPage;
    },
    end() {
      const end = this.start + this.itemsPerPage;

      return this.totalItems < end ? parseInt(this.totalItems) : parseInt(end);
    },
  },
};
</script>

<style></style>
