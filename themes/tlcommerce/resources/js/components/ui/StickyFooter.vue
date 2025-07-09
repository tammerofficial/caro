<template>
  <div class="bottom-tabbar-list d-md-none">
    <router-link to="/">
      <span class="material-icons"> home </span>
      <span class="mt-1">{{ $t("Home") }}</span>
    </router-link>
    <router-link to="/categories">
      <span class="material-icons"> category </span>
      <span class="mt-1">{{ $t("Category") }}</span>
    </router-link>
    <router-link to="/dashboard/wishlist">
      <span class="material-icons"> favorite </span>
      <span class="mt-1">{{ $t("Wishlist") }}</span>
    </router-link>
    <router-link to="/dashboard">
      <span class="material-icons"> person </span>
      <span class="mt-1">{{ $t("My Account") }}</span>
    </router-link>
  </div>
</template>
<script>
export default {
  name: "StickyFooter",
  data() {
    return {
      styled: false,
    };
  },
};
</script>

<style lang="scss" scoped>
@import "../../assets/sass/00-abstracts/01-variables";
.bottom-tabbar-list {
  display: flex;
  height: 48px;
  position: fixed;
  bottom: 0;
  left: 0;
  right: 0;
  z-index: 98;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
  background-color: #fff;
  box-sizing: border-box;
  a {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    flex: 1;
    flex-basis: 1px;
    box-sizing: border-box;
    color: #59818e;
    width: 1px;
    text-decoration: none;
    opacity: 0.7;
    span:not(.material-icons) {
      color: #000000;
      font-size: 10px;
      line-height: 1;
    }
    .material-icons {
      color: $c1;
      font-size: 21px;
    }
    img {
      margin-bottom: 5px;
    }
    &.router-link-exact-active {
      background-color: #f0f0f0;
      opacity: 1;
      span {
        color: $c1;
      }
    }
  }
}
</style>
