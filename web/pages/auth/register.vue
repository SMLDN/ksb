<template>
    <section class="hero">
        <div class="hero-body">
            <div class="container has-text-centered">
                <div class="column is-4 is-offset-4">
                    <template v-if="status === 'unfinish'">
                        <h1 class="title has-text-grey">Tạo tài khoản</h1>
                        <div class="box">
                            <figure class="avatar"></figure>
                            <form action="post" method="post" @submit.prevent="submit">
                                <div class="field">
                                    <div class="control">
                                        <input
                                            v-model="form.userName"
                                            v-focus
                                            class="input is-medium"
                                            type="text"
                                            placeholder="Tên hiển thị"
                                            title="Tên hiển thị (được phép sử dụng tiếng Việt có dấu và dấu cách)"
                                        />
                                    </div>
                                </div>
                                <div class="field">
                                    <div class="control">
                                        <input
                                            v-model="form.email"
                                            class="input is-medium"
                                            type="email"
                                            placeholder="Email"
                                            title="Email"
                                        />
                                    </div>
                                </div>
                                <div class="field">
                                    <div class="control">
                                        <input
                                            v-model="form.loginPassword"
                                            class="input is-medium"
                                            type="password"
                                            placeholder="Mật khẩu"
                                            title="Mật khẩu"
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
                                    class="button is-block is-warning is-medium is-fullwidth"
                                    title="Tạo tài khoản"
                                >Tạo tài khoản</button>
                            </form>
                        </div>
                        <p class="has-text-grey">
                            <nuxt-link :to="{ name:'index' }">Trang chủ ></nuxt-link>
                        </p>
                        <!-- <p class="has-text-grey">
            <a href="../">Sign Up</a> &nbsp;·&nbsp;
            <a href="../">Forgot Password</a> &nbsp;·&nbsp;
            <a href="../">Need Help?</a>
                        </p>-->
                    </template>
                    <template v-else-if=" status === '1'">
                        <article class="message is-medium is-warning">
                            <div class="message-header">Tạo tài khoản thành công!</div>
                            <div class="message-body">
                                Vui lòng kiểm tra hòm thư
                                <em>{{ form.email }}</em> để kích hoạt tài khoản.
                            </div>
                        </article>
                        <p class="has-text-grey">
                            <nuxt-link :to="{ name:'auth-login' }">Đăng nhập</nuxt-link>&nbsp;|&nbsp;
                            <nuxt-link :to="{ name:'index' }">Trang chủ ></nuxt-link>
                        </p>
                    </template>
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
                userName: "",
                loginPassword: ""
            },
            status: "0"
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
            if (this.serverError.userName) {
                return this.serverError.userName[0];
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
        async submit() {
            try {
                await this.$axios.$post("/auth/register", this.form);
                this.status = "1";
            } catch (e) {}
        }
    }
};
</script>
