<template>
  <div class="multilingual-input">
    <div class="multilingual-tabs">
      <button
        v-for="lang in supportedLanguages"
        :key="lang"
        type="button"
        class="tab-button"
        :class="{ active: activeTab === lang }"
        @click="activeTab = lang"
      >
        {{ getLanguageFlag(lang) }} {{ getLanguageName(lang) }}
      </button>
    </div>
    
    <div class="tab-content">
      <div
        v-for="lang in supportedLanguages"
        :key="lang"
        v-show="activeTab === lang"
        class="tab-pane"
      >
        <div class="form-group">
          <label :for="`${fieldName}_${lang}`" class="form-label">
            {{ label }} ({{ getLanguageName(lang) }})
          </label>
          <textarea
            v-if="type === 'textarea'"
            :id="`${fieldName}_${lang}`"
            v-model="translations[lang]"
            :class="['form-control', { 'is-invalid': errors[lang] }]"
            :rows="rows"
            :placeholder="`Enter ${label.toLowerCase()} in ${getLanguageName(lang)}`"
            @input="updateTranslations"
          ></textarea>
          <input
            v-else
            :id="`${fieldName}_${lang}`"
            v-model="translations[lang]"
            :type="type"
            :class="['form-control', { 'is-invalid': errors[lang] }]"
            :placeholder="`Enter ${label.toLowerCase()} in ${getLanguageName(lang)}`"
            @input="updateTranslations"
          />
          <div v-if="errors[lang]" class="invalid-feedback">
            {{ errors[lang] }}
          </div>
        </div>
      </div>
    </div>
    
    <div v-if="showAutoTranslate" class="auto-translate-section">
      <div class="form-group">
        <label class="form-label">Source Language</label>
        <select v-model="sourceLanguage" class="form-control">
          <option value="">Auto-detect</option>
          <option v-for="lang in supportedLanguages" :key="lang" :value="lang">
            {{ getLanguageFlag(lang) }} {{ getLanguageName(lang) }}
          </option>
        </select>
      </div>
      <button
        type="button"
        class="btn btn-outline-primary btn-sm"
        @click="autoTranslate"
        :disabled="isTranslating"
      >
        <i v-if="isTranslating" class="fas fa-spinner fa-spin"></i>
        <i v-else class="fas fa-language"></i>
        Auto-translate missing languages
      </button>
    </div>
  </div>
</template>

<script setup>
import { ref, watch, computed } from 'vue'
import { useLanguage } from '../../Composables/useLanguage.js'

const props = defineProps({
  modelValue: {
    type: Object,
    default: () => ({})
  },
  fieldName: {
    type: String,
    required: true
  },
  label: {
    type: String,
    required: true
  },
  type: {
    type: String,
    default: 'text'
  },
  rows: {
    type: Number,
    default: 3
  },
  showAutoTranslate: {
    type: Boolean,
    default: true
  },
  errors: {
    type: Object,
    default: () => ({})
  }
})

const emit = defineEmits(['update:modelValue', 'translate'])

const { supportedLanguages, getLanguageName, getLanguageFlag } = useLanguage()

const activeTab = ref('en')
const sourceLanguage = ref('')
const isTranslating = ref(false)

const translations = ref({
  en: props.modelValue?.en || '',
  it: props.modelValue?.it || '',
  fr: props.modelValue?.fr || ''
})

// Watch for external changes to modelValue
watch(() => props.modelValue, (newValue) => {
  if (newValue) {
    translations.value = {
      en: newValue.en || '',
      it: newValue.it || '',
      fr: newValue.fr || ''
    }
  }
}, { deep: true })

// Update parent component when translations change
const updateTranslations = () => {
  emit('update:modelValue', { ...translations.value })
}

// Auto-translate missing languages
const autoTranslate = async () => {
  isTranslating.value = true
  
  try {
    // Find the language with content to use as source
    let sourceLang = sourceLanguage.value
    if (!sourceLang) {
      for (const lang of supportedLanguages) {
        if (translations.value[lang] && translations.value[lang].trim()) {
          sourceLang = lang
          break
        }
      }
    }
    
    if (!sourceLang) {
      alert('Please enter content in at least one language before auto-translating.')
      return
    }
    
    const sourceText = translations.value[sourceLang]
    if (!sourceText.trim()) {
      alert('Source text is empty.')
      return
    }
    
    // Emit translate event to parent component
    emit('translate', {
      sourceLanguage: sourceLang,
      sourceText: sourceText,
      fieldName: props.fieldName
    })
    
  } catch (error) {
    console.error('Translation error:', error)
    alert('Translation failed. Please try again.')
  } finally {
    isTranslating.value = false
  }
}

// Watch for changes in translations and emit updates
watch(translations, updateTranslations, { deep: true })
</script>

<style scoped>
.multilingual-input {
  border: 1px solid #e0e0e0;
  border-radius: 8px;
  overflow: hidden;
}

.multilingual-tabs {
  display: flex;
  background-color: #f8f9fa;
  border-bottom: 1px solid #e0e0e0;
}

.tab-button {
  flex: 1;
  padding: 12px 16px;
  border: none;
  background: transparent;
  cursor: pointer;
  font-size: 14px;
  font-weight: 500;
  color: #6c757d;
  transition: all 0.2s ease;
  border-bottom: 3px solid transparent;
}

.tab-button:hover {
  background-color: #e9ecef;
  color: #495057;
}

.tab-button.active {
  background-color: #fff;
  color: #007bff;
  border-bottom-color: #007bff;
}

.tab-content {
  background-color: #fff;
}

.tab-pane {
  padding: 20px;
}

.form-group {
  margin-bottom: 0;
}

.form-label {
  font-weight: 600;
  color: #495057;
  margin-bottom: 8px;
  display: block;
}

.form-control {
  width: 100%;
  padding: 10px 12px;
  border: 1px solid #ced4da;
  border-radius: 4px;
  font-size: 14px;
  transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
}

.form-control:focus {
  border-color: #007bff;
  outline: 0;
  box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}

.form-control.is-invalid {
  border-color: #dc3545;
}

.invalid-feedback {
  display: block;
  width: 100%;
  margin-top: 0.25rem;
  font-size: 0.875rem;
  color: #dc3545;
}

.auto-translate-section {
  padding: 16px 20px;
  background-color: #f8f9fa;
  border-top: 1px solid #e0e0e0;
  display: flex;
  align-items: end;
  gap: 16px;
}

.auto-translate-section .form-group {
  flex: 1;
  margin-bottom: 0;
}

.btn {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  padding: 8px 16px;
  font-size: 14px;
  font-weight: 500;
  text-align: center;
  text-decoration: none;
  border: 1px solid transparent;
  border-radius: 4px;
  cursor: pointer;
  transition: all 0.15s ease-in-out;
}

.btn-outline-primary {
  color: #007bff;
  border-color: #007bff;
  background-color: transparent;
}

.btn-outline-primary:hover {
  color: #fff;
  background-color: #007bff;
  border-color: #007bff;
}

.btn-sm {
  padding: 6px 12px;
  font-size: 12px;
}

.btn:disabled {
  opacity: 0.65;
  cursor: not-allowed;
}

.fa-spinner {
  animation: spin 1s linear infinite;
}

@keyframes spin {
  from { transform: rotate(0deg); }
  to { transform: rotate(360deg); }
}
</style>
