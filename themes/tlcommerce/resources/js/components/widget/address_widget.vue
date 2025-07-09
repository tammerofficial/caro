<template>
  <!-- Widget Contact Info -->
  <div class="widget widget_contact_info">
    <template v-if="address_widget != null">
      <h3
        :class="
          this.footerStyle.custom_footer == 1
            ? 'custom-title-style'
            : 'widget-title'
        "
      >
        {{ address_widget.widget_title }}
      </h3>

      <template v-if="styleTwo">
        <p>
          {{ $t("If you have any question?") }} <br />
          {{ $t("Contact us:") }}
          {{ address_widget.mail }}
        </p>
        <p>
          {{ $t("Contact & Follow:") }} <br />
          {{ address_widget.mobile }}
        </p>
      </template>

      <template v-else>
        <ul>
          <li
            v-if="
              address_widget.address != null || address_widget.address != ''
            "
          >
            <base-icon-svg name="mapmarker" :width="15" :height="15" />
            {{ address_widget.address }}
          </li>
          <li v-if="address_widget.mail != null || address_widget.mail != ''">
            <base-icon-svg name="envelope" :width="15" :height="15" />
            {{ address_widget.mail }}
          </li>
          <li
            v-if="address_widget.mobile != null || address_widget.mobile != ''"
          >
            <base-icon-svg name="phone" :width="15" :height="15" />
            {{ address_widget.mobile }}
          </li>
        </ul>
      </template>
    </template>
  </div>
  <!-- End Widget Contact Info -->
</template>

<script>
export default {
  name: "address_widget",
  props: {
    address_widget: {
      type: Object,
      required: true,
    },
    styleTwo: {
      type: Boolean,
      default: false,
    },
    titleStyleThree: {
      type: Boolean,
      default: false,
    },
    footerStyle: {
      type: Object,
      required: false,
      default: () => {
        return {};
      },
    },
  },
};
</script>
