<script setup lang="ts">
import EventCard from '../cards/EventCard.vue'
import { useEventStore } from '@/stores/event';
import { computed, onMounted } from 'vue';
import type { TEvent } from '@/requests/event';

const handleRead = (event: TEvent) => {
  console.log('Event à lire:', event.event_name)
}

const eventStore = useEventStore()
const events = computed(() => eventStore.events)



onMounted(() => {
  eventStore.listEvents({
    page: 1,
    pageSize: 20,
    orderBy: 'event_date',
    orderDirection: 'desc',
  })
})

</script>

<template>
  <div class="py-4 md:py-8 space-y-4 md:space-y-6 m-auto w-[90%]">
        <!-- Titre de la section -->
        <div class="mb-8 flex items-center w-full">
            <h2 class="text-[#0E6258] text-sm sm:text-xl md:text-3xl xl:text-5xl font-extrabold">Événements à venir</h2>
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
    handleEventClick(event: TEvent) {
      console.log('Événement cliqué:', event.event_name)
      // Ici vous pouvez ajouter la logique de navigation ou d'ouverture de modal
    }
  }
}
</script>