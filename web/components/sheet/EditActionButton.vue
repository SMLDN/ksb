<template>
  <div class="tile is-parent">
    <div class="tile is-child">
      <button class="button is-warning is-medium" @click="saveSheet">Lưu</button>
    </div>
    <div class="tile is-child">
      <attach-uploader @uploaded-attach="addAttachStr" />
    </div>
  </div>
</template>>

<script>
import { mapGetters, mapActions } from "vuex";
import AttachUploader from "~/components/common/AttachUploader";

export default {
  components: {
    AttachUploader
  },

  /**
   * Computed
   */
  computed: {
    ...mapGetters({
      sheet: "sheet/sheet"
    })
  },

  /**
   * Methods
   */
  methods: {
    ...mapActions({ appendContent: "sheet/appendContent" }),
    async saveSheet() {
      try {
        await this.$axios.$put("sheet/modify/" + this.sheet.slug, {
          title: this.sheet.title,
          tags: this.sheet.tagsText,
          content: this.sheet.content,
          slug: this.sheet.slug
        });
      } catch (e) {}
    },

    addAttachStr(data) {
      const str = `![${data.attachName}](http://localhost:8080/api/sheet-attach/get/${data.id})`;
      this.appendContent(str);
    }
  }
};
</script>>