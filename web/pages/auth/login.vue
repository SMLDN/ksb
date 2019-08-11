<template>
    <section class="hero is-fullheight">
        <div class="hero-body">
            <div class="container has-text-centered">
                <div class="column is-4 is-offset-4">
                    <h3 class="title has-text-grey">Đăng Nhập</h3>
                    <p class="subtitle has-text-grey">Đăng nhập để tham gia Vọc Máy Tính.</p>
                    <div class="box">
                        <figure class="avatar"></figure>
                        <form action="post" method="post" @submit.prevent="submit">
                            <div class="field">
                                <div class="control">
                                    <input
                                        v-model="form.email"
                                        class="input is-large"
                                        type="email"
                                        placeholder="Email"
                                        autofocus
                                    />
                                </div>
                            </div>
                            <div class="field">
                                <div class="control">
                                    <input
                                        v-model="form.loginPassword"
                                        class="input is-large"
                                        type="password"
                                        placeholder="Mật Khẩu"
                                    />
                                </div>
                            </div>
                            <div class="field">
                                <div class="control">
                                    <div v-if="errorMsg" class="label is-danger">{{ errorMsg }}</div>
                                </div>
                            </div>
                            <!-- <div class="field">
                <label class="checkbox">
                  <input type="checkbox" />
                  Remember me
                </label>
                            </div>-->
                            <button
                                class="button is-block is-primary is-large is-fullwidth"
                            >Đăng nhập</button>
                        </form>
                    </div>
                    <!-- <p class="has-text-grey">
            <a href="../">Sign Up</a> &nbsp;·&nbsp;
            <a href="../">Forgot Password</a> &nbsp;·&nbsp;
            <a href="../">Need Help?</a>
                    </p>-->
                </div>
            </div>
        </div>
    </section>
</template>

<script>
export default {
    auth: false,
    middleware: "guest-permission",

    /**
     * Data
     */
    data() {
        return {
            form: {
                email: "",
                loginPassword: ""
            }
        };
    },

    /**
     * Computed
     */
    computed: {
        errorMsg() {
            if (this.serverError.email) {
                return this.serverError.email[0];
            }
            if (this.serverError.password) {
                return this.serverError.password[0];
            }
            return null;
        }
    },

    /**
     * Method
     */
    methods: {
        submit() {
            this.$auth.login({
                data: this.form
            });

            this.$router.push({
                path: this.$route.query.redirect || "/"
            });
        }
    }
};
</script>

<style>
.label.is-danger {
    font-size: 1em;
    font-weight: 400;
    color: #ff3860;
    text-align: center;
}
</style>