<template>
  <div
    class="single-overview white-box pt-15 pb-15 pl-20 pr-20 mb-30 text-center"
    :class="{ bgclass }"
  >
    <span class="text-soft">{{ $t(title) }}</span>
    <h2 class="font-weight-medium mb-0" v-if="currency">
      <the-currency :amount="counter"></the-currency>
    </h2>
    <h2 class="font-weight-medium mb-0" v-else>
      {{ counter }}
    </h2>
  </div>
</template>
<script>
export default {
  name: "DashboardCard",
  props: {
    bgclass: {
      type: String,
      required: false,
    },
    title: {
      type: String,
      required: false,
    },
    counter: {
      type: Number,
      default: 0,
    },
    currency: {
      type: Boolean,
      default: false,
    },
  },
};
</script>

<style lang="scss" scoped>
.single-overview {
  h2 {
    margin-top: 3px;
    font-size: 36px;
  }
}
</style>
