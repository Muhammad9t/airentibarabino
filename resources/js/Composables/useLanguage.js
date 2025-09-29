import { ref, computed, watch } from 'vue'

// Global language state
const currentLanguage = ref(localStorage.getItem('language') || 'en')

// Supported languages
const supportedLanguages = ['en', 'it', 'fr']

// Language names for display
const languageNames = {
  en: 'English',
  it: 'Italiano',
  fr: 'Français'
}

// Language flags for display
const languageFlags = {
  en: '🇬🇧',
  it: '🇮🇹',
  fr: '🇫🇷'
}

export function useLanguage() {
  // Computed properties
  const language = computed(() => currentLanguage.value)
  const isEnglish = computed(() => currentLanguage.value === 'en')
  const isItalian = computed(() => currentLanguage.value === 'it')
  const isFrench = computed(() => currentLanguage.value === 'fr')

  // Methods
  const setLanguage = (lang) => {
    if (supportedLanguages.includes(lang)) {
      currentLanguage.value = lang
      localStorage.setItem('language', lang)
      
      // Trigger language change event for other components
      window.dispatchEvent(new CustomEvent('languageChanged', { 
        detail: { language: lang } 
      }))
    }
  }

  const getLanguageName = (lang = null) => {
    const targetLang = lang || currentLanguage.value
    return languageNames[targetLang] || targetLang
  }

  const getLanguageFlag = (lang = null) => {
    const targetLang = lang || currentLanguage.value
    return languageFlags[targetLang] || '🌐'
  }

  const getTranslatedText = (translations, fallback = '') => {
    if (!translations || typeof translations !== 'object') {
      return fallback || ''
    }
    
    // Try to get the current language
    if (translations[currentLanguage.value] && translations[currentLanguage.value] !== null) {
      return translations[currentLanguage.value]
    }
    
    // Fallback to English
    if (translations.en && translations.en !== null) {
      return translations.en
    }
    
    // Fallback to any available language
    const availableLanguages = Object.keys(translations)
    for (const lang of availableLanguages) {
      if (translations[lang] && translations[lang] !== null) {
        return translations[lang]
      }
    }
    
    return fallback || ''
  }

  const getTranslatedArray = (translations, fallback = []) => {
    if (!translations || typeof translations !== 'object') {
      return fallback || []
    }
    
    // Try to get the current language
    if (translations[currentLanguage.value] && Array.isArray(translations[currentLanguage.value])) {
      return translations[currentLanguage.value]
    }
    
    // Fallback to English
    if (translations.en && Array.isArray(translations.en)) {
      return translations.en
    }
    
    // Fallback to any available language
    const availableLanguages = Object.keys(translations)
    for (const lang of availableLanguages) {
      if (translations[lang] && Array.isArray(translations[lang])) {
        return translations[lang]
      }
    }
    
    return fallback || []
  }

  // Watch for language changes and update localStorage
  watch(currentLanguage, (newLang) => {
    localStorage.setItem('language', newLang)
  })

  return {
    // State
    language,
    currentLanguage,
    supportedLanguages,
    languageNames,
    languageFlags,
    
    // Computed
    isEnglish,
    isItalian,
    isFrench,
    
    // Methods
    setLanguage,
    getLanguageName,
    getLanguageFlag,
    getTranslatedText,
    getTranslatedArray
  }
}

// Export for global use
export { currentLanguage, supportedLanguages, languageNames, languageFlags }
