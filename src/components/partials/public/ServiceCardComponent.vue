<!-- ServiceCard.vue -->
<template>
    <a :href="service.link" target="_blank" data-aos="flip-left"
     data-aos-easing="ease-out-cubic"
     data-aos-duration="2000"
        class="relative block rounded-sm overflow-hidden group transition-transform hover:scale-105 duration-700">
        <!-- Image de fond -->
        <img :src="service.backgroundImage" :alt="service.title" class="absolute inset-0 w-full h-full object-cover" />

        <!-- Overlay coloré -->
        <div class="absolute inset-0" :style="{ backgroundColor: service.overlayColor, opacity: 0.85 }"></div>

        <!-- Contenu -->
        <div class="relative h-full min-h-48  p-6 flex flex-row items-center">
            <!-- Logo (conditionnel) -->
            <div v-if="service.logo" class="basis-2/5">
                <img :src="service.logo" :alt="service.title + ' logo'" class="w-32 xl:w-40 h-auto" />
            </div>
            <div class="text-start basis-3/5">
                <!-- Titre -->
                <h3 class="text-white text-xl xl:text-3xl font-extrabold mb-2">
                    {{ service.title }}
                </h3>

                <!-- Description -->
                <p class="text-white/90 font-medium xl:text-lg">
                    {{ service.description }}
                </p>
            </div>
        </div>
    </a>
</template>

<script lang="ts">
export default {
    name: 'ServiceCard',
    props: {
        service: {
            type: Object,
            required: true,
            validator: (service: Object) => {
                return [
                    'title',
                    'description',
                    'backgroundImage',
                    'overlayColor',
                    'link'
                ].every(key => key in service)
            }
        }
    }
}
</script>