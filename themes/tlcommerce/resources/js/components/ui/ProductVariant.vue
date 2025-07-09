<template>
  <component v-bind:is="tag">{{ formattedString }}</component>
</template>
<script>
import { mapState } from "vuex";
export default {
  name: "ProductVariant",
  props: {
    variant: {
      type: Number,
      required: false,
    },
    tag: {
      type: String,
      required: false,
      default: "span",
    },
  },
  computed: mapState({
    formattedString() {
      let variantArray = this.variant.split("/");
      let final_string = "";
      for (let i = 0; i < variantArray.length; i++) {
        let option_array = variantArray[i].split(":");
        let temp =
          option_array[0].charAt(0).toUpperCase() +
          option_array[0].slice(1) +
          ": " +
          option_array[1].charAt(0).toUpperCase() +
          option_array[1].slice(1);
        if (i == 0) {
          final_string = final_string.concat("", temp);
        } else {
          final_string = final_string.concat(" | ", temp);
        }
      }
      return final_string;
    },
  }),
};
</script>