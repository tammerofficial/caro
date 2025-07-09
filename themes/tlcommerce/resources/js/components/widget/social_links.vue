<template>
  <ul class="widget nav share-list gap-1">
    <li v-for="(social, index) in social_links" :key="`social-${index}`">
      <a
        :class="
          this.socialStyle.custom_social == 1
            ? 'custom-icon-style btn-circle size-35'
            : 'btn-circle bg-transparent size-35'
        "
        :href="social.social_icon_url"
        target="_blank"
      >
        <i :class="'fa ' + social.social_icon"></i>
      </a>
    </li>
  </ul>
</template>

<script>
export default {
  name: "social_links",
  props: {
    social_links: {
      type: Array,
      default: () => [],
    },
    styleTwo: {
      type: Boolean,
      default: false,
    },
    socialStyle: {
      type: Object,
      required: false,
      default: () => {
        return {};
      },
    },
  },
};
</script>

<style scoped>
</style>