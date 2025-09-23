<script setup lang="ts">
import HeaderComponent from '@/components/partials/public/HeaderComponent.vue'
import FooterComponent from '@/components/partials/public/FooterComponent.vue'
import FooterNewsletterComponent from '@/components/partials/public/FooterNewsletterComponent.vue'
</script>

<template>
  <div>
    <HeaderComponent />
    <RouterView />
    <FooterNewsletterComponent />
    <FooterComponent />
  </div>
</template>
