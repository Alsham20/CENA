<template>
  <div class="relative">
    <!-- Button to show the document preview -->
    <button
      class="flex items-center justify-center gap-1 bg-[#2D3748] hover:bg-white text-white hover:text-[#2D3748] p-2 px-4 border-b border-[#2D3748] hover:border ease-in duration-300"
      @click="showPreview" :disabled="loading">
      {{ loading ? 'Loading...' : 'Lire' }}
      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
        class="bi bi-bookmark-fill w-3 h-3" viewBox="0 0 16 16">
        <path d="M2 2v13.5a.5.5 0 0 0 .74.439L8 13.069l5.26 2.87A.5.5 0 0 0 14 15.5V2a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2" />
      </svg>
    </button>

    <TransitionRoot as="template" :show="isPreviewVisible">
      <HDialog class="relative z-50" @close="isPreviewVisible = false">
        <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0" enter-to="opacity-100"
          leave="ease-in duration-200" leave-from="opacity-100" leave-to="opacity-0">
          <div class="fixed inset-0 bg-black bg-opacity-50 transition-opacity" />
        </TransitionChild>

        <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
          <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            <TransitionChild as="template" enter="ease-out duration-300"
              enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
              enter-to="opacity-100 translate-y-0 sm:scale-100" leave="ease-in duration-200"
              leave-from="opacity-100 translate-y-0 sm:scale-100"
              leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
              <DialogPanel class="bg-white rounded-lg shadow-lg max-w-4xl w-full max-h-[90%] overflow-auto relative">
                <!-- Close Button -->
                <button @click="closePreview" class="absolute top-2 right-2 text-gray-500 hover:text-gray-800">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                    stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                  </svg>
                </button>

                <!-- Error Message -->
                <div v-if="error" class="p-4 text-red-500 text-center">
                  {{ error }}
                </div>

                <!-- PDF Preview -->
                <iframe v-if="isPdf" :src="'https://docs.google.com/gview?url=' +
                  encodeURIComponent(previewUrl as string) +
                  '&embedded=true'
                  " class="w-full h-[90vh]" frameborder="0" title="PDF Preview"></iframe>

                <!-- Image Preview -->
                <img v-if="isImage" :src="previewUrl" alt="Document Preview"
                  class="w-full max-h-[80vh] object-contain" />

                <!-- Text Preview -->
                <pre v-if="isText" class="p-4 bg-gray-100 border border-gray-300 rounded overflow-auto max-h-[80vh]">
                    {{ textContent }}
                </pre>

                <!-- Unsupported File Type -->
                <div v-if="isUnsupported" class="p-4 text-center text-gray-500">
                  Preview not available for this file type.
                </div>
              </DialogPanel>
            </TransitionChild>
          </div>
        </div>
      </HDialog>
    </TransitionRoot>
  </div>
</template>

<script lang="ts">
import { Dialog as HDialog, DialogPanel, TransitionChild, TransitionRoot } from '@headlessui/vue'
import { resourceUrl } from '@/utils/resource'
export default {
  name: 'DocumentPreview',
  components: {
    HDialog,
    DialogPanel,
    TransitionChild,
    TransitionRoot,
  },
  props: {
    url: {
      type: String,
      required: true,
    },
    type: {
      type: String,
      required: true,
    },
  },
  data() {
    return {
      open: true,
      isPreviewVisible: false,
      loading: false,
      error: undefined as string | undefined,
      previewUrl: undefined as string | undefined,
      textContent: undefined as string | undefined,
      isPdf: false,
      isImage: false,
      isText: false,
      isUnsupported: false,
      resourceUrl,
    }
  },
  methods: {
    async showPreview() {
      this.resetState()
      this.isPreviewVisible = true
      this.loading = true
      try {
        if (this.type === 'application/pdf') {
          this.isPdf = true
          this.previewUrl = this.resourceUrl + this.url
        } else if (['image/jpeg', 'image/png', 'image/gif'].includes(this.type)) {
          this.isImage = true
          this.previewUrl = this.resourceUrl + this.url
        } else if (this.type === 'text/plain') {
          this.isText = true
          const response = await fetch(this.resourceUrl + this.url)
          if (!response.ok) {
            throw new Error('Failed to fetch document content.')
          }
          this.textContent = await response.text()
        } else {
          this.isUnsupported = true
        }
      } catch (err) {
        this.error = (err as Error).message || 'An error occurred while loading the document.'
      } finally {
        this.loading = false
      }
    },
    closePreview() {
      this.isPreviewVisible = false
    },
    resetState() {
      this.loading = false
      this.error = undefined
      this.previewUrl = undefined
      this.textContent = undefined
      this.isPdf = false
      this.isImage = false
      this.isText = false
      this.isUnsupported = false
    },
  },
}
</script>

<style>
/* No extra CSS needed since Tailwind CSS is used */
</style>
