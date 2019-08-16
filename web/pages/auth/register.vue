<template>
  <section class="hero">
    <div class="hero-body">
      <div class="container has-text-centered">
        <div class="column is-4 is-offset-4">
          <template v-if="status === '0'">
            <h1 class="title has-text-grey">Tạo tài khoản</h1>
            <div class="box">
              <figure class="avatar"></figure>
              <form action="#" method="post" @submit.prevent="submit">
                <div class="field">
                  <div class="control">
                    <label for="user-name" class="label">
                      Tên hiển thị
                      <br />(được phép sử dụng tiếng Việt có dấu và dấu cách)
                    </label>
                    <input
                      id="user-name"
                      v-model="form.userName"
                      v-focus
                      :class="{ 'is-danger': serverError.userName }"
                      autocomplete="off"
                      class="input is-medium"
                      type="text"
                      placeholder="Tên hiển thị"
                      title="Tên hiển thị (được phép sử dụng tiếng Việt có dấu và dấu cách)"
                    />
                    <p
                      v-if="serverError.userName"
                      class="help is-danger"
                    >{{ serverError.userName[0] }}</p>
                  </div>
                </div>
                <div class="field">
                  <div class="control">
                    <label for="password" class="label">Email</label>
                    <input
                      id="email"
                      v-model="form.email"
                      :class="{ 'is-danger': serverError.email }"
                      autocomplete="off"
                      class="input is-medium"
                      type="email"
                      placeholder="Email"
                      title="Email"
                    />
                    <p v-if="serverError.email" class="help is-danger">{{ serverError.email[0] }}</p>
                  </div>
                </div>
                <div class="field">
                  <div class="control">
                    <label for="password" class="label">Mật khẩu</label>
                    <input
                      id="password"
                      v-model="form.loginPassword"
                      :class="{ 'is-danger': serverError.password }"
                      class="input is-medium"
                      type="password"
                      placeholder="Mật khẩu"
                      title="Mật khẩu"
                    />
                    <p
                      v-if="serverError.password"
                      class="help is-danger"
                    >{{ serverError.password[0] }}</p>
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
   * Method
   */
  methods: {
    async submit() {
      try {
        await this.$axios.$post("/auth/register", this.form);
        this.status = "1";
      } catch (e) {
        this.resetForm();
      }
    },

    /**
     * Clear Form khi có lỗi phát sinh
     */
    resetForm() {
      this.form.loginPassword = "";
    }
  }
};
</script>
