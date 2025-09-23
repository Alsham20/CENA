<script setup lang="ts">
import { events } from '@/data';
import EventCard from '../cards/EventCard.vue'
import type { EventType } from '@/types/event';

</script>

<template>
  <div class="py-4 md:py-8 space-y-4 md:space-y-6 m-auto w-[90%]">
        <!-- Titre de la section -->
        <div class="mb-8 flex items-center w-full">
            <h2 class="text-[#0E6258] text-xl md:text-3xl xl:text-5xl font-extrabold">Événements à venir</h2>
            <div class="flex-1 border-t border-gray-400 ml-4"></div>
        </div>
    
    <!-- Grid d'événements (2 par ligne) -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
      <EventCard 
        v-for="event in events" 
        :key="event.id" 
        :event="event"
        @click="handleEventClick(event)"
      />
    </div>
  </div>
</template>

<script lang="ts">
export default {
  methods: {
    handleEventClick(event: EventType) {
      console.log('Événement cliqué:', event.title)
      // Ici vous pouvez ajouter la logique de navigation ou d'ouverture de modal
    }
  }
}
</script>