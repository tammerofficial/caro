<template>
  <router-link
    v-if="styleTwo"
    class="category-card--two bg-cover"
    :to="`/products/category/${cat.slug}`"
    :style="cat.icon ? { backgroundImage: `url(${cat.icon})` } : ''"
  >
    <span class="category-content text-center d-block">
      <span class="category-name d-block">{{ cat.name }}</span>
    </span>
  </router-link>

  <router-link
    v-else
    class="category-card"
    :to="`/products/category/${cat.slug}`"
  >
    <v-lazy-image :src="`${cat.icon}`" :alt="cat.name" />
    <span>{{ cat.name }}</span>
  </router-link>
</template>

<script>
import VLazyImage from "v-lazy-image";
export default {
  name: "CategoryCard",
  components: {
    "v-lazy-image": VLazyImage,
  },
  props: {
    cat: {
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
@import "../../assets/sass/00-abstracts/01-variables";
.category-card {
  padding: 20px;
  background-color: #f7f8fa;
  display: flex;
  align-items: center;
  width: 100%;
  line-height: 1.4;
  img {
    border: 1px solid rgba(#707070, 0.3);
    padding: 5px;
    border-radius: 50%;
    margin-right: 15px;
    min-width: 60px;
    height: 60px;
    object-fit: cover;
  }
  span {
    font-size: 16px;
    font-weight: 500;
  }
  @media (max-width: 480px) {
    padding: 10px;
    img {
      margin-right: 10px;
      min-width: 40px;
      height: 40px;
    }
    span {
      font-size: 14px;
    }
  }
  &--two {
    padding: 80px 0;
    .category {
      &-content {
        display: block;
        padding: 15px 20px;
        position: relative;
        color: $title-color-four;
        z-index: 1;
        transition: 0.3s ease-in;
        opacity: 0;
        visibility: hidden;
        &:after {
          position: absolute;
          left: 0;
          top: 0;
          width: 100%;
          height: 100%;
          content: "";
          background: rgb(255, 255, 255);
          background: linear-gradient(
            90deg,
            rgba(255, 255, 255, 0) 0%,
            rgba(255, 255, 255, 1) 50%,
            rgba(255, 255, 255, 0) 100%
          );
          z-index: -1;
          opacity: 0.4;
        }
      }
      &-name {
        font-size: 24px;
        font-weight: $bold;
        font-family: $title-font;
        $lh: 1.5;
        line-height: $lh;
      }
    }
    &:hover {
      .category {
        &-content {
          opacity: 1;
          visibility: visible;
        }
      }
    }
  }
}
</style>
