<template>
  <div class="widget blog-widget widget_recent_entries">
    <template v-if="featured_blog_widget != null">
      <h3 class="widget-title">
        {{ this.featured_blog_widget.widget_title }}
      </h3>
      <ul>
        <li
          v-for="(blog, index) in this.featured_blog_widget.featured_blogs"
          :key="index"
        >
          <div class="post-summary">
            <h5 class="post-title title-excerpt">
              <a :href="'/blog/' + blog.permalink">{{ blog.name }}</a>
            </h5>

            <span class="posted-on"
              ><a :href="'/blog/' + blog.permalink">{{
                blog.publish_at
              }}</a></span
            >
          </div>
        </li>
      </ul>
    </template>
  </div>
</template>
<script>
export default {
  name: "featured_blog_widget",
  props: {
    featured_blog_widget: {
      type: Object,
      required: false,
      default: () => {
        return {};
      },
    },
    sidebarOptionStyle: {
      type: Object,
      required: false,
      default: () => {
        return {};
      },
    },
  },
};
</script>
