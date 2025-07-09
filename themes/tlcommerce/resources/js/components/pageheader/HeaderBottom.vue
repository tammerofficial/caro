<template>
  <!-- Header Bottom -->
  <div
    :class="
      this.headerStyle.custom_header == 1
        ? 'custom-header-bottom header-bottom'
        : 'header-bottom'
    "
  >
    <div class="custom-container2">
      <div
        class="row position-relative align-items-center justify-content-between"
      >
        <div class="col-lg-auto position-static d-flex align-items-center">
          <!-- MegaMenu -->
          <mega-menu v-if="!dataLoading" :mega-categories="megaCategories" />
          <div v-if="dataLoading" class="megamenu-wrapper">
            <skeleton height="15px" border-radius="10px" width="100px">
            </skeleton>
          </div>
          <!-- End MegaMenu -->

          <!-- Menu -->
          <div v-if="dataLoading">
            <ul class="nav-horizontal desktop">
              <li v-for="(item, index) in menuSkeletons" :key="index">
                <skeleton height="12px" border-radius="10px" :width="item">
                </skeleton>
              </li>
            </ul>
          </div>
          <HorizontalMenu
            v-else
            :menu-items="menuItems"
            :header-menu-style="headerMenuStyle"
          />
          <!-- End Menu -->
        </div>

        <div class="col-lg-auto text-right">
          <!--Static Header-->
          <template v-if="this.headerStyle.custom_header != 1">
            <a
              v-if="
                !dataLoading && this.headerStyle.header_bot_email_text != ''
              "
              class="font-weight-medium text-color-white"
              href="#"
              ><span class="d-none d-xl-inline"></span>
            </a>
            <a v-if="dataLoading">
              <skeleton height="12px" border-radius="10px" width="110px">
              </skeleton>
            </a>
          </template>
          <!--End Static Header-->
          <!--Custom Header-->
          <template v-else>
            <a
              v-if="
                !dataLoading && this.headerStyle.header_bot_email_text != ''
              "
              class="font-weight-medium text-color-white"
              href="#"
            >
              <i
                :class="'m-1 pr-3 fa ' + headerStyle.header_bot_email_text_icon"
              ></i>

              <span class="d-none d-xl-inline">
                {{ this.headerStyle.header_bot_email_text }}
              </span>
            </a>

            <a v-if="dataLoading">
              <skeleton height="12px" border-radius="10px" width="110px">
              </skeleton>
            </a>
          </template>
          <!--End custom Header-->
        </div>
      </div>
    </div>
  </div>
  <!-- End Header Bottom -->
</template>
<script>
import MegaMenu from "@/components/menu/MegaMenu.vue";
import HorizontalMenu from "@/components/menu/HorizontalMenu.vue";
export default {
  name: "HeaderBottom",
  components: {
    MegaMenu,
    HorizontalMenu,
  },
  props: {
    megaCategories: {
      type: Array,
      required: false,
      default: () => {
        return [];
      },
    },
    menuItems: {
      type: Array,
      required: false,
      default: () => {
        return [];
      },
    },
    headerStyle: {
      type: Object,
      required: false,
      default: () => {
        return {};
      },
    },
    headerMenuStyle: {
      type: Object,
      required: false,
      default: () => {
        return {};
      },
    },
    dataLoading: {
      type: Boolean,
      required: true,
      default: false,
    },
  },
  data() {
    return {
      menuSkeletons: ["100px", "70px", "130px", "90px", "100px"],
    };
  },
};
</script>
<style scoped></style>
