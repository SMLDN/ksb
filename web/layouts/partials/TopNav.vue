<template>
  <nav id="top-nav-bar" class="navbar is-warning" role="navigation" aria-label="main navigation">
    <div class="navbar-brand">
      <nuxt-link class="navbar-item" :to="{ name: 'index' }">
        <img src="https://bulma.io/images/bulma-logo.png" width="112" height="28" />
      </nuxt-link>

      <a
        role="button"
        class="navbar-burger burger"
        aria-label="menu"
        aria-expanded="false"
        data-target="navbarBasicExample"
      >
        <span aria-hidden="true"></span>
        <span aria-hidden="true"></span>
        <span aria-hidden="true"></span>
      </a>
    </div>

    <div class="navbar-menu">
      <div v-if="!authenticated" class="navbar-end">
        <div class="navbar-item">
          <div class="buttons">
            <nuxt-link :to="{ name: 'auth-register' }" class="button is-light">Tạo tài khoản</nuxt-link>
            <nuxt-link :to="{ name: 'auth-login' }" class="button is-warning">
              <strong>Đăng nhập</strong>
            </nuxt-link>
          </div>
        </div>
      </div>

      <div v-if="authenticated" class="navbar-end">
        <div class="navbar-item has-dropdown is-hoverable">
          <a class="navbar-link">{{ currentUser.userName }}</a>

          <div class="navbar-dropdown">
            <nuxt-link :to="{ name: 'sheet-new' }" class="navbar-item">Viết bài mới</nuxt-link>
            <a class="navbar-item">My page</a>
            <hr class="navbar-divider" />
            <a to="#" class="navbar-item" @click="logout">Logout</a>
          </div>
        </div>
      </div>
    </div>
  </nav>
</template>

<script>
export default {
  methods: {
    async logout() {
      try {
        await this.$auth.logout();
      } catch (e) {}
    }
  }
};
</script>