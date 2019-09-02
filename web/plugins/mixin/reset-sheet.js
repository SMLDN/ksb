import Vue from "vue";

/**
 * Thêm ResetSheet Mixin
 */
const ResetSheet = {
  install(Vue, options) {
    Vue.mixin({
      beforeRouteLeave(to, from, next) {
        this.$store.dispatch("sheet/resetSheet");
        next();
      }
    });
  }
};

Vue.use(ResetSheet);
