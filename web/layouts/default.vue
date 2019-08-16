<template>
  <div>
    <top-nav />
    <nuxt />
  </div>
</template>

<script>
import TopNav from "./partials/TopNav.vue";
export default {
  components: {
    TopNav
  }
};
</script>

<style >
html {
  overflow-y: auto;
}
.label.is-danger {
  font-size: 1em;
  font-weight: 400;
  color: #ff3860;
  text-align: center;
}
</style>

