<template>
  <section id="main-hero" class="hero">
    <div id="editor" class="hero-body tile is-vertical is-ancestor">
      <div class="toolbox tile">
        <div class="tile is-parent is-8 is-vertical">
          <div class="tile is-child">
            <input
              :value="sheet.title"
              type="text"
              class="input is-medium"
              placeholder="Tiêu đề"
              @input="updateTitle"
            />
          </div>
          <div class="tile is-child">
            <input
              :value="sheet.tagsText"
              type="text"
              class="input is-small"
              placeholder="Tags"
              @input="updateTags"
            />
          </div>
        </div>
        <slot name="action-button"></slot>
      </div>
      <div id="sheet-body" class="tile is-parent">
        <div class="tile is-child is-6">
          <textarea
            id="sheet-content"
            :value="sheet.content"
            class="textarea has-fixed-size"
            placeholder="Nội dung bài viết..."
            @input="updateContent"
          ></textarea>
        </div>
        <div id="sheet-preview" class="content tile is-child" v-html="compiledMarkdown"></div>
      </div>
    </div>
  </section>
</template>

<script>
import { mapGetters } from "vuex";
import marked from "marked";

export default {
  /**
   * Computed
   */
  computed: {
    compiledMarkdown() {
      return this.sheet.content ? marked(this.sheet.content) : "";
    },
    ...mapGetters({
      sheet: "sheet/sheet"
    })
  },

  /**
   * Methods
   */
  methods: {
    updateTitle(e) {
      if (e) {
        this.$store.dispatch("sheet/setTitle", e.target.value);
      }
    },

    updateTags(e) {
      if (e) {
        this.$store.dispatch("sheet/setTagsText", e.target.value);
      }
    },

    updateContent(e) {
      if (e) {
        this.$store.dispatch("sheet/setContent", e.target.value);
      }
    }
  }
};
</script>

<style>
.notification {
  position: absolute;
  top: 3.2em;
  z-index: 10;
  margin: auto;
  width: 100%;
}
#main-hero {
  min-height: calc(100vh - 3.25rem);
}
#editor {
  margin-bottom: 0;
  padding-top: 1rem;
  padding-left: 0.5rem;
}
#editor .toolbox {
  max-height: 5.25rem;
}
#editor .toolbox .is-parent {
  padding-top: 0;
}
#editor .toolbox .is-child {
  padding-bottom: 0.5rem;
  padding-top: 0;
  margin-bottom: 0 !important;
}
#sheet-content {
  height: 100%;
}
#sheet-body {
  position: absolute;
  top: 8.25rem;
  height: calc(100% - 8.25rem);
  width: 100%;
  padding-right: 3px;
}
#sheet-body .tile.is-child {
  max-height: 100%;
}
#sheet-content {
  max-height: 100%;
  border: none;
  border-right: 1px #ccc solid;
  border-radius: 0;
  box-shadow: none;
}
#sheet-preview {
  overflow: auto;
  padding-left: 6px;
}
</style>