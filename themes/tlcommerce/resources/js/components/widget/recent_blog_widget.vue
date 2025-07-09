<template>
  <div class="widget blog-widget widget_recent_posts">
    <template v-if="recent_blog_widget != null">
      <h3 class="widget-title">
        {{ this.recent_blog_widget.widget_title }}
      </h3>
      <ul>
        <li
          v-for="(blog, index) in this.recent_blog_widget.recent_blog"
          :key="index"
        >
          <!-- Single Recent Post -->
          <div class="post-summary">
            <span class="posted-on"
              ><a :href="'/blog/' + blog.permalink">
                {{ blog.publish_at }}
              </a>
            </span>

            <h5 class="post-title mt-2 title-excerpt">
              <a :href="'/blog/' + blog.permalink">
                {{ blog.name }}
              </a>
            </h5>

            <p class="post-excerpt details-excerpt">
              {{ blog.short_description }}
            </p>
          </div>
          <!-- End Single Recent Post -->
        </li>
      </ul>
    </template>
  </div>
</template>
<script>
export default {
  name: "recent_blog_widget",
  props: {
    recent_blog_widget: {
      type: Object,
      required: false,
      default: () => {
        return {};
      },
    },
  },
};
</script>
