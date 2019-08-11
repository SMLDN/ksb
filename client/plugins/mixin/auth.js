import Vue from "vue";
import { mapGetters } from "vuex";

/**
 * Thêm Auth Mixin
 */
const Auth = {
    install(Vue, options) {
        Vue.mixin({
            computed: {
                ...mapGetters({
                    authenticated: "auth/authenticated",
                    currentUser: "auth/user"
                })
            }
        });
    }
};

Vue.use(Auth);
