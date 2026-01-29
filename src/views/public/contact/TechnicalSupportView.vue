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

interface PlatformSupport {
    id: number
    name: string
    platform: string
    icon: string
    color: string
    contacts: ContactMethod[]
}

interface Props {
    platforms?: PlatformSupport[]
}

const props = withDefaults(defineProps<Props>(), {
    platforms: () => [
        {
            id: 1,
            name: 'E-Learning',
            platform: 'elearning.cena.bj',
            icon: 'graduation',
            color: 'green',
            contacts: [
                {
                    id: 1,
                    type: 'phone',
                    label: 'Numéro Vert',
                    value: '7960',
                    description: 'Support technique E-Learning',
                    icon: 'phone',
                    color: 'green',
                    action: 'tel:7960'
                },
                {
                    id: 2,
                    type: 'whatsapp',
                    label: 'WhatsApp',
                    value: '+229 96 11 11 11',
                    description: 'Assistance en ligne',
                    icon: 'whatsapp',
                    color: 'whatsapp',
                    action: 'https://wa.me/22996111111'
                }
            ]
        },
        {
            id: 2,
            name: 'E-Accréditation',
            platform: 'eaccreditation.cena.bj',
            icon: 'badge',
            color: 'yellow',
            contacts: [
                {
                    id: 3,
                    type: 'phone',
                    label: 'Numéro Vert',
                    value: '7961',
                    description: 'Support accréditation',
                    icon: 'phone',
                    color: 'green',
                    action: 'tel:7961'
                },
                {
                    id: 4,
                    type: 'whatsapp',
                    label: 'WhatsApp',
                    value: '+229 96 22 22 22',
                    description: 'Assistance accréditation',
                    icon: 'whatsapp',
                    color: 'whatsapp',
                    action: 'https://wa.me/22996222222'
                }
            ]
        },
        {
            id: 3,
            name: 'E-Recrutement',
            platform: 'erecrutement.cena.bj',
            icon: 'users',
            color: 'red',
            contacts: [
                {
                    id: 5,
                    type: 'phone',
                    label: 'Numéro Vert',
                    value: '7962',
                    description: 'Support recrutement',
                    icon: 'phone',
                    color: 'green',
                    action: 'tel:7962'
                },
                {
                    id: 6,
                    type: 'whatsapp',
                    label: 'WhatsApp',
                    value: '+229 96 33 33 33',
                    description: 'Assistance recrutement',
                    icon: 'whatsapp',
                    color: 'whatsapp',
                    action: 'https://wa.me/22996333333'
                }
            ]
        }
    ]
})

// Contacts généraux
const generalContacts: ContactMethod[] = [
    {
        id: 7,
        type: 'facebook',
        label: 'Facebook',
        value: 'CENA Bénin',
        description: 'Support via Messenger',
        icon: 'facebook',
        color: 'facebook',
        action: 'https://facebook.com/cenabenin'
    },
    {
        id: 8,
        type: 'email',
        label: 'Email',
        value: 'support@cena.bj',
        description: 'Assistance technique',
        icon: 'email',
        color: 'blue',
        action: 'mailto:support@cena.bj'
    }
]

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

// Obtenir les classes de couleur
const getColorClasses = (color: string) => {
    const colorMap: Record<string, { bg: string, badge: string, icon: string }> = {
        blue: { bg: 'bg-blue-50', badge: 'bg-blue-600', icon: 'text-blue-600' },
        green: { bg: 'bg-green-50', badge: 'bg-green-600', icon: 'text-green-600' },
        purple: { bg: 'bg-purple-50', badge: 'bg-purple-600', icon: 'text-purple-600' },
        yellow: { bg: 'bg-yellow-50', badge: 'bg-yellow-400', icon: 'text-yellow-400' },
        red: { bg: 'bg-red-50', badge: 'bg-red-600', icon: 'text-red-600' },
        whatsapp: { bg: 'bg-green-50', badge: 'bg-green-500', icon: 'text-green-500' },
        facebook: { bg: 'bg-blue-50', badge: 'bg-blue-600', icon: 'text-blue-600' }
    }
    return colorMap[color] || colorMap.blue
}

// Obtenir le SVG de l'icône
const getPlatformIcon = (icon: string) => {
    const icons: Record<string, string> = {
        graduation: 'M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222',
        badge: 'M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z',
        users: 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z'
    }
    return icons[icon] || icons.graduation
}

const getContactIcon = (icon: string) => {
    const icons: Record<string, { path: string, isFilled: boolean }> = {
        phone: {
            path: 'M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z',
            isFilled: false
        },
        whatsapp: {
            path: 'M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z',
            isFilled: true
        },
        facebook: {
            path: 'M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z',
            isFilled: true
        },
        email: {
            path: 'M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z',
            isFilled: false
        }
    }
    return icons[icon] || icons.phone
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
                    class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-green-700 to-green-900 rounded-full mb-6 shadow-lg">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
                <h1 class="text-4xl font-bold text-green-900 mb-4">
                    ASSISTANCE TECHNIQUE DES SERVICES EN LIGNE
                </h1>
                <p class="text-gray-600 text-lg max-w-2xl mx-auto">
                    Support technique dédié pour chacune de nos plateformes digitales
                </p>
            </div>

            <!-- Plateformes avec leurs contacts -->
            <div class="max-w-6xl mx-auto space-y-8 mb-12">
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                    <!-- En-tête de la plateforme -->
                    <div class="p-6 flex items-center gap-4 bg-green-50">
                        <div class="w-16 h-16 bg-white rounded-xl flex items-center justify-center shadow-md">
                            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h2 class="text-2xl font-bold text-gray-900 mb-1">
                                E-Learning
                            </h2>
                            <p class="text-gray-600 text-sm">
                                elearning.cena.bj
                            </p>
                        </div>
                        <span class="px-4 py-2 text-white text-sm font-semibold rounded-lg bg-green-600">
                            Support dédié
                        </span>
                    </div>

                    <!-- Contacts de la plateforme -->
                    <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div @click="handleContact(configStore.getConfig('freephone_e_learning')?.value)"
                            class="bg-gray-50 rounded-xl p-4 cursor-pointer hover:bg-gray-100 transition-all duration-200 border-2 border-transparent hover:border-green-500 group">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 rounded-lg flex items-center justify-center bg-green-50">
                                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                    </svg>
                                </div>

                                <div class="flex-1">
                                    <p class="text-sm text-gray-600">Numéro vert</p>
                                    <p class="font-bold text-gray-900 text-lg">{{
                                        configStore.getConfig('freephone_e_learning')?.value}}</p>
                                    <p class="text-xs text-gray-500">Support technique E-Learning</p>
                                </div>

                                <svg class="w-5 h-5 text-gray-400 group-hover:text-green-600 transition-colors"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7" />
                                </svg>
                            </div>
                        </div>
                        <div @click="handleWhatApp(configStore.getConfig('whatsApp_e_learning')?.value)"
                            class="bg-gray-50 rounded-xl p-4 cursor-pointer hover:bg-gray-100 transition-all duration-200 border-2 border-transparent hover:border-green-500 group">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 rounded-lg flex items-center justify-center bg-green-50">
                                    <svg class="w-6 h-6 text-green-600" viewBox="0 0 24 24" fill="currentColor">
                                        <path
                                            d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z" />
                                    </svg>
                                </div>

                                <div class="flex-1">
                                    <p class="text-sm text-gray-600">WhatsApp</p>
                                    <p class="font-bold text-gray-900 text-lg">{{
                                        configStore.getConfig('whatsApp_e_learning')?.value }}</p>
                                    <p class="text-xs text-gray-500">Assistance en ligne</p>
                                </div>

                                <svg class="w-5 h-5 text-gray-400 group-hover:text-green-600 transition-colors"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="max-w-6xl mx-auto space-y-8 mb-12">
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                    <!-- En-tête de la plateforme -->
                    <div class="p-6 flex items-center gap-4 bg-yellow-50">
                        <div class="w-16 h-16 bg-white rounded-xl flex items-center justify-center shadow-md">
                            <svg class="w-8 h-8 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h2 class="text-2xl font-bold text-gray-900 mb-1">
                                E-Accréditation
                            </h2>
                            <p class="text-gray-600 text-sm">
                                eaccreditation.cena.bj
                            </p>
                        </div>
                        <span class="px-4 py-2 text-white text-sm font-semibold rounded-lg bg-yellow-500">
                            Support dédié
                        </span>
                    </div>

                    <!-- Contacts de la plateforme -->
                    <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div @click="handleContact(configStore.getConfig('freephone_e_accreditation')?.value)"
                            class="bg-gray-50 rounded-xl p-4 cursor-pointer hover:bg-gray-100 transition-all duration-200 border-2 border-transparent hover:border-green-500 group">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 rounded-lg flex items-center justify-center bg-green-50">
                                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                    </svg>
                                </div>

                                <div class="flex-1">
                                    <p class="text-sm text-gray-600">Numéro vert</p>
                                    <p class="font-bold text-gray-900 text-lg">{{
                                        configStore.getConfig('freephone_e_accreditation')?.value }}</p>
                                    <p class="text-xs text-gray-500">Support accréditation</p>
                                </div>

                                <svg class="w-5 h-5 text-gray-400 group-hover:text-green-600 transition-colors"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7" />
                                </svg>
                            </div>
                        </div>
                        <div @click="handleWhatApp(configStore.getConfig('whatsApp_e_accreditation')?.value)"
                            class="bg-gray-50 rounded-xl p-4 cursor-pointer hover:bg-gray-100 transition-all duration-200 border-2 border-transparent hover:border-green-500 group">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 rounded-lg flex items-center justify-center bg-green-50">
                                    <svg class="w-6 h-6 text-green-600" viewBox="0 0 24 24" fill="currentColor">
                                        <path
                                            d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z" />
                                    </svg>
                                </div>

                                <div class="flex-1">
                                    <p class="text-sm text-gray-600">WhatsApp</p>
                                    <p class="font-bold text-gray-900 text-lg">{{
                                        configStore.getConfig('whatsApp_e_accreditation')?.value }}</p>
                                    <p class="text-xs text-gray-500">Assistance accréditation</p>
                                </div>

                                <svg class="w-5 h-5 text-gray-400 group-hover:text-green-600 transition-colors"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="max-w-6xl mx-auto space-y-8 mb-12">
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                    <!-- En-tête de la plateforme -->
                    <div class="p-6 flex items-center gap-4 bg-red-50">
                        <div class="w-16 h-16 bg-white rounded-xl flex items-center justify-center shadow-md">
                            <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h2 class="text-2xl font-bold text-gray-900 mb-1">
                                E-Recrutement
                            </h2>
                            <p class="text-gray-600 text-sm">
                                erecrutement.cena.bj
                            </p>
                        </div>
                        <span class="px-4 py-2 text-white text-sm font-semibold rounded-lg bg-red-600">
                            Support dédié
                        </span>
                    </div>

                    <!-- Contacts de la plateforme -->
                    <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div @click="handleContact(configStore.getConfig('freephone_e_learning')?.value)"
                            class="bg-gray-50 rounded-xl p-4 cursor-pointer hover:bg-gray-100 transition-all duration-200 border-2 border-transparent hover:border-green-500 group">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 rounded-lg flex items-center justify-center bg-green-50">
                                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                    </svg>
                                </div>

                                <div class="flex-1">
                                    <p class="text-sm text-gray-600">Numéro vert</p>
                                    <p class="font-bold text-gray-900 text-lg">{{
                                        configStore.getConfig('freephone_e_learning')?.value }}</p>
                                    <p class="text-xs text-gray-500">Support recrutement</p>
                                </div>

                                <svg class="w-5 h-5 text-gray-400 group-hover:text-green-600 transition-colors"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7" />
                                </svg>
                            </div>
                        </div>
                        <div @click="handleWhatApp(configStore.getConfig('whatsApp_e_recrutement')?.value)"
                            class="bg-gray-50 rounded-xl p-4 cursor-pointer hover:bg-gray-100 transition-all duration-200 border-2 border-transparent hover:border-green-500 group">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 rounded-lg flex items-center justify-center bg-green-50">
                                    <svg class="w-6 h-6 text-green-600" viewBox="0 0 24 24" fill="currentColor">
                                        <path
                                            d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z" />
                                    </svg>
                                </div>

                                <div class="flex-1">
                                    <p class="text-sm text-gray-600">WhatsApp</p>
                                    <p class="font-bold text-gray-900 text-lg">{{
                                        configStore.getConfig('whatsApp_e_recrutement')?.value }}</p>
                                    <p class="text-xs text-gray-500">Assistance recrutement</p>
                                </div>

                                <svg class="w-5 h-5 text-gray-400 group-hover:text-green-600 transition-colors"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Contacts généraux -->
            <!-- <div class="max-w-6xl mx-auto">
                <h2 class="text-2xl font-bold text-blue-900 mb-6 text-center">
                    Support Général
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div v-for="contact in generalContacts" :key="contact.id" @click="handleContact(contact.action)"
                        class="bg-white rounded-xl shadow-md p-6 cursor-pointer hover:shadow-xl transition-all duration-200 border-2 border-transparent hover:border-blue-500">
                        <div class="flex items-center gap-4">
                            <div class="w-14 h-14 rounded-xl flex items-center justify-center"
                                :class="getColorClasses(contact.color).bg">
                                <svg v-if="getContactIcon(contact.icon).isFilled" class="w-7 h-7"
                                    :class="getColorClasses(contact.color).icon" viewBox="0 0 24 24"
                                    fill="currentColor">
                                    <path :d="getContactIcon(contact.icon).path" />
                                </svg>
                                <svg v-else class="w-7 h-7" :class="getColorClasses(contact.color).icon" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        :d="getContactIcon(contact.icon).path" />
                                </svg>
                            </div>

                            <div class="flex-1">
                                <h3 class="font-bold text-gray-900 mb-1">{{ contact.label }}</h3>
                                <p class="text-lg font-semibold text-blue-900">{{ contact.value }}</p>
                                <p class="text-sm text-gray-600">{{ contact.description }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div> -->

            <!-- Informations supplémentaires -->
            <!-- <div class="max-w-6xl mx-auto mt-12 bg-blue-50 rounded-2xl p-8 border-l-4 border-blue-600">
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-blue-900 text-lg mb-2">Horaires d'assistance</h3>
                        <p class="text-gray-700 mb-2">
                            Notre équipe de support technique est disponible du lundi au vendredi de 8h à 18h.
                        </p>
                        <p class="text-gray-700">
                            Pour les urgences en dehors des heures ouvrables, utilisez nos canaux WhatsApp qui sont
                            surveillés 24h/24.
                        </p>
                    </div>
                </div>
            </div> -->
        </div>
    </div>
</template>