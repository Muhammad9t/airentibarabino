<template>
  <ul v-if="displayItems && displayItems.length > 0" class="multilingual-list">
    <li v-for="(item, index) in displayItems" :key="index" class="multilingual-list-item">
      {{ item }}
    </li>
  </ul>
  <div v-else class="text-muted">
    {{ fallbackText }}
  </div>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  translations: {
    type: Object,
    default: () => ({})
  },
  fallbackText: {
    type: String,
    default: 'No items available'
  },
  language: {
    type: String,
    default: 'en'
  }
})

const displayItems = computed(() => {
  if (!props.translations || typeof props.translations !== 'object') {
    return []
  }
  
  // Try to get the requested language
  if (props.translations[props.language] && Array.isArray(props.translations[props.language])) {
    return props.translations[props.language]
  }
  
  // Fallback to English
  if (props.translations.en && Array.isArray(props.translations.en)) {
    return props.translations.en
  }
  
  // Fallback to any available language
  const availableLanguages = Object.keys(props.translations)
  for (const lang of availableLanguages) {
    if (Array.isArray(props.translations[lang])) {
      return props.translations[lang]
    }
  }
  
  return []
})
</script>

<style scoped>
.multilingual-list {
  list-style-type: disc;
  padding-left: 1.5rem;
  margin: 0.5rem 0;
}

.multilingual-list-item {
  margin-bottom: 0.25rem;
}

.text-muted {
  color: #6c757d;
  font-style: italic;
}
</style>
