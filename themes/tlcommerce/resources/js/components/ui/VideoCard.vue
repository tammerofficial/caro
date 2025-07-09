<template>
  <div
    class="video-card overflow-hidden position-relative"
    :style="styleObject"
  >
    <FsLightbox :toggler="toggler" :sources="[src]" />
    <template v-for="(image, imageIndex) in items">
      <div v-if="thumb" :key="imageIndex" class="bg-overlay w-100 h-100">
        <img
          class="radius-10"
          :src="thumb"
          :alt="title ? title : 'Video Thumbnail'"
        />

        <div
          class="
            d-flex
            flex-column
            justify-content-center
            align-items-center
            position-absolute
            w-100
            h-100
            fixed-top
            text-white
          "
        >
          <button
            :class="
              styleTwo
                ? 'btn-video-play'
                : 'bg-transparent border-0 p-0 text-white'
            "
            @click="toggler = !toggler"
          >
            <base-icon-svg
              :name="styleTwo ? 'play_3' : play"
              :height="styleTwo ? 23 : 120"
              :width="styleTwo ? 28 : 120"
            />
          </button>
        </div>
      </div>

      <template v-else>
        <button :key="imageIndex" class="btn_play" @click="toggler = !toggler">
          <base-icon-svg name="play_2" :height="35" :width="40" />
        </button>
      </template>
    </template>
  </div>
</template>

<script>
import FsLightbox from "fslightbox-vue/v3";

export default {
  name: "VideoCard",
  components: {
    FsLightbox,
  },
  props: {
    thumb: {
      type: String,
      default: "",
    },
    src: {
      type: String,
      required: true,
    },
    title: {
      type: String,
      default: "Video Title",
    },
    styleTwo: {
      type: Boolean,
      default: false,
    },
    btnBorderColor: {
      type: String,
      required: false,
    },
    btnIconColor: {
      type: String,
      required: false,
    },
  },
  data() {
    return {
      items: [
        {
          title: this.title,
          thumb: this.thumb,
          src: this.src,
        },
      ],
      index: null,
      toggler: false,
    };
  },
  computed: {
    styleObject() {
      return {
        "--btn-border-color": this.btnBorderColor,
        "--btn-icon-color": this.btnIconColor,
      };
    },
  },
};
</script>

<style lang="scss" scoped>
.video-card {
  .bg-overlay {
    min-height: 500px;
  }
  img {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }
  .btn_play {
    color: var(--btn-icon-color) !important;
    border-color: var(--btn-border-color) !important;
  }
}
</style>
