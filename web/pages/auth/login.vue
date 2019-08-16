<template>
  <section class="hero">
    <div class="hero-body">
      <div class="container has-text-centered">
        <div class="column is-4 is-offset-4">
          <h1 class="title has-text-grey">Đăng nhập</h1>
          <div class="box">
            <form action="#" method="post" @submit.prevent="submit">
              <div class="field">
                <div class="control">
                  <label for="email" class="label">Email</label>
                  <input
                    id="email"
                    v-model="form.email"
                    v-focus
                    :class="{ 'is-danger': errorMsg }"
                    class="input is-medium"
                    type="email"
                    placeholder="Email"
                  />
                </div>
              </div>
              <div class="field">
                <div class="control">
                  <label for="email" class="label">Mật khẩu</label>
                  <input
                    id="password"
                    v-model="form.loginPassword"
                    :class="{ 'is-danger': errorMsg}"
                    class="input is-medium"
                    type="password"
                    placeholder="Mật khẩu"
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
              <button class="button is-block is-warning is-medium is-fullwidth">Đăng nhập</button>
            </form>
          </div>
          <p class="has-text-grey">
            <nuxt-link :to=" { name: 'auth-register' } ">Tạo tài khoản</nuxt-link>
          </p>
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
    /**
     * Submit
     */
    async submit() {
      try {
        console.log(this.$auth);
        await this.$auth.login({
          data: this.form
        });
        this.$router.push({
          path: this.$route.query.redirect || "/"
        });
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