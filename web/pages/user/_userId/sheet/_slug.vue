<template>
  <div class="hero">
    <div class="hero-body container content">
      <h1 class="title">{{ sheet.title }}</h1>
      <div class="level">
        <sheet-tags :sheet-tag-list="sheet.tags" class="level-left"></sheet-tags>
        <nuxt-link
          v-if="sheet.userId === currentUser.id"
          :to="{ name: 'sheet-edit-slug', params: {slug: sheet.slug } }"
          class="level-right"
        >Sửa bài</nuxt-link>
      </div>
      <div v-html="compiledMarkdown"></div>
    </div>
  </div>
</template>

<script>
import marked from "marked";
import SheetTags from "~/components/common/SheetTags";
import MathUtil from "~/util/MathUtil.js";

export default {
  components: {
    SheetTags
  },

  /**
   * Validate
   */
  validate({ params }) {
    const parentPattern = /^[0-9a-zA-Z]+$/;
    const childPattern = /^[a-z0-9-]+-[0-9]{19}$/;
    return (
      params.userId &&
      params.slug &&
      parentPattern.test(params.userId) &&
      childPattern.test(params.slug)
    );
  },

  /**
   * Head
   */
  head() {
    return {
      title: this.sheet.title + " - Vọc Máy Tính"
    };
  },

  /**
   * Data
   */
  data() {
    return {
      sheet: {}
    };
  },

  /**
   * Computed
   */
  computed: {
    compiledMarkdown() {
      return this.sheet.content ? marked(this.sheet.content) : "";
    }
  },

  /**
   * AsyncData
   */
  async asyncData({ app, params, error }) {
    const userId = params.userId;
    const slug = params.slug;
    try {
      const result = await app.$axios.$get(
        `/user/${MathUtil.toBase10(userId)}/sheet/${slug}`
      );
      return {
        sheet: result.sheet
      };
    } catch (e) {
      error(e);
    }
  }
};
</script>