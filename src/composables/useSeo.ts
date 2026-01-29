import { useHead } from "@vueuse/head";
import { computed, watchEffect } from "vue";
import type { z } from "zod";
import { pageSchema } from "@/requests/page";
import type { articleSchema } from "@/requests/article";

export function useSeo(page: z.infer<typeof pageSchema>) {
  const title = computed(() => page.title || "");
  const description = computed(() => page.resume || page.content_description || "");
  const keywords = computed(() => page.content_keywords || page.tags || "");
  const image = computed(() =>
    page.poster_media
      ? `${page.poster_media.base_url}${page.poster_media.path}/${page.poster_media.name}`
      : `${import.meta.env.VITE_APP_URL}/src/assets/img/images-removebg-preview.png`
  );
  const pageUrl = computed(() => `${import.meta.env.VITE_APP_URL}/${page.slug}`);

  watchEffect(() => {
    useHead({
      title: title.value,
      meta: [
        { name: "description", content: description.value },
        { name: "keywords", content: keywords.value },
        { property: "og:title", content: title.value },
        { property: "og:description", content: description.value },
        { property: "og:image", content: image.value },
        { property: "og:url", content: pageUrl.value },
        { property: "og:type", content: "website" },
        { name: "twitter:card", content: "summary_large_image" },
        { name: "twitter:title", content: title.value },
        { name: "twitter:description", content: description.value },
        { name: "twitter:image", content: image.value }
      ],
      script: [
        {
          type: "application/ld+json",
          innerHTML: JSON.stringify({
            "@context": "https://schema.org",
            "@type": "WebPage",
            "headline": title.value,
            "description": description.value,
            "keywords": keywords.value,
            "image": image.value,
            "datePublished": page.created_at,
            "dateModified": page.updated_at || page.created_at,
            "mainEntityOfPage": {
              "@type": "WebPage",
              "@id": pageUrl.value
            }
          })
        }
      ]
    });
  });
}

export function useArticleSeo(article: z.infer<typeof articleSchema>) {
  const title = computed(() => article.title || "");
  const description = computed(() => article.resume || article.content_description || "");
  const keywords = computed(() => article.content_keywords || article.tags || "");
  const image = computed(() =>
    article.image
      ? `${import.meta.env.VITE_BACKOFFICE_URL}${article.image?.base_url}${article.image?.path}/${article.image?.name}`
      : `${import.meta.env.VITE_APP_URL}/src/assets/img/images-removebg-preview.png`
  );
  const articleUrl = computed(() => `${import.meta.env.VITE_APP_URL}/articles/${article.slug}`);

  watchEffect(() => {
    useHead({
      title: title.value,
      meta: [
        { name: "description", content: description.value },
        { name: "keywords", content: keywords.value },
        { property: "og:title", content: title.value },
        { property: "og:description", content: description.value },
        { property: "og:image", content: image.value },
        { property: "og:url", content: articleUrl.value },
        { property: "og:type", content: "website" },
        { name: "twitter:card", content: "summary_large_image" },
        { name: "twitter:title", content: title.value },
        { name: "twitter:description", content: description.value },
        { name: "twitter:image", content: image.value }
      ],
      script: [
        {
          type: "application/ld+json",
          innerHTML: JSON.stringify({
            "@context": "https://schema.org",
            "@type": "WebPage",
            "headline": title.value,
            "description": description.value,
            "keywords": keywords.value,
            "image": image.value,
            "datePublished": article.created_at,
            "dateModified": article.updated_at || article.created_at,
            "mainEntityOfPage": {
              "@type": "WebPage",
              "@id": articleUrl.value
            }
          })
        }
      ]
    });
  });
}
