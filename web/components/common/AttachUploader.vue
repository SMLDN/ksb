<template>
  <dropzone
    id="attach-uploader"
    ref="attachUploader"
    :options="options"
    :duplicate-check="true"
    @vdropzone-success="uploadedAttach"
  ></dropzone>
</template>

<script>
import Dropzone from "nuxt-dropzone";
export default {
  components: {
    Dropzone
  },

  /**
   * Data
   */
  data() {
    return {
      options: {
        url: this.getUrl(),
        previewTemplate: `
        <div class="dz-preview dz-file-preview">
          <div class="dz-details">
          </div>
          <div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress></span></div>
        </div>
        `,
        createImageThumbnails: false,
        paramName: "attachContent",
        dictDefaultMessage: "Tải lên",
        acceptedFiles: "image/*",
        headers: {
          Authorization: this.$auth.getToken("local")
        }
      }
    };
  },

  /**
   * Methods
   */
  methods: {
    uploadedAttach(file, response) {
      this.$emit("uploaded-attach", response);
    },
    getUrl() {
      return "http://localhost:8080/api/sheet-attach/create";
    }
  }
};
</script>

<style>
#attach-uploader {
  border: 1px solid #ccc;
  cursor: pointer;
  text-align: center;
  height: 100%;
}
</style>

