<template>
    <div class="bg-[#0E6258] text-white py-6 lg:py-12 px-4 shadow-3xl">
      <div class="container mx-auto max-w-md text-center">
        <!-- Titre principal -->
        <h2 class="text-2xl lg:text-5xl font-semibold mb-8">
          {{ title }}
        </h2>
  
        <!-- Icône téléphone -->
        <div class="mb-8">
          <div class="inline-flex items-center justify-center w-20 h-20 xl:w-24 xl:h-24 bg-white rounded-full shadow-lg">
            <svg class="w-10 h-10 xl:w-12 xl:h-12 text-gray-700" fill="currentColor" viewBox="0 0 24 24">
              <path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/>
            </svg>
          </div>
        </div>
  
        <!-- Texte descriptif -->
        <div class="mb-8">
          <p class="xl:text-2xl font-normal mb-2">
            {{ subtitle }}
          </p>
          <p class="xl:text-2xl  font-normal">
            {{ description }}
          </p>
        </div>
  
        <!-- Numéro de téléphone -->
        <div class="mb-8">
          <a 
            :href="`tel:${phoneNumber.replace(/\s/g, '')}`"
            class="text-xl xl:text-3xl font-normal hover:text-orange-100 transition-colors duration-300 tracking-wider"
          >
            {{ phoneNumber }}
          </a>
        </div>
  
        <!-- Bouton optionnel (peut être activé) -->
        <!-- <div v-if="showCallButton" class="mt-8">
          <button 
            @click="makeCall"
            class="bg-white text-orange-500 px-8 py-3 rounded-full font-semibold hover:bg-orange-50 transition-colors duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1"
          >
            Appeler maintenant
          </button>
        </div> -->
      </div>
    </div>
  </template>
  
  <script setup lang="ts">
  import { ref, reactive } from 'vue'
  
  // Props avec valeurs par défaut
  const props = defineProps({
    title: {
      type: String,
      default: 'Call Center'
    },
    subtitle: {
      type: String,
      default: 'Une requête ?'
    },
    description: {
      type: String,
      default: 'Contactez notre centre d\'appel'
    },
    phoneNumber: {
      type: String,
      default: '27 22 59 99 74'
    },
    showCallButton: {
      type: Boolean,
      default: false
    }
  })
  
  // Fonction pour déclencher l'appel
  const makeCall = () => {
    const cleanPhone = props.phoneNumber.replace(/\s/g, '')
    window.location.href = `tel:${cleanPhone}`
  }
  
  // Animation au survol (optionnelle)
  const isHovered = ref(false)
  </script>
  
  <style scoped>
  /* Animations personnalisées */
  .phone-icon {
    animation: pulse 2s infinite;
  }
  
  @keyframes pulse {
    0%, 100% {
      transform: scale(1);
    }
    50% {
      transform: scale(1.05);
    }
  }
  
  /* Responsive pour très petits écrans */
  @media (max-width: 480px) {
    .container {
      padding: 0 1rem;
    }
  }
  </style>