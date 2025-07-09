<template>
  <div class="order-status-details">
    <div v-for="(item, index) in items" :key="index">
      <div
        class="details-item mb-0 d-flex justify-content-between"
        v-if="max_view >= index + 1"
      >
        <div class="d-flex flex-wrap">
          <div class="time mr-10" v-if="item.date">{{ item.date }}</div>
          <div class="time mr-10" v-else>{{ item.created_at }}</div>
          <div class="text" v-html="item.message"></div>
        </div>
        <div v-if="index == 0 && items.length > 1">
          <a @click.prevent="viewMoreOrLess" class="expend-button">
            <span class="material-icons"> {{ expand_btn_content }} </span>
          </a>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  name: "OrderTracking",
  props: {
    items: {
      type: Array,
    },
  },
  data() {
    return {
      max_view: 1,
      view_more: false,
      clicked: false,
      expand_btn_content: "add",
    };
  },
  methods: {
    viewMoreOrLess() {
      this.clicked = true;
      this.view_more = !this.view_more;
      if (this.view_more) {
        this.expand_btn_content = "remove";
        this.max_view = this.items.length;
      } else {
        this.expand_btn_content = "add";
        this.max_view = 1;
      }
    },
  },
};
</script>
<style lang="scss" scoped>
@import "../../assets/sass/00-abstracts/01-variables";
.expend-button {
  cursor: pointer;
  font-weight: bold;
}
.time {
  min-width: fit-content;
}
.order-status-details {
  background: #f6f6f6;
  border: 1px solid #f2f2f2;
  padding: 15px;
}
.order-status-details .details-item {
  gap: 10px;
  margin-bottom: 10px;
}
.order-status-details p {
  margin: 0;
}

.order-status-details .view-btn {
  display: block;
  text-align: center;
  color: $c1;
  font-weight: 600;
  font-size: 11px;
  text-transform: uppercase;
}
@media (max-width: 575px) {
  .details-item {
    flex-direction: column;
  }
  .details-item .text {
    margin: 0;
  }
}
</style>
