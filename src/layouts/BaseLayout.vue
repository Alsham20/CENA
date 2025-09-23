<script lang="ts">
export default {
  watch: {
    $route(to) {
      document.title = to.meta.title || 'Commission Électorale Nationale Autonome'
    },
  },
}
</script>
<template>
  <router-view />
</template>

<style scoped></style>
