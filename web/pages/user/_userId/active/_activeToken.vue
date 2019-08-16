<template>
  <section class="hero">
    <div class="hero-body">
      <div class="container has-text-centered">
        <div class="column is-4 is-offset-4">
          <template v-if="success === '1'">
            <article class="message is-medium is-warning">
              <div class="message-header">Kích hoạt tài khoản thành công!</div>
              <div class="message-body">Hãy đăng nhập để tham gia viết bài.</div>
            </article>
            <p class="has-text-grey">
              <nuxt-link :to="{ name:'auth-login' }">Đăng nhập</nuxt-link>
            </p>
          </template>
          <template v-else-if="success === '-1'">
            <article class="message is-medium is-danger">
              <div class="message-header">Có lỗi xảy ra!</div>
              <div
                class="message-body"
              >Link kích hoạt đã hết thời gian hiệu lực hoặc tài khoản này đã được kích hoạt.</div>
            </article>
            <p class="has-text-grey">
              <nuxt-link :to="{ name:'index' }">Trang chủ ></nuxt-link>
            </p>
          </template>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
import * as MathUtil from "~/util/MathUtil.js";

export default {
  /**
   * Validate
   */
  validate({ params }) {
    const parentPattern = /^[0-9a-zA-Z]+$/;
    const childPattern = /^[0-9a-z]+$/;
    return (
      params.userId &&
      params.activeToken &&
      parentPattern.test(params.userId) &&
      childPattern.test(params.activeToken)
    );
  },

  /**
   * Data
   */
  data() {
    return {
      userId: this.$route.params.userId,
      activeToken: this.$route.params.activeToken,
      success: "0"
    };
  },

  /**
   * AsyncData
   */
  async asyncData({ app, params }) {
    const userId = params.userId;
    const activeToken = params.activeToken;
    try {
      await app.$axios.$get(
        `/user/${MathUtil.toBase10(userId)}/active/${activeToken}`
      );
      return { success: "1" };
    } catch (e) {
      return { success: "-1" };
    }
  }
};
</script>