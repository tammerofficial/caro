<template>
  <div class="refund-status-range mt-3" v-if="refund">
    <ul class="progressbar">
      <li class="active">
        <template v-if="status == 2">
          {{ $t("Pending") }}
        </template>
        <template v-else>
          {{ $t("Processing") }}
        </template>
      </li>
      <li :class="{ active: status == 5 || paymentStatus == 1 || status == 1 }">
        {{ $t("Product Received") }}
      </li>
      <li :class="{ active: status == 1 }">
        {{ $t("Return Approved") }}
      </li>
      <li :class="{ active: status == 1 && paymentStatus == 1 }">
        {{ $t("Refunded") }}
      </li>
    </ul>
  </div>
  <div class="order-status-range mt-3" v-else>
    <ul class="progressbar">
      <li class="active">
        <template v-if="status == 2">
          {{ $t("Pending") }}
        </template>
        <template v-else>
          {{ $t("Processing") }}
        </template>
      </li>
      <li :class="{ active: status == 3 || status == 1 }">
        {{ $t("Shipped") }}
      </li>
      <li :class="{ active: status == 1 }">{{ $t("Delivered") }}</li>
    </ul>
  </div>
</template>
<script>
export default {
  name: "OrderSteps",
  props: {
    status: {
      type: Number,
      default: 1,
    },
    refund: {
      type: Boolean,
      default: false,
      required: false,
    },
    paymentStatus: {
      type: Number,
      required: false,
    },
  },
};
</script>
<style lang="scss" scoped>
@import "../../assets/sass/00-abstracts/01-variables";

.progressbar {
  counter-reset: step;
}
.refund-status-range .progressbar li {
  list-style: none;
  display: inline-block;
  width: 25%;
  position: relative;
  text-align: center;
  cursor: pointer;
}
.order-status-range .progressbar li {
  list-style: none;
  display: inline-block;
  width: 30.33%;
  position: relative;
  text-align: center;
  cursor: pointer;
}
.progressbar li:before {
  content: counter(step);
  counter-increment: step;
  width: 30px;
  height: 30px;
  line-height: 30px;
  border: 1px solid #ddd;
  border-radius: 100%;
  display: block;
  text-align: center;
  margin: 0 auto 10px auto;
  background-color: #fff;
  z-index: 99;
  position: relative;
}
.progressbar li:after {
  content: "";
  position: absolute;
  width: 100%;
  height: 1px;
  background-color: #ddd;
  top: 15px;
  left: -50%;
  /* z-index: -1; */
}

.progressbar li:first-child:after {
  content: none;
}

.progressbar li.active {
  color: $c1;
}

.progressbar li.active:before {
  border-color: $c1;
}

.progressbar li.active + li:after {
  background-color: $c1;
}
</style>
