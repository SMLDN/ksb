<template>
  <sheet-editor>
    <template v-slot:action-button>
      <new-action-button />
    </template>
  </sheet-editor>
</template>

<script>
import SheetEditor from "~/components/sheet/SheetEditor";
import NewActionButton from "~/components/sheet/NewActionButton";

export default {
  middleware: "auth",
  components: {
    SheetEditor,
    NewActionButton
  }
};
</script>