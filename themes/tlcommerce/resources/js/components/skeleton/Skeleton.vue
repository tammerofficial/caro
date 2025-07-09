<template>
  <component class="skeleton" v-bind:is="tag" :style="cssVars"></component>
</template>
<script>
export default {
  name: "Skeleton",
  props: {
    height: {
      type: Number,
      required: false,
      default: "10px",
    },
    width: {
      type: Number,
      required: false,
      default: "50px",
    },
    borderRadius: {
      type: Number,
      required: false,
      default: "0px",
    },
    pill: {
      type: Boolean,
      required: false,
      default: false,
    },
    tag: {
      type: String,
      required: false,
      default: "span",
    },
  },
  computed: {
    cssVars() {
      return {
        "--height": this.height,
        "--width": this.width,
        "--border-radius": this.borderRadius,
      };
    },
  },
};
</script>
<style lang="scss" scoped>
.skeleton {
  height: var(--height) !important;
  min-width: var(--width) !important;
  border-radius: var(--border-radius);
  display: block;
  overflow: hidden;
  background-color: rgba(0, 0, 0, 0.12);
  position: relative;
  &::after {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    transform: translateX(-100%);
    background-image: linear-gradient(
      90deg,
      rgba(255, 255, 255, 0),
      rgba(255, 255, 255, 0.3),
      rgba(37, 22, 22, 0)
    );
    animation: shimmer 1.5s infinite;
    content: "";
  }
  @keyframes shimmer {
    100% {
      transform: translateX(100%);
    }
  }
}
</style>

