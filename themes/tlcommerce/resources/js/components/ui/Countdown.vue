<template>
  <ul
    class="nav"
    :class="
      styleTwo
        ? 'countdown--two'
        : styleThree
        ? 'countdown--three'
        : 'countdown'
    "
    :style="styleObject"
  >
    <li>
      <h5 class="digit">{{ days }}</h5>
      <h6 class="text">
        <template v-if="!styleTwo">
          {{ days > 1 ? $t("days") : $t("day") }}</template
        >
        <template v-else> {{ $t("Day") }} </template>
      </h6>
    </li>
    <li>
      <h5 class="digit">{{ hours }}</h5>
      <h6 class="text">
        <template v-if="!styleTwo">
          {{ hours > 1 ? $t("hours") : $t("hour") }}</template
        >
        <template v-else> {{ $t("HRS") }} </template>
      </h6>
    </li>
    <li>
      <h5 class="digit">{{ minutes }}</h5>
      <h6 class="text">
        <template v-if="!styleTwo">
          {{ minutes > 1 ? $t("minutes") : $t("minute") }}
        </template>
        <template v-else> {{ $t("MIN") }} </template>
      </h6>
    </li>
    <li>
      <h5 class="digit">{{ seconds }}</h5>
      <h6 class="text">
        <template v-if="!styleTwo">
          {{ seconds > 1 ? $t("seconds") : $t("second") }}
        </template>
        <template v-else> {{ $t("SEC") }} </template>
      </h6>
    </li>
  </ul>
</template>

<script>
let interval = null;

export default {
  name: "Countdown",
  props: {
    deadline: {
      type: String,
      default: "",
      required: false,
    },
    titleColor: {
      type: String,
      default: "",
      required: false,
    },
    end: {
      type: String,
      default: "",
      required: false,
    },
    stop: {
      type: Boolean,
      required: false,
    },
    styleTwo: {
      type: Boolean,
      required: false,
    },
    styleThree: {
      type: Boolean,
      required: false,
    },
  },
  data() {
    return {
      now: Math.trunc(new Date().getTime() / 1000),
      date: null,
      diff: 0,
    };
  },
  computed: {
    styleObject() {
      return {
        "--digit-color": this.titleColor,
      };
    },
    seconds() {
      let second = Math.trunc(this.diff) % 60;
      if (second.toString().length <= 1) {
        return "0" + second.toString();
      }
      return second.toString();
    },

    minutes() {
      let minute = Math.trunc(this.diff / 60) % 60;
      if (minute.toString().length <= 1) {
        return "0" + minute.toString();
      }
      return minute.toString();
    },

    hours() {
      let hour = Math.trunc(this.diff / 60 / 60) % 24;
      if (hour.toString().length <= 1) {
        return "0" + hour.toString();
      }
      return hour.toString();
    },

    days() {
      let day = Math.trunc(this.diff / 60 / 60 / 24);
      if (day.toString().length <= 1) {
        return "0" + day.toString();
      }
      return day.toString();
    },
  },
  watch: {
    now(value) {
      this.diff = this.date - this.now;
      if (this.diff <= 0 || this.stop) {
        this.diff = 0;
        // Remove interval
        clearInterval(interval);
      }
    },
  },
  created() {
    const endTime = this.deadline ? this.deadline : this.end;
    this.date = Math.trunc(Date.parse(endTime.replace(/-/g, "/")) / 1000);

    interval = setInterval(() => {
      this.now = Math.trunc(new Date().getTime() / 1000);
    }, 1000);
  },
  destroyed() {
    clearInterval(interval);
  },
};
</script>
<style lang="scss">
@import "../../assets/sass/00-abstracts/01-variables";
.countdown {
  li {
    &:not(:last-child) {
      margin-right: 12px;
      padding-right: 12px;
      position: relative;
      &:after {
        position: absolute;
        right: 0;
        top: 50%;
        transform: translateY(-50%);
        content: ":";
      }
    }
    .digit {
      color: var(--digit-color);
      margin-bottom: 5px;
    }
    .text {
      text-transform: capitalize;
      font-size: 12px;
      font-weight: $regular;
      margin-bottom: 0;
      color: var(--digit-color);
    }
  }
  &--two {
    li {
      width: 62px;
      height: 60px;
      text-transform: uppercase;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      background-color: $title-color-four;
      transition: 0.3s ease-in;
      &:not(:last-child) {
        margin-right: 10px;
      }
      h5 {
        font-size: 30px;
      }
      h6 {
        font-size: 16px;
      }
      h5,
      h6 {
        font-weight: $medium;
        margin-bottom: 0;
        color: var(--digit-color);
        line-height: 1;
        transition: color 0.3s ease-in;
      }
      &:hover {
        background-color: $c5;
        h5,
        h6 {
          color: var(--digit-color);
        }
      }
    }
  }
  &--three {
    li {
      &:not(:last-child) {
        margin-right: 32px;
        padding-right: 32px;
        position: relative;
        @media (max-width: 575px) {
          margin-right: 22px;
          padding-right: 22px;
        }
        &:after {
          position: absolute;
          right: 0;
          top: 50%;
          transform: translateY(-50%);
          content: ":";
          font-family: $title-font;
          font-weight: $medium;
          font-size: 30px;
          color: var(--digit-color);
        }
      }
      .digit {
        color: var(--digit-color);
        font-size: 48px;
        margin-bottom: 9px;
        @media (max-width: 575px) {
          font-size: 30px;
        }
      }
      .text {
        text-transform: uppercase;
        font-size: 13px;
        font-weight: $medium;
        margin-bottom: 0;
        color: var(--digit-color);
      }
    }
  }
}
</style>
