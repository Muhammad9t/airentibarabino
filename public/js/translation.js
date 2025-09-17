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

document.addEventListener("DOMContentLoaded", () => {
  // Always set to Italian on page load
  setLanguage("it");

  const langSwitcher = document.getElementById("lang-switcher");
  if (langSwitcher) {
    langSwitcher.value = "it"; // Set dropdown to Italian
    langSwitcher.addEventListener("change", (event) => {
      setLanguage(event.target.value);
    });
  }
});

