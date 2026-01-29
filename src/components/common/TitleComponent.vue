<template>
  <div class="relative w-full p-6 lg:p-16 page-title">
    <h1 class="text-white text-xl lg:text-4xl font-bold">
      {{ title }}
    </h1>
  </div>
</template>
<script lang="ts">
export default {
  name: 'TitleComponent',
  props: {
    title: {
      type: String,
      required: true,
    },
  },
}
</script>
<style>
.page-title {
  background: linear-gradient(86.33deg, #062e20 15.02%, #11845a 102.32%);
}
</style>
