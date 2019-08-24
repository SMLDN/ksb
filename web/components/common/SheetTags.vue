<template>
  <div class="tags">
    <div
      v-for="(sheetTag, index) in sheetTagList"
      :key="index"
      class="tag is-light"
    >{{ sheetTag.tag.name }}</div>
  </div>
</template>>

<script>
export default {
  /**
   * Props
   */
  props: {
    sheetTagList: {
      type: Array,
      default() {
        return {};
      }
    }
  }
};
</script>