<template>
  <div class="page-header bg-light" :class="{ 'white-box': whiteBg }">
    <div class="custom-container2">
      <div class="align-items-center row">
        <div class="col-lg-6" v-if="title">
          <h2
            v-if="title"
            class="fs-20 mb-lg-0 page-title"
            :class="{ small: small }"
          >
            {{ title }}
          </h2>
        </div>
        <div class="col-lg-6 d-flex justify-content-lg-end" v-if="title">
          <CBreadcrumb style="--cui-breadcrumb-divider: '>'">
            <CBreadcrumbItem
              :href="item.href"
              v-for="item in items"
              :class="{ active: item.active }"
              :key="item"
              >{{ item.text }}</CBreadcrumbItem
            >
          </CBreadcrumb>
        </div>
        <div class="col-lg-6" v-else>
          <CBreadcrumb style="--cui-breadcrumb-divider: '>'">
            <CBreadcrumbItem
              :href="item.href"
              v-for="item in items"
              :class="{ active: item.active }"
              :key="item"
              >{{ item.text }}</CBreadcrumbItem
            >
          </CBreadcrumb>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { CBreadcrumb, CBreadcrumbItem } from "@coreui/vue";
export default {
  name: "PageHeader",
  components: {
    CBreadcrumb,
    CBreadcrumbItem,
  },
  props: {
    title: {
      type: String,
      default: "",
    },
    whiteBg: {
      type: Boolean,
      default: false,
    },
    items: {
      type: Array,
      default: () => {
        return [];
      },
    },
    small: {
      type: Boolean,
      default: false,
    },
  },
};
</script>

<style lang="scss" scoped>
.page-header {
  padding: 16px 0;
}
.fs-20 {
  font-size: 20px !important;
}
</style>
