<template>
  <sheet-editor>
    <template v-slot:action-button>
      <edit-action-button />
    </template>
  </sheet-editor>
</template>

<script>
import { mapGetters } from "vuex";
import SheetEditor from "~/components/sheet/SheetEditor";
import EditActionButton from "~/components/sheet/EditActionButton";

export default {
  middleware: "auth",
  components: {
    SheetEditor,
    EditActionButton
  },

  /**
   * Validate
   */
  validate({ params }) {
    const pattern = /^[a-z0-9-]+-[0-9]{19}$/;
    return params.slug && pattern.test(params.slug);
  },

  /**
   * Computed
   */
  computed: {
    ...mapGetters({
      sheet: "sheet/sheet"
    })
  },

  /**
   * Fetch
   */
  async fetch({ app, store, params, redirect }) {
    const slug = params.slug;
    const userId = app.$auth.user.id;
    try {
      const result = await app.$axios.$get(`/user/${userId}/sheet/${slug}`);
      store.dispatch("sheet/setSheet", result.sheet);
    } catch (e) {
      redirect("/");
    }
  }
};
</script>
