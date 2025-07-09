<template>
  <!-- Header Top Bar -->
  <div class="custom-header-top-bar header-top-bar">
    <div class="custom-container2">
      <div class="row align-items-center">
        <div class="col-lg-6 col-md-6 col-sm-4 col-4">
          <div class="header-info-wrap">
            <ul class="list-unstyled header-info">
              <li>
                <div
                  class="langcurrency-wrap"
                  ref="dropdownMenu"
                  v-if="!dataLoading"
                >
                  <div
                    class="langcurrency"
                    @click.prevent="
                      showLanguageCurrency = !showLanguageCurrency
                    "
                  >
                    <div>
                      <span class="text-uppercase custom-menu">{{
                        $i18n.locale
                      }}</span>
                      <span v-if="selected_currency" class="custom-menu">{{
                        selected_currency.code
                      }}</span>
                    </div>
                    <span class="material-icons ms-1">expand_more</span>
                  </div>
                  <div
                    class="langcurrency-dropdown"
                    v-if="showLanguageCurrency"
                  >
                    <ul class="list-unstyled">
                      <li>
                        <span>{{ $t("Language") }}</span>
                        <select
                          class="theme-input-style"
                          v-model="selected_lang"
                        >
                          <option
                            v-for="(lang, index) in languages"
                            :key="index"
                            :value="lang.code"
                          >
                            {{ lang.title }}
                          </option>
                        </select>
                      </li>
                      <li>
                        <span>{{ $t("Currency") }}</span>
                        <select
                          class="theme-input-style"
                          v-model="selected_currency"
                        >
                          <option
                            v-for="(currency, index) in currencies"
                            :key="index"
                            :value="currency"
                          >
                            {{ currency.code }}
                          </option>
                        </select>
                      </li>
                      <li class="w-100">
                        <button
                          type="button"
                          class="btn btn_fill w-100 justify-content-center custom-lang-switch-btn"
                          @click.prevent="setCurrencyLanguage"
                        >
                          {{ $t("Save Changes") }}
                        </button>
                      </li>
                    </ul>
                  </div>
                </div>
                <div
                  class="langcurrency-wrap"
                  ref="dropdownMenu"
                  v-if="dataLoading"
                >
                  <div class="langcurrency">
                    <div>
                      <span class="mb-1">
                        <skeleton
                          height="8px"
                          width="30px"
                          border-radius="10px"
                        ></skeleton>
                      </span>
                      <span>
                        <skeleton
                          height="8px"
                          width="30px"
                          border-radius="10px"
                        ></skeleton>
                      </span>
                    </div>
                  </div>
                </div>
              </li>
              <!-- Menu -->
              <template v-if="dataLoading">
                <li class="desktop">
                  <skeleton
                    class="router-link-active router-link-exact-active"
                    height="12px"
                    border-radius="10px"
                    width="80px"
                  >
                  </skeleton>
                </li>
                <li class="desktop">
                  <skeleton
                    class="router-link-active router-link-exact-active"
                    height="12px"
                    border-radius="10px"
                    width="100px"
                  >
                  </skeleton>
                </li>
                <li class="desktop">
                  <skeleton
                    class="router-link-active router-link-exact-active"
                    height="12px"
                    border-radius="10px"
                    width="90px"
                  >
                  </skeleton>
                </li>
              </template>
              <template v-else>
                <template v-for="(item, index) in leftMenuItems">
                  <template v-if="item.submenu">
                    <menu-item
                      v-if="item.submenu && item.submenu.length < 1"
                      :key="`item-${index}`"
                      :item="item"
                      :header-menu-style="headerMenuStyle"
                    />

                    <menu-dropdown
                      v-else
                      :key="`group-${index}`"
                      :item="item"
                      :open-group="isGroupActive(item, $route.fullPath)"
                      :header-menu-style="headerMenuStyle"
                    />
                  </template>
                  <template v-else>
                    <menu-item
                      :key="`item-${index}`"
                      :item="item"
                      class="mobile-none"
                      :header-menu-style="headerMenuStyle"
                    />
                  </template>
                </template>
              </template>

              <!-- End Menu -->
            </ul>
          </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-8 col-8">
          <div class="header-info-wrap">
            <ul class="list-unstyled header-info justify-content-end">
              <!-- Right header Menus -->
              <template v-if="dataLoading" class="desktop">
                <li class="desktop">
                  <skeleton
                    class="router-link-active router-link-exact-active"
                    height="12px"
                    border-radius="10px"
                    width="80px"
                  >
                  </skeleton>
                </li>
                <li class="desktop">
                  <skeleton
                    class="router-link-active router-link-exact-active"
                    height="12px"
                    border-radius="10px"
                    width="100px"
                  >
                  </skeleton>
                </li>
              </template>
              <template v-else>
                <template
                  v-for="(item, index) in rightMenuItems"
                  class="d-none d-lg-block"
                >
                  <template v-if="item.submenu">
                    <menu-item
                      v-if="item.submenu && item.submenu.length < 1"
                      :key="`item-${index}`"
                      :item="item"
                      :header-menu-style="headerMenuStyle"
                    />

                    <menu-dropdown
                      v-else
                      :key="`group-${index}`"
                      :item="item"
                      :open-group="isGroupActive(item, $route.fullPath)"
                      :header-menu-style="headerMenuStyle"
                    />
                  </template>
                  <template v-else>
                    <menu-item
                      :key="`item-${index}`"
                      :item="item"
                      class="mobile-none"
                      :header-menu-style="headerMenuStyle"
                    />
                  </template>
                </template>
              </template>
              <!--Bell icon-->
              <template v-if="isCustomerLogin">
                <li ref="notificationDropdownMenu" v-if="!dataLoading">
                  <a
                    href="#"
                    class="btn-notification-bell border"
                    @click.prevent="showNotification = !showNotification"
                  >
                    <span class="material-icons"> notifications </span>
                    <span
                      class="count position-absolute d-flex align-items-center justify-content-center"
                      >{{ totalNotifications }}</span
                    >
                  </a>
                  <div class="notification-dropdown" v-if="showNotification">
                    <div
                      class="bg-light d-flex justify-content-between p-2 notification-header"
                    >
                      <h6 class="mb-0">
                        {{ $t("Notification") }}
                      </h6>
                      <a
                        href="#"
                        class="mb-0"
                        v-if="totalNotifications > 0"
                        @click.prevent="markAsReadAll"
                        >{{ $t("Mark all as read") }}</a
                      >
                    </div>
                    <ul
                      class="list-unstyled p-3 pt-0"
                      v-if="totalNotifications > 0"
                    >
                      <li
                        v-for="(notification, index) in notifications"
                        :key="index"
                      >
                        <a
                          href="#"
                          class="notification-item d-flex align-items-center"
                          @click.prevent="readNotification(notification)"
                        >
                          <div class="content">
                            <div class="mb-2">
                              <p class="time">
                                {{ notification.time }}
                              </p>
                            </div>
                            <div
                              class="main-text"
                              v-html="notification.message"
                            ></div>
                          </div>
                        </a>
                      </li>
                    </ul>
                    <ul class="list-unstyled p-3" v-else>
                      <li>
                        <p>
                          {{ $t("You have no unread notification") }}
                        </p>
                      </li>
                    </ul>
                  </div>
                </li>
                <li v-if="dataLoading">
                  <skeleton
                    width="30px"
                    height="30px"
                    border-radius="50%"
                  ></skeleton>
                </li>
              </template>
              <!--End Bell icon-->
              <!--My Account-->
              <li ref="dropdownMenu2" v-if="!dataLoading">
                <span
                  class="my-account-btn custom-menu"
                  @click.prevent="showMyAccount = !showMyAccount"
                >
                  {{ $t("My Account") }}
                  <span class="material-icons ms-1">expand_more</span>
                </span>
                <div class="my-account-dropdown" v-if="showMyAccount">
                  <ul class="list-unstyled" v-if="isCustomerLogin">
                    <li>
                      <router-link to="/dashboard" class="custom-menu">{{
                        $t("Dashboard")
                      }}</router-link>
                    </li>
                    <li>
                      <router-link
                        to="#"
                        @click.prevent="customerLogout()"
                        class="custom-menu"
                      >
                        {{ $t("Logout") }}
                      </router-link>
                    </li>
                  </ul>
                  <ul class="list-unstyled" v-else>
                    <li>
                      <router-link to="/login" class="custom-menu">{{
                        $t("Login")
                      }}</router-link>
                    </li>
                  </ul>
                </div>
              </li>
              <li v-if="dataLoading">
                <skeleton
                  width="70px"
                  height="13px"
                  border-radius="10px"
                ></skeleton>
              </li>
              <!--End My Account-->
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- End Header Top Bar -->
</template>
<script>
import { mapState } from "vuex";
import MenuItem from "../../components/menu/MenuItem.vue";
import MenuDropdown from "../../components/menu/MenuDropdown.vue";
import axios from "axios";
export default {
  name: "HeaderTop",
  components: {
    MenuItem,
    MenuDropdown,
  },
  emits: ["change-language-currency-country", "logout-customer"],
  props: {
    currencies: {
      type: Array,
      required: false,
      default: () => {
        return [];
      },
    },
    languages: {
      type: Array,
      required: false,
      default: () => {
        return [];
      },
    },
    leftMenuItems: {
      type: Array,
      required: false,
      default: () => {
        return [];
      },
    },
    rightMenuItems: {
      type: Array,
      required: false,
      default: () => {
        return [];
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
      selected_lang: localStorage.getItem("locale") || "en",
      selected_currency: JSON.parse(localStorage.getItem("currency")),
      showMyAccount: false,
      showNotification: false,
      showLanguageCurrency: false,
    };
  },
  computed: mapState({
    isCustomerLogin: (state) => state.isCustomerLogin,
    customerToken: (state) => state.customerToken,
    notifications: (state) => state.notifications,
    totalNotifications: (state) =>
      state.notifications.length ? state.notifications.length : 0,
    isGroupActive() {
      return (item, path) => {
        let openGroup = false;
        const func = (item) => {
          if (item.submenu) {
            item.submenu.forEach((item) => {
              if (path === item.url) {
                openGroup = true;
              } else if (item.submenu) {
                func(item);
              }
            });
          }
        };
        func(item, path);
        return openGroup;
      };
    },
  }),
  mounted() {
    document.addEventListener("click", this.close);
  },
  methods: {
    /**
     * Will read notification
     */
    readNotification(notification) {
      axios
        .post(
          "/api/v1/ecommerce-core/customer/mark-as-read-single-notification",
          {
            id: notification.id,
          },
          {
            headers: {
              Authorization: `Bearer ${this.customerToken}`,
            },
          }
        )
        .then((response) => {
          if (response.data.success) {
            if (notification.link != null) {
              window.location.href = notification.link;
            } else {
              this.$store.dispatch(
                "customerNotificationAction",
                response.data.unread_notification.data
              );
            }
          }
        })
        .catch((error) => {});
    },
    /**
     * Will mark as read all notification
     */
    markAsReadAll() {
      axios
        .get("/api/v1/ecommerce-core/customer/mark-as-read-all-notification", {
          headers: {
            Authorization: `Bearer ${this.customerToken}`,
          },
        })
        .then((response) => {
          if (response.data.success) {
            this.$store.dispatch("customerNotificationAction", []);
          }
        })
        .catch((error) => {});
    },
    /**
     * Change currency , Language and country
     */
    setCurrencyLanguage() {
      this.$emit(
        "change-language-currency",
        this.selected_lang,
        this.selected_currency
      );
    },
    /**
     * Will close dropdown area
     *
     * @param {*} e
     */
    close(e) {
      let el = this.$refs.dropdownMenu;
      let el2 = this.$refs.dropdownMenu2;
      let el3 = this.$refs.notificationDropdownMenu;
      let target = e.target;

      if (el !== target && !el.contains(target)) {
        this.showLanguageCurrency = false;
      }
      if (el2 !== target && !el2.contains(target)) {
        this.showMyAccount = false;
      }
      if (this.isCustomerLogin) {
        if (el3 !== target && !el3.contains(target)) {
          this.showNotification = false;
        }
      }
    },
    /**
     * Will logout customer
     *
     */
    customerLogout() {
      this.$emit("logout-customer");
    },
  },
};
</script>
<style scoped>
@media (max-width: 991px) {
  .mobile-none {
    display: none;
  }
}
</style>
