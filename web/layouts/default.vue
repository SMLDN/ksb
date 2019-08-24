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
a:hover {
  text-decoration: underline;
}
.label.is-danger {
  font-size: 1em;
  font-weight: 400;
  color: #ff3860;
  text-align: center;
}
@media screen and (min-width: 1216px) {
  .container {
    max-width: 1020px;
  }
}

@media screen and (max-width: 768px) {
  .hero .hero-body.container {
    margin: 0;
  }
}
</style>

