<script setup>
import { onMounted, watch } from "vue";
import { useLanguage } from "../../Composables/useLanguage.js";

const {
    setLanguage: setVueLanguage,
    language,
    currentLanguage,
} = useLanguage();

const translations = {};

async function loadTranslations(lang) {
    try {
        // Return cached translation if already loaded
        if (translations[lang]) {
            return translations[lang];
        }

        const response = await fetch(`/js/i18n/${lang}.json`);
        if (!response.ok) {
            throw new Error(`Failed to load translation file for ${lang}`);
        }
        translations[lang] = await response.json();
        return translations[lang];
    } catch (error) {
        console.error("Translation loading error:", error);
        return {};
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
    // Load translation if not cached
    if (!translations[lang]) {
        await loadTranslations(lang);
    }
    // Apply translations to static DOM elements
    translatePage(lang);
    // Update Vue state and dispatch event
    setVueLanguage(lang);
}

onMounted(() => {
    // Get current language from localStorage or default to 'it'
    const currentLang = currentLanguage.value;

    // Set initial language and translations
    setLanguage(currentLang);

    // Update lang-switcher dropdown value
    const langSwitcher = document.getElementById("lang-switcher");
    if (langSwitcher) {
        langSwitcher.value = currentLang;
        langSwitcher.addEventListener("change", (event) => {
            setLanguage(event.target.value);
        });
    }
});

// Watch for external language changes
watch(language, (newLang) => {
    const langSwitcher = document.getElementById("lang-switcher");
    if (langSwitcher) {
        langSwitcher.value = newLang;
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
