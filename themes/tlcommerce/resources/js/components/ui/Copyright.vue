<template v-if="siteProperties.copyright">
  <span class="copyright" v-html="siteProperties.copyright"> </span>
</template>

<script>
export default {
  name: "Copyright",
  props: {
    siteProperties: {
      type: Object,
      required: false,
    },
  },
  data() {
    return {
      currentYear: new Date().getFullYear(),
    };
  },
};
</script>
