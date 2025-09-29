<template>
  <div class="multilingual-array-input">
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
          <label class="form-label">
            {{ label }} ({{ getLanguageName(lang) }})
          </label>
          
          <div class="array-items">
            <div
              v-for="(item, index) in translations[lang]"
              :key="index"
              class="array-item"
            >
              <div class="input-group">
                <input
                  v-model="translations[lang][index]"
                  type="text"
                  class="form-control"
                  :placeholder="`Enter ${label.toLowerCase().slice(0, -1)} ${index + 1}`"
                  @input="updateTranslations"
                />
                <button
                  type="button"
                  class="btn btn-outline-danger"
                  @click="removeItem(lang, index)"
                  :disabled="translations[lang].length <= 1"
                >
                  <i class="fas fa-minus"></i>
                </button>
              </div>
            </div>
          </div>
          
          <button
            type="button"
            class="btn btn-outline-primary btn-sm mt-2"
            @click="addItem(lang)"
          >
            <i class="fas fa-plus"></i>
            Add {{ label.toLowerCase().slice(0, -1) }}
          </button>
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
import { ref, watch } from 'vue'
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
  showAutoTranslate: {
    type: Boolean,
    default: true
  }
})

const emit = defineEmits(['update:modelValue', 'translate'])

const { supportedLanguages, getLanguageName, getLanguageFlag } = useLanguage()

const activeTab = ref('en')
const sourceLanguage = ref('')
const isTranslating = ref(false)

const translations = ref({
  en: Array.isArray(props.modelValue?.en) ? [...props.modelValue.en] : [''],
  it: Array.isArray(props.modelValue?.it) ? [...props.modelValue.it] : [''],
  fr: Array.isArray(props.modelValue?.fr) ? [...props.modelValue.fr] : ['']
})

// Watch for external changes to modelValue
watch(() => props.modelValue, (newValue) => {
  if (newValue) {
    translations.value = {
      en: Array.isArray(newValue.en) ? [...newValue.en] : [''],
      it: Array.isArray(newValue.it) ? [...newValue.it] : [''],
      fr: Array.isArray(newValue.fr) ? [...newValue.fr] : ['']
    }
  }
}, { deep: true })

// Add item to specific language
const addItem = (lang) => {
  translations.value[lang].push('')
  updateTranslations()
}

// Remove item from specific language
const removeItem = (lang, index) => {
  if (translations.value[lang].length > 1) {
    translations.value[lang].splice(index, 1)
    updateTranslations()
  }
}

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
        if (translations.value[lang] && translations.value[lang].some(item => item.trim())) {
          sourceLang = lang
          break
        }
      }
    }
    
    if (!sourceLang) {
      alert('Please enter content in at least one language before auto-translating.')
      return
    }
    
    const sourceItems = translations.value[sourceLang].filter(item => item.trim())
    if (sourceItems.length === 0) {
      alert('Source content is empty.')
      return
    }
    
    // Emit translate event to parent component
    emit('translate', {
      sourceLanguage: sourceLang,
      sourceText: sourceItems,
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
.multilingual-array-input {
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

.array-items {
  margin-bottom: 12px;
}

.array-item {
  margin-bottom: 8px;
}

.input-group {
  display: flex;
  align-items: center;
  gap: 8px;
}

.form-control {
  flex: 1;
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

.btn {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 6px;
  padding: 8px 12px;
  font-size: 14px;
  font-weight: 500;
  text-align: center;
  text-decoration: none;
  border: 1px solid transparent;
  border-radius: 4px;
  cursor: pointer;
  transition: all 0.15s ease-in-out;
  min-width: 40px;
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

.btn-outline-danger {
  color: #dc3545;
  border-color: #dc3545;
  background-color: transparent;
}

.btn-outline-danger:hover {
  color: #fff;
  background-color: #dc3545;
  border-color: #dc3545;
}

.btn-sm {
  padding: 6px 12px;
  font-size: 12px;
}

.btn:disabled {
  opacity: 0.65;
  cursor: not-allowed;
}

.mt-2 {
  margin-top: 8px;
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

.fa-spinner {
  animation: spin 1s linear infinite;
}

@keyframes spin {
  from { transform: rotate(0deg); }
  to { transform: rotate(360deg); }
}
</style>
