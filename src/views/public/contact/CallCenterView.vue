<script setup lang="ts">
import { useConfigStore } from '@/stores/config'
import { onMounted } from 'vue'

const configStore = useConfigStore()

interface ContactMethod {
    id: number
    type: 'phone' | 'whatsapp' | 'facebook' | 'email'
    label: string
    value: string
    description?: string
    icon: string
    color: string
    action?: string
}

interface Props {
    contacts?: ContactMethod[]
}

const props = withDefaults(defineProps<Props>(), {
    contacts: () => [
        {
            id: 1,
            type: 'phone',
            label: 'Numéro Vert',
            value: '7959',
            description: 'Appel gratuit disponible 24h/24 et 7j/7',
            icon: 'phone',
            color: 'green',
            action: 'tel:7959'
        },
        {
            id: 2,
            type: 'whatsapp',
            label: 'WhatsApp 1',
            value: '+229 96 00 00 00',
            description: 'Centre d\'appel disponible de 8h à 18h',
            icon: 'whatsapp',
            color: 'whatsapp',
            action: 'https://wa.me/22996000000'
        },
        {
            id: 3,
            type: 'whatsapp',
            label: 'WhatsApp 2',
            value: '+229 97 00 00 00',
            description: 'Support technique disponible de 8h à 18h',
            icon: 'whatsapp',
            color: 'whatsapp',
            action: 'https://wa.me/22997000000'
        },
        {
            id: 4,
            type: 'facebook',
            label: 'Facebook',
            value: 'CENA Bénin',
            description: 'Suivez-nous et contactez-nous via Messenger',
            icon: 'facebook',
            color: 'facebook',
            action: 'https://facebook.com/cenabenin'
        },
        {
            id: 5,
            type: 'email',
            label: 'Email',
            value: 'contact@cena.bj',
            description: 'Pour toute demande écrite',
            icon: 'email',
            color: 'blue',
            action: 'mailto:contact@cena.bj'
        }
    ]
})

// Fonction pour gérer le clic
const handleContact = (contact: string | undefined) => {
    if (contact) {
        window.open('tel:' + contact, '_blank', 'noopener,noreferrer')
    }
}

const handleWhatApp = (contact: string | undefined) => {
    if (contact) {
        window.open('https://wa.me/' + contact, '_blank', 'noopener,noreferrer')
    }
}

const handleFacebook = (contact: string | undefined) => {
    if (contact) {
        window.open(contact, '_blank', 'noopener,noreferrer')
    }
}

const handleMail = (contact: string | undefined) => {
    if (contact) {
        window.open('mailto:' + contact, '_blank', 'noopener,noreferrer')
    }
}

// Obtenir les classes de couleur
const getColorClasses = (color: string) => {
    const colorMap: Record<string, { bg: string, hover: string, icon: string, border: string }> = {
        green: {
            bg: 'bg-green-50',
            hover: 'hover:bg-green-100 hover:border-green-500',
            icon: 'text-green-600',
            border: 'border-green-200'
        },
        whatsapp: {
            bg: 'bg-green-50',
            hover: 'hover:bg-green-100 hover:border-green-500',
            icon: 'text-green-500',
            border: 'border-green-200'
        },
        facebook: {
            bg: 'bg-blue-50',
            hover: 'hover:bg-blue-100 hover:border-blue-500 border-blue-200',
            icon: 'text-blue-600',
            border: 'border-blue-200'
        },
        blue: {
            bg: 'bg-blue-50',
            hover: 'hover:bg-blue-100 hover:border-blue-500',
            icon: 'text-blue-600',
            border: 'border-blue-200'
        }
    }
    return colorMap[color] || colorMap.blue
}

// Obtenir le SVG de l'icône
const getIconSVG = (icon: string) => {
    const icons: Record<string, string> = {
        phone: 'M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z',
        whatsapp: 'M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z',
        facebook: 'M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z',
        email: 'M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z'
    }
    return icons[icon] || icons.phone
}

// Vérifier si c'est un path complet (WhatsApp, Facebook)
const isFullPath = (icon: string) => {
    return icon === 'whatsapp' || icon === 'facebook'
}

onMounted(async () => {
    await configStore.listConfigs()
})

</script>

<template>
    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100">
        <div class="container mx-auto px-4 py-12">
            <!-- En-tête -->
            <div class="text-center mb-12">
                <div
                    class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-green-900 to-green-700 rounded-full mb-6 shadow-lg">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                    </svg>
                </div>
                <h1 class="text-4xl font-bold text-green-900 mb-4">
                    CENTRE D'APPEL CENA
                </h1>
                <p class="text-gray-600 text-lg max-w-2xl mx-auto">
                    Contactez-nous pour toutes vos questions et préoccupations. Notre équipe est à votre écoute.
                </p>
            </div>

            <!-- Carte d'information principale -->
            <div
                class="max-w-4xl mx-auto mb-12 bg-gradient-to-r from-green-900 to-green-700 rounded-2xl shadow-2xl p-8 text-white">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-12 h-12 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold">Besoin d'aide ?</h2>
                </div>
                <p class="text-blue-100 leading-relaxed">
                    Notre centre d'appel est à votre disposition pour répondre à toutes vos questions concernant la
                    CENA,
                    les processus électoraux, les inscriptions sur les listes électorales et bien plus encore.
                    N'hésitez pas à nous contacter par les canaux ci-dessous.
                </p>
            </div>

            <!-- Méthodes de contact -->
            <div class="max-w-4xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-6">
                <article @click="handleContact(configStore.getConfig('freephone_cena')?.value)"
                    class="bg-white rounded-xl shadow-md overflow-hidden cursor-pointer transform transition-all duration-300 hover:-translate-y-1 hover:shadow-xl border-2 hover:bg-green-100 hover:border-green-500 border-green-200">
                    <div class="p-6">
                        <!-- En-tête avec icône -->
                        <div class="flex items-start gap-4 mb-4">
                            <div
                                class="w-16 h-16 rounded-xl flex items-center justify-center flex-shrink-0 shadow-md bg-green-50">
                                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                            </div>

                            <div class="flex-1">
                                <h3 class="text-lg font-semibold text-gray-800 mb-1">
                                    Numéro Vert
                                </h3>
                                <p class="text-2xl font-bold text-blue-900">
                                    {{ configStore.getConfig('freephone_cena')?.value }}
                                </p>
                            </div>

                            <!-- Icône d'action -->
                            <div
                                class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center group-hover:bg-green-600 transition-colors">
                                <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7" />
                                </svg>
                            </div>
                        </div>

                        <!-- Description -->
                        <p class="text-gray-600 text-sm">
                            Appel gratuit disponible 24h/24 et 7j/7
                        </p>
                    </div>
                </article>

                <article @click="handleWhatApp(configStore.getConfig('whatsApp_cena_1')?.value)"
                    class="bg-white rounded-xl shadow-md overflow-hidden cursor-pointer transform transition-all duration-300 hover:-translate-y-1 hover:shadow-xl border-2 hover:bg-green-100 hover:border-green-500 border-green-200">
                    <div class="p-6">
                        <!-- En-tête avec icône -->
                        <div class="flex items-start gap-4 mb-4">
                            <div
                                class="w-16 h-16 rounded-xl flex items-center justify-center flex-shrink-0 shadow-md bg-green-50">

                                <svg class="w-8 h-8 text-green-500" viewBox="0 0 24 24" fill="currentColor">
                                    <path
                                        d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z" />
                                </svg>
                            </div>

                            <div class="flex-1">
                                <h3 class="text-lg font-semibold text-gray-800 mb-1">
                                    WhatsApp 1
                                </h3>
                                <p class="text-2xl font-bold text-blue-900">
                                    {{ configStore.getConfig('whatsApp_cena_1')?.value }}
                                </p>
                            </div>

                            <!-- Icône d'action -->
                            <div
                                class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center group-hover:bg-green-600 transition-colors">
                                <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7" />
                                </svg>
                            </div>
                        </div>

                        <!-- Description -->
                        <p class="text-gray-600 text-sm">
                            Centre d'appel disponible de 8h à 18h </p>
                    </div>
                </article>

                <article @click="handleWhatApp(configStore.getConfig('whatsApp_cena_2')?.value)"
                    class="bg-white rounded-xl shadow-md overflow-hidden cursor-pointer transform transition-all duration-300 hover:-translate-y-1 hover:shadow-xl border-2 hover:bg-green-100 hover:border-green-500 border-green-200">
                    <div class="p-6">
                        <!-- En-tête avec icône -->
                        <div class="flex items-start gap-4 mb-4">
                            <div
                                class="w-16 h-16 rounded-xl flex items-center justify-center flex-shrink-0 shadow-md bg-green-50">

                                <svg class="w-8 h-8 text-green-500" viewBox="0 0 24 24" fill="currentColor">
                                    <path
                                        d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z" />
                                </svg>
                            </div>

                            <div class="flex-1">
                                <h3 class="text-lg font-semibold text-gray-800 mb-1">
                                    WhatsApp 2
                                </h3>
                                <p class="text-2xl font-bold text-blue-900">
                                    {{ configStore.getConfig('whatsApp_cena_2')?.value }}
                                </p>
                            </div>

                            <!-- Icône d'action -->
                            <div
                                class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center group-hover:bg-green-600 transition-colors">
                                <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7" />
                                </svg>
                            </div>
                        </div>

                        <!-- Description -->
                        <p class="text-gray-600 text-sm">
                            Support technique disponible de 8h à 18h </p>
                    </div>
                </article>

                <article @click="handleFacebook(configStore.getConfig('facebook_cena')?.value)"
                    class="bg-white rounded-xl shadow-md overflow-hidden cursor-pointer transform transition-all duration-300 hover:-translate-y-1 hover:shadow-xl border-2 hover:bg-blue-100 hover:border-blue-500 border-blue-200">
                    <div class="p-6">
                        <!-- En-tête avec icône -->
                        <div class="flex items-start gap-4 mb-4">
                            <div
                                class="w-16 h-16 rounded-xl flex items-center justify-center flex-shrink-0 shadow-md bg-blue-50">

                                <svg class="w-8 h-8 text-blue-600" viewBox="0 0 24 24" fill="currentColor">
                                    <path
                                        d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                                </svg>
                            </div>

                            <div class="flex-1">
                                <h3 class="text-lg font-semibold text-gray-800 mb-1">
                                    Facebook
                                </h3>
                                <p class="text-2xl font-bold text-blue-900">
                                    CENA Bénin </p>
                            </div>

                            <!-- Icône d'action -->
                            <div
                                class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center group-hover:bg-green-600 transition-colors">
                                <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7" />
                                </svg>
                            </div>
                        </div>

                        <!-- Description -->
                        <p class="text-gray-600 text-sm">Suivez-nous et contactez-nous via Messenger</p>
                    </div>
                </article>

                <article @click="handleMail(configStore.getConfig('email_cena')?.value)"
                    class="bg-white rounded-xl shadow-md overflow-hidden cursor-pointer transform transition-all duration-300 hover:-translate-y-1 hover:shadow-xl border-2 hover:bg-blue-100 hover:border-blue-500 border-blue-200">
                    <div class="p-6">
                        <!-- En-tête avec icône -->
                        <div class="flex items-start gap-4 mb-4">
                            <div
                                class="w-16 h-16 rounded-xl flex items-center justify-center flex-shrink-0 shadow-md bg-blue-50">
                                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>

                            <div class="flex-1">
                                <h3 class="text-lg font-semibold text-gray-800 mb-1">
                                    Email
                                </h3>
                                <p class="text-2xl font-bold text-blue-900">
                                    {{ configStore.getConfig('email_cena')?.value }} </p>
                            </div>

                            <!-- Icône d'action -->
                            <div
                                class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center group-hover:bg-green-600 transition-colors">
                                <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7" />
                                </svg>
                            </div>
                        </div>

                        <!-- Description -->
                        <p class="text-gray-600 text-sm">Pour toute demande écrite</p>
                    </div>
                </article>
            </div>

            <!-- Horaires et informations supplémentaires -->
            <!-- <div class="max-w-4xl mx-auto mt-12 grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-xl shadow-md p-6 text-center">
          <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
          </div>
          <h3 class="font-bold text-gray-800 mb-2">Disponibilité</h3>
          <p class="text-gray-600 text-sm">24h/24, 7j/7</p>
        </div>

        <div class="bg-white rounded-xl shadow-md p-6 text-center">
          <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
            </svg>
          </div>
          <h3 class="font-bold text-gray-800 mb-2">Appel Gratuit</h3>
          <p class="text-gray-600 text-sm">Sans frais depuis le Bénin</p>
        </div>

        <div class="bg-white rounded-xl shadow-md p-6 text-center">
          <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z" />
            </svg>
          </div>
          <h3 class="font-bold text-gray-800 mb-2">Multilingue</h3>
          <p class="text-gray-600 text-sm">Français, Fon, Yoruba</p>
        </div>
      </div> -->
        </div>
    </div>
</template>