<template>
  <div class="tile is-parent">
    <div class="tile is-child">
      <button class="button is-warning is-medium" @click="postSheet">Đăng bài</button>
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
    async postSheet() {
      try {
        const { sheet } = await this.$axios.$post("sheet/create", {
          title: this.sheet.title,
          tags: this.sheet.tagsText,
          content: this.sheet.content
        });
        this.$router.push({
          path: `/sheet/edit/${sheet.slug}`
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