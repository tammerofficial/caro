<template>
  <div class="track-container">
    <div class="track" ref="_vpcTrack"></div>
    <div class="track-highlight" ref="trackHighlight"></div>
    <button class="track-btn track1" ref="track1"></button>
    <button class="track-btn track2" ref="track2"></button>
    <div class="range-value-wrap">
      <span class="range-value min">
        <the-currency :amount="minV"></the-currency>
      </span>
      -
      <span class="range-value max">
        <the-currency :amount="maxV"></the-currency>
      </span>
    </div>
  </div>
</template>

<script>
export default {
  name: "Range Slider",
  emits: ["changePriceRange"],
  props: {
    min: {
      type: Number,
      default: 0,
      required: false,
    },
    max: {
      type: Number,
      default: 5000,
      required: false,
    },
    minValue: {
      type: Number,
      default: 0,
      required: false,
    },
    maxValue: {
      type: Number,
      default: 4000,
      required: false,
    },
  },
  data() {
    return {
      minRange: this.min,
      maxRange: this.max,
      minV: this.minValue,
      maxV: this.maxValue,
      step: 5,
      totalSteps: 0,
      percentPerStep: 1,
      trackWidth: null,
      isDragging: false,
      pos: {
        curTrack: null,
      },
    };
  },
  methods: {
    moveTrack(track, ev) {
      let percentInPx = this.getPercentInPx();

      let trackX = Math.round(
        this.$refs._vpcTrack.getBoundingClientRect().left
      );
      let clientX = ev.clientX;
      let moveDiff = clientX - trackX;

      let moveInPct = moveDiff / percentInPx;

      if (moveInPct < 1 || moveInPct > 100) return;
      let value =
        Math.round(moveInPct / this.percentPerStep) * this.step + this.min;
      if (track === "track1") {
        if (value >= this.maxV - this.step) return;
        this.minV = value;
      }

      if (track === "track2") {
        if (value <= this.minV + this.step) return;
        this.maxV = value;
      }

      this.$refs[track].style.left = moveInPct + "%";
      this.setTrackHightlight();
    },
    mousedown(ev, track) {
      if (this.isDragging) return;
      this.isDragging = true;
      this.pos.curTrack = track;
    },

    touchstart(ev, track) {
      this.mousedown(ev, track);
    },

    mouseup(ev, track) {
      if (!this.isDragging) return;
      this.isDragging = false;
      let item = {
        min: this.minV,
        max: this.maxV,
      };
      this.$emit("changePriceRange", item);
    },

    touchend(ev, track) {
      this.mouseup(ev, track);
    },

    mousemove(ev, track) {
      if (!this.isDragging) return;
      this.moveTrack(track, ev);
    },

    touchmove(ev, track) {
      this.mousemove(ev.changedTouches[0], track);
    },

    valueToPercent(value) {
      return ((value - this.min) / this.step) * this.percentPerStep;
    },

    setTrackHightlight() {
      this.$refs.trackHighlight.style.left =
        this.valueToPercent(this.minV) + "%";
      this.$refs.trackHighlight.style.width =
        this.valueToPercent(this.maxV) - this.valueToPercent(this.minV) + "%";
    },

    getPercentInPx() {
      let trackWidth = this.$refs._vpcTrack.offsetWidth;
      let oneStepInPx = trackWidth / this.totalSteps;
      // 1 percent in px
      let percentInPx = oneStepInPx / this.percentPerStep;

      return percentInPx;
    },

    setClickMove(ev) {
      let track1Left = this.$refs.track1.getBoundingClientRect().left;
      let track2Left = this.$refs.track2.getBoundingClientRect().left;
      if (ev.clientX < track1Left) {
        this.moveTrack("track1", ev);
      } else if (ev.clientX - track1Left < track2Left - ev.clientX) {
        this.moveTrack("track1", ev);
      } else {
        this.moveTrack("track2", ev);
      }
    },
  },

  mounted() {
    // calc per step value
    this.totalSteps = (this.max - this.min) / this.step;

    // percent the track button to be moved on each step
    this.percentPerStep = 100 / this.totalSteps;

    // set track1 initial
    document.querySelector(".track1").style.left =
      this.valueToPercent(this.minV) + "%";
    // track2 initial position
    document.querySelector(".track2").style.left =
      this.valueToPercent(this.maxV) + "%";
    // set initial track highlight
    this.setTrackHightlight();

    var self = this;

    ["mouseup", "mousemove"].forEach((type) => {
      document.body.addEventListener(type, (ev) => {
        // ev.preventDefault();
        if (self.isDragging && self.pos.curTrack) {
          self[type](ev, self.pos.curTrack);
        }
      });
    });

    [
      "mousedown",
      "mouseup",
      "mousemove",
      "touchstart",
      "touchmove",
      "touchend",
    ].forEach((type) => {
      document.querySelector(".track1").addEventListener(type, (ev) => {
        ev.stopPropagation();
        self[type](ev, "track1");
      });

      document.querySelector(".track2").addEventListener(type, (ev) => {
        ev.stopPropagation();
        self[type](ev, "track2");
      });
    });

    // on track click
    // determine direction based on click proximity
    // determine percent to move based on track.clientX - click.clientX
    document.querySelector(".track").addEventListener("click", function (ev) {
      ev.stopPropagation();
      self.setClickMove(ev);
    });

    document
      .querySelector(".track-highlight")
      .addEventListener("click", function (ev) {
        ev.stopPropagation();
        self.setClickMove(ev);
      });
  },
};
</script>

<style lang="scss" scoped>
@import "../../assets/sass/00-abstracts/01-variables";
.range-value-wrap {
  position: relative;
  top: 14px;
}
.track-container {
  width: calc(100% - 16px);
  left: 8px;
  position: relative;
  cursor: pointer;
  height: 3px;
  margin: 12px 0 38px;
}

.track,
.track-highlight {
  display: block;
  position: absolute;
  width: 100%;
  height: 3px;
}

.track {
  background-color: #ddd;
}

.track-highlight {
  background-color: $c1;
  z-index: 2;
}

.track-btn {
  -webkit-appearance: none;
  -moz-appearance: none;
  appearance: none;
  outline: none;
  cursor: pointer;
  display: block;
  position: absolute;
  z-index: 2;
  width: 16px;
  height: 16px;
  border-radius: 50%;
  top: calc(-50% - 5px);
  margin-left: -8px;
  border: none;
  background-color: #fff;
  border: 2px solid $c1;
  -ms-touch-action: pan-x;
  touch-action: pan-x;
  transition: box-shadow 0.3s ease-out, background-color 0.3s ease,
    -webkit-transform 0.3s ease-out;
  transition: transform 0.3s ease-out, box-shadow 0.3s ease-out,
    background-color 0.3s ease;
  transition: transform 0.3s ease-out, box-shadow 0.3s ease-out,
    background-color 0.3s ease, -webkit-transform 0.3s ease-out;
  &:after {
    width: 4px;
    height: 4px;
    background-color: $c1;
    position: absolute;
    content: "";
    border-radius: 50%;
    left: 50%;
    top: 50%;
    transform: translate(-50%, -50%);
  }
}
</style>
