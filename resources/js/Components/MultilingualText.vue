<template>
  <div class="multilingual-text">
    <span v-if="displayText">{{ displayText }}</span>
    <span v-else class="text-muted">{{ fallbackText }}</span>
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
    default: 'No translation available'
  },
  language: {
    type: String,
    default: 'en'
  }
})

const displayText = computed(() => {
  if (!props.translations || typeof props.translations !== 'object') {
    return props.fallbackText
  }
  
  // Try to get the requested language
  if (props.translations[props.language]) {
    return props.translations[props.language]
  }
  
  // Fallback to English
  if (props.translations.en) {
    return props.translations.en
  }
  
  // Fallback to any available language
  const availableLanguages = Object.keys(props.translations)
  if (availableLanguages.length > 0) {
    return props.translations[availableLanguages[0]]
  }
  
  return props.fallbackText
})
</script>

<style scoped>
.multilingual-text {
  display: inline-block;
}

.text-muted {
  color: #6c757d;
  font-style: italic;
}
</style>
