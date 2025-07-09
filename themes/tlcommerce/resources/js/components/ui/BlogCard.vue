<template>
  <div class="blog-card d-inline-flex flex-column">
    <!-- Image -->
    <a
      class="blog-card-image d-block"
      :href="`/blog/${blog.permalink}`"
      v-if="blog.image != null"
    >
      <v-lazy-image :src="blog.image" :alt="blog.title" />
    </a>
    <!-- End Image -->

    <!-- Content -->
    <div
      class="style--two blog-card-content d-flex flex-column align-items-start"
      v-if="styleTwo"
    >
      <span class="blog-card-date">{{ blog.date }}</span>
      <h3 class="blog-card-title">
        <a :href="`/blog/${blog.permalink}`">
          {{ blog.title }}
        </a>
      </h3>
      <a class="btn-underline" :href="`/blog/${blog.permalink}`">
        <span
          v-if="
            blogOptionStyle &&
            blogOptionStyle.custom_blog == 1 &&
            blogOptionStyle.read_more_text_setting != 'default'
          "
        >
          {{ blogOptionStyle.read_more_text }}
        </span>
        <span v-else>
          {{ $t("Read more") }}
        </span>
      </a>
    </div>

    <div class="blog-card-content d-flex flex-column align-items-start" v-else>
      <span class="blog-card-date">{{ blog.date }}</span>
      <h3 class="blog-card-title">
        <a :href="`/blog/${blog.permalink}`">
          {{ blog.title }}
        </a>
      </h3>
      <a class="btn-underline" :href="`/blog/${blog.permalink}`">
        <span
          v-if="
            blogOptionStyle &&
            blogOptionStyle.custom_blog == 1 &&
            blogOptionStyle.read_more_text_setting != 'default'
          "
        >
          {{ blogOptionStyle.read_more_text }}
        </span>
        <span v-else>
          {{ $t("Read more") }}
        </span>
      </a>
    </div>
    <!-- End Content -->
  </div>
</template>

<script>
import VLazyImage from "v-lazy-image";
export default {
  name: "BlogCard",
  components: {
    VLazyImage,
  },
  props: {
    blog: {
      type: Object,
      required: true,
    },
    blogOptionStyle: {
      default: null,
      type: Object,
      required: true,
    },
    styleTwo: {
      type: Boolean,
      default: false,
    },
  },
};
</script>

<style lang="scss" scoped>
.blog-card {
  &-content {
    background: #f7f8fa;
    padding: 20px;
  }
  &-date {
    display: inline-block;
    $lh: 1.437;
    line-height: $lh;
    font-size: 14px;
  }
  &-title {
    margin: 4px 0 12px;
    font-size: 18px;
    font-weight: 500;
    $lh: 1.476;
    line-height: $lh;
    display: -webkit-box;
    -webkit-box-orient: vertical;
    -webkit-line-clamp: 1;
    overflow: hidden;
  }
}

.style--two.blog-card {
  &-content {
    background: #fff;
  }
}
</style>
