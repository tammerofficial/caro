<template>
  <div
    class="d-flex align-items-center flex-wrap"
    :class="{ 'mb--10': !single }"
  >
    <!-- Single Preview -->
    <template v-for="(file, index) in files">
      <div
        v-if="!remove_all_files && preview === 1"
        :key="`file-${index}`"
        class="
          single-preview-file
          d-flex
          align-items-center
          justify-content-center
          flex-column
          radius-8
        "
        :class="{
          image:
            detectFile(file) === 'jpg' ||
            detectFile(file) === 'JPG' ||
            detectFile(file) === 'png' ||
            detectFile(file) === 'jpeg',

          'mr-0': single,
          'mb-0': single,
        }"
      >
        <template
          v-if="
            file.name.includes('.JPG') ||
            file.name.includes('.jpg') ||
            file.name.includes('.png') ||
            file.name.includes('.jpeg')
          "
        >
          <img
            :src="createUrl(file)"
            :alt="file.name.replace(`.${detectFile(file)}`, '')"
          />
        </template>
        <template v-else>
          <i class="fa fa-file"></i>
          {{
            file.name.length > 10
              ? file.name.slice(0, 4) + "..." + detectFile(file)
              : file.name
          }}
        </template>

        <button
          title="Remove"
          class="btn_circle"
          @click.prevent="removeFile(index)"
        >
          <span class="material-icons">close</span>
        </button>
      </div>
    </template>
    <!-- End Single Preview -->

    <!-- Input Wrapper -->
    <template v-if="single === true">
      <div
        v-if="files.length === 0"
        class="
          file-input-wrapper
          d-flex
          align-items-center
          justify-content-center
          flex-column
          radius-8
        "
        :class="{
          'mb-0': single,
        }"
      >
        <span class="material-icons">add</span>
        <slot>{{ $t("Add Image") }}</slot>
        <input
          :id="id"
          type="file"
          title="Select File"
          :name="name"
          @change="handleFileInput"
        />
      </div>
    </template>

    <div
      v-else
      class="
        file-input-wrapper
        d-flex
        align-items-center
        justify-content-center
        flex-column
        radius-8
      "
    >
      <i class="fa fa-plus"></i>
      <slot>{{ $t("Add Image") }}</slot>
      <input
        :id="id"
        type="file"
        title="Select File"
        :name="name"
        multiple
        @change="handleFileInput"
      />
    </div>
    <!-- End Input Wrapper -->
  </div>
</template>

<script>
export default {
  props: {
    id: {
      type: [String, Number],
      required: true,
    },
    name: {
      type: String,
      required: true,
    },
    single: {
      type: Boolean,
      default: false,
    },
    preview: {
      type: [String, Number],
      required: false,
      default: 1,
    },
    remove_all_files: {
      type: Boolean,
      default: false,
    },
  },
  data() {
    return {
      files: [],
    };
  },
  methods: {
    createUrl(file) {
      return URL.createObjectURL(file);
    },

    handleFileInput(e) {
      if (this.remove_all_files) {
        this.files = [];
      }
      const files = e.target.files;

      if (!files) {
        return;
      }
      [...files].forEach((f) => {
        this.files.push(f);
        this.$emit("getFileInput", this.files);
      });
    },

    removeFile(fileKey) {
      this.files.splice(fileKey, 1);
      this.$emit("removeFile");
    },
    removeAllFiles() {
      this.files = [];
      this.$emit("removeAllFiles");
    },

    detectFile(file) {
      return file.name.split(".").pop();
    },
  },
};
</script>

