<template>
  <sheet-editor>
    <template v-slot:action-button>
      <div class="tile is-parent is-vertical">
        <div class="tile is-child">
          <button class="button is-warning is-medium" @click="postSheet">Đăng bài</button>
        </div>
      </div>
    </template>
  </sheet-editor>
</template>

<script>
import { mapGetters } from "vuex";
import SheetEditor from "~/components/sheet/SheetEditor";

export default {
  middleware: "auth",
  components: {
    SheetEditor
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
    }
  }
};
</script>