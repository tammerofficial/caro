<template>
  <div class="py-2">
    <p class="text text-danger">{{ $t(title) }}</p>
  </div>
</template>
<script>
export default {
  name: "NoFound",
  props: {
    title: {
      type: String,
      default: "Item not found",
      required: false,
    },
    redirect: {
      type: Boolean,
      default: false,
      required: false,
    },
    redirectBtnLabel: {
      type: String,
      default: "Go to home",
      required: false,
    },
    redirectUrl: {
      type: String,
      required: false,
      default: "/",
    },
    image: {
      type: Boolean,
      required: false,
      default: "/",
    },
  },
};
</script>
