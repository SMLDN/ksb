import Vue from "vue";

/**
 * Thêm focus directive
 */
Vue.directive("focus", {
    inserted(el) {
        el.focus();
    }
});
