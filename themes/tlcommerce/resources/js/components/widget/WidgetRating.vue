<template>
  <!-- Widget -->
  <div class="widget widget-style-1 rating_widget mb-4">
    <h5>
      <span>{{ $t("Rating") }}</span>
      <span
        @click="showRatingWidget = !showRatingWidget"
        class="widget-collapse-toggle"
        ><span class="material-icons">
          {{ showRatingWidget ? "expand_less" : "expand_more" }}
        </span></span
      >
    </h5>
    <ul class="list-unstyled mb-0" v-if="showRatingWidget">
      <li>
        <input
          type="radio"
          name="rating_group"
          id="fiveStar"
          :checked="selectedItem == 5"
          @change="filter(5)"
        />
        <label for="fiveStar">
          <span v-for="i in 5" :key="i" class="material-icons"> star </span>
        </label>
      </li>
      <li>
        <input
          type="radio"
          name="rating_group"
          id="fourStar"
          :checked="selectedItem === 4"
          @change="filter(4)"
        />
        <label for="fourStar">
          <span
            v-for="i in 5"
            :key="i"
            class="material-icons"
            :class="{ disable: i === 5 || i === 5 }"
          >
            star
          </span>
        </label>
      </li>
      <li>
        <input
          type="radio"
          name="rating_group"
          id="threeStar"
          :checked="selectedItem === 3"
          @change="filter(3)"
        />
        <label for="threeStar">
          <span
            v-for="i in 5"
            :key="i"
            class="material-icons"
            :class="{ disable: i === 5 || i === 4 }"
          >
            star
          </span>
        </label>
      </li>
      <li>
        <input
          type="radio"
          name="rating_group"
          id="twoStar"
          :checked="selectedItem === 2"
          @change="filter(2)"
        />
        <label for="twoStar">
          <span
            v-for="i in 5"
            :key="i"
            class="material-icons"
            :class="{ disable: i === 5 || i === 4 || i === 3 }"
          >
            star
          </span>
        </label>
      </li>
      <li>
        <input
          type="radio"
          name="rating_group"
          id="oneStar"
          :checked="selectedItem === 1"
          @change="filter(1)"
        />
        <label for="oneStar">
          <span
            v-for="i in 5"
            :key="i"
            class="material-icons"
            :class="{ disable: i === 5 || i === 4 || i === 3 || i === 2 }"
          >
            star
          </span>
        </label>
      </li>
    </ul>
  </div>
  <!-- Widget -->
</template>

<script>
export default {
  emits: ["filter"],
  data() {
    return {
      showRatingWidget: true,
    };
  },
  props: {
    selectedItem: {
      type: String,
      required: false,
    },
  },
  methods: {
    filter(item) {
      this.$emit("filter", item);
    },
  },
};
</script>
