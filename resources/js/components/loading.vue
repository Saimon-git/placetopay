<template>
  <div class="flex w-full p-8">
    <beat-loader :class="{'m-auto': center}" :loading="loading" :color="color"></beat-loader>
  </div>
</template>

<script>
import { BeatLoader } from "@saeris/vue-spinners";

export default {
  props: ["color", "loading", "center"],

  components: { BeatLoader }
};
</script>
