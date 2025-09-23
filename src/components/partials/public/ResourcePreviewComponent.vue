<template>
    <div
        class="w-full h-full shadow-xl p-6 flex flex-col space-y-4 bg-white border-s-4 border-[#11845a] hover:bg-[#729FE01A] ease-in duration-300">
        <div class="w-full flex flex-row gap-4">
            <div>
                <IconFileDescription class="size-8 object-cover" />
            </div>
            <div class="flex flex-col space-y-1">
                <p>
                    <span class="font-semibold text-[#0E6258]">{{ resource.title.slice(0, 40) }} {{
                        resource.title.length > 40 ? '...' : '' }}</span>
                </p>
                <!-- <p>
                    <span class="text-[#9F9F9F] text-[13px] font-[500]">{{ formatSize(resource.size) }}</span>
                </p> -->
            </div>
        </div>
        <div class="flex flex-col bg-[#F4F4F4] text-gray-700 px-4 py-2 text-xs gap-2">
            <p><span class="font-bold">Type de document :</span> {{ resource.type }}</p>
            <p><span class="font-bold">Publié le : </span> {{ formatDate(resource.publishedAt.toString()) }}</p>
        </div>
        <div class="flex flex-row justify-end space-x-2 text-sm font-medium">
            <button
                class="bg-[#0E6258] hover:bg-[#C19A6B] text-white py-2 px-4 border-b-2 border-[#C19A6B] hover:border-[#F8F6F0] ease-in duration-300">
                Lire le document
            </button>
            <button
                class="py-2 px-4 border-b-2 border-[#0E6258] text-black hover:text-white hover:bg-[#C19A6B] hover:border-[#F8F6F0] ease-in duration-300">
                Telecharger
            </button>
        </div>
    </div>
</template>
<script setup lang="ts">
import { useFormatDate } from '@/composables/useFormatDate'
import { useFileSize } from '@/composables/useFileSize'
import IconFileDescription from '@/components/icons/IconFileDescription.vue'

const resource = defineProps({
    id: {
        type: String,
        required: true,
    },
    title: {
        type: String,
        required: true,
    },
    size: {
        type: Number,
        required: true,
    },
    type: {
        type: String,
        required: true,
    },
    publishedAt: {
        type: Date,
        required: true,
    },
})


function formatDate(date: string) {
    const { formatDate } = useFormatDate()
    return formatDate(date)
}

function formatSize(size: number) {
    const { formatFileSize } = useFileSize()
    return formatFileSize(size)
}

</script>