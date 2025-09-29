<script setup>
    import { onMounted } from "vue";
    import { useLanguage } from '../../Composables/useLanguage.js';

    const { setLanguage: setVueLanguage, language } = useLanguage();

    const translations = {};

    async function loadTranslations(lang) {
    try {
        const response = await fetch(`/js/i18n/${lang}.json`);
        if (!response.ok) {
        throw new Error(`Failed to load translation file for ${lang}`);
        }
        translations[lang] = await response.json();
        return translations[lang];
    } catch (error) {
        console.error(error);
    }
    }

    function translatePage(lang) {
    const elements = document.querySelectorAll("[data-i18n-key]");
    elements.forEach((element) => {
        const key = element.getAttribute("data-i18n-key");
        if (translations[lang] && translations[lang][key]) {
        element.innerHTML = translations[lang][key];
        }
    });
    }

    async function setLanguage(lang) {
    if (!translations[lang]) {
        await loadTranslations(lang);
    }
    translatePage(lang);
    setVueLanguage(lang); // Use the Vue composable to set language
    }

    onMounted(() => {
    // Get current language from localStorage or default to 'it'
    const currentLang = localStorage.getItem('language') || 'it';
    setLanguage(currentLang);

    const langSwitcher = document.getElementById("lang-switcher");
    if (langSwitcher) {
        langSwitcher.value = currentLang;
        langSwitcher.addEventListener("change", (event) => {
        setLanguage(event.target.value);
        });
    }
    });
</script>

<template>
  <div class="floating-lang-switcher">
    <select id="lang-switcher">
      <option value="it">🇮🇹 Italiano</option>
      <option value="en">🇬🇧 English</option>
      <option value="fr">🇫🇷 Français</option>
    </select>
  </div>
</template>
