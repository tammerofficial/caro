<template>
  <!-- Widget -->
  <div class="widget widget-style-1 price_widget">
    <h5>
      <span>{{ $t("Price") }}</span>
      <span
        @click="showPriceWidget = !showPriceWidget"
        class="widget-collapse-toggle"
        ><span class="material-icons"> expand_more </span></span
      >
    </h5>
    <ul class="list-unstyled mb-0">
      <li v-for="(item, index) in price_options" :key="index">
        <input
          type="radio"
          name="price_group"
          :id="index"
          :checked="item == selectedOption"
          @change="filter(item)"
        />
        <label :for="index">
          <the-currency :amount="item.min"></the-currency> -
          <the-currency :amount="item.max"></the-currency
        ></label>
      </li>
      <li for="p6">
        <input
          type="radio"
          class="d-none"
          name="price_group"
          id="p6"
          v-model="price_range"
        />
        <label for="p6" class="d-block"
          ><RangeSlider
            :min="0"
            :max="500000"
            :minValue="0"
            :maxValue="300000"
            @changePriceRange="changePriceRange"
        /></label>
      </li>
    </ul>
  </div>
  <!-- Widget -->
</template>

<script>
import RangeSlider from "@/components/ui/RangeSlider.vue";
export default {
  emits: ["filter"],
  components: {
    RangeSlider,
  },
  props: {
    selectedOption: {
      type: Object,
      required: false,
    },
  },
  data() {
    return {
      price_range: "",
      price_options: [
        {
          min: 0,
          max: 500,
        },
        {
          min: 500,
          max: 1000,
        },
        {
          min: 1000,
          max: 2000,
        },
        {
          min: 2000,
          max: 5000,
        },
        {
          min: 5000,
          max: 10000,
        },
      ],
    };
  },
  methods: {
    filter(item) {
      this.$emit("filter", item);
    },
    changePriceRange(e) {
      this.filter(e);
    },
  },
};
</script>
