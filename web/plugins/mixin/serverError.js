import Vue from "vue";
import { mapGetters } from "vuex";

/**
 * Server Error
 */
const serverError = {
  install(Vue, options) {
    Vue.mixin({
      computed: {
        ...mapGetters({
          serverError: "serverError/errors"
        })
      }
    });
  }
};

Vue.use(serverError);
