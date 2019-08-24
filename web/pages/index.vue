<template>
  <section class="hero">
    <div class="hero-body">
      <div class="container">
        <div class="tile is-ancestor is-vertical">
          <div
            v-for="(sheet, index) in latestList"
            :key="index"
            class="sheet-item tile is-parent is-vertical box"
          >
            <nuxt-link
              :to="{ name:'user-userId-sheet-slug', params: {userId: basedUserId(sheet.user.id), slug: sheet.slug} }"
              class="sheet-title tile is-child"
            >{{ sheet.title }}</nuxt-link>
            <div class="sheet-meta has-text-grey tile is-child">
              bởi
              <nuxt-link
                :to="{ name: 'user-userId', params: {userId: basedUserId(sheet.user.id)} }"
                class="user-link has-text-grey"
              >{{ sheet.user.userName }}</nuxt-link>
              vào lúc {{ sheet.createdAt }}
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
import MathUtil from "~/util/MathUtil.js";

export default {
  /**
   * Data
   */
  data() {
    return {
      latestList: []
    };
  },

  /**
   * AsyncData
   */
  async asyncData({ app }) {
    try {
      const result = await app.$axios.$get("/sheet/latest");
      return {
        latestList: result.sheetList
      };
    } catch (e) {}
  },

  /**
   * Method
   */
  methods: {
    basedUserId(userId) {
      return MathUtil.toBase(userId);
    }
  }
};
</script>

<style>
.sheet-item .sheet-title {
  font-size: 1.5rem;
}

.sheet-item .sheet-meta {
  font-size: 0.9rem;
}
</style>
