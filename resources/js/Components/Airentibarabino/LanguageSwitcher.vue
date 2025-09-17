<template>
  <div class="floating-lang-switcher">
    <select id="lang-switcher">
      <option value="it">🇮🇹 Italiano</option>
      <option value="en">🇬🇧 English</option>
      <option value="fr">🇫🇷 Français</option>
    </select>
  </div>
</template>

<script setup>
import { onMounted } from "vue";

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
  localStorage.setItem("language", lang);
}

onMounted(() => {
  // Always set to Italian when page loads
  setLanguage("it");

  const langSwitcher = document.getElementById("lang-switcher");
  if (langSwitcher) {
    langSwitcher.value = "it";
    langSwitcher.addEventListener("change", (event) => {
      setLanguage(event.target.value);
    });
  }
});
</script>

<style scoped>
.floating-lang-switcher {
  position: fixed;
  bottom: 30px;
  left: 30px;
  z-index: 9999;
  background: #fff;
  border-radius: 30px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
  padding: 8px 16px;
  display: flex;
  align-items: center;
}
.floating-lang-switcher select {
  border: none;
  background: transparent;
  font-size: 1rem;
  outline: none;
  cursor: pointer;
}
</style>
