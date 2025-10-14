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
    console.debug("[translation] setLanguage start", lang);
    if (!translations[lang]) {
        await loadTranslations(lang);
    }
    // Apply translations to DOM
    translatePage(lang);
    // Persist to localStorage
    try {
        localStorage.setItem("language", lang);
    } catch (error) {
        console.warn("Could not save language to localStorage:", error);
    }
    console.debug("[translation] setLanguage done", lang);
}

// Initialize on page load
document.addEventListener("DOMContentLoaded", () => {
    // Get stored language or default to Italian
    const storedLang = (() => {
        try {
            return localStorage.getItem("language") || "it";
        } catch (e) {
            return "it";
        }
    })();

    // Set initial language
    console.debug("[translation] DOMContentLoaded, storedLang=", storedLang);
    setLanguage(storedLang).catch((e) =>
        console.error("[translation] setLanguage error", e)
    );

    // Setup language switcher listener
    const langSwitcher = document.getElementById("lang-switcher");
    if (langSwitcher) {
        langSwitcher.value = storedLang;
        langSwitcher.addEventListener("change", (event) => {
            setLanguage(event.target.value);
        });
    }
});

// Listen for language changes from Vue components
window.addEventListener("languageChanged", (event) => {
    const lang = event.detail?.language || event.detail;
    if (lang) {
        console.debug("[translation] languageChanged event received", lang);
        setLanguage(lang);
    }
});

// Export for global use
window.setLanguage = setLanguage;
window.loadTranslations = loadTranslations;

// Re-apply translations when Inertia swaps page content
const reapplyStoredLanguage = () => {
    let stored = "it";
    try {
        stored = localStorage.getItem("language") || "it";
    } catch (e) {
        stored = "it";
    }
    setLanguage(stored);
};

// Inertia emits several events during navigation
["inertia:finish", "inertia:navigate", "inertia:load", "page:finish"].forEach(
    (evt) => {
        document.addEventListener(evt, reapplyStoredLanguage);
    }
);

// Some setups use Turbolinks/PJAX — also listen for generic events
document.addEventListener("turbo:load", reapplyStoredLanguage);
document.addEventListener("pjax:complete", reapplyStoredLanguage);

// Observe DOM mutations and re-apply translations when elements with data-i18n-key
// are added (covers Inertia/Vue swaps where new nodes are injected)
try {
    let mutationTimer = null;
    const debouncedReapply = () => {
        if (mutationTimer) clearTimeout(mutationTimer);
        mutationTimer = setTimeout(() => {
            reapplyStoredLanguage();
        }, 60);
    };

    const observer = new MutationObserver((mutations) => {
        for (const m of mutations) {
            if (m.addedNodes && m.addedNodes.length) {
                for (const node of m.addedNodes) {
                    if (!(node instanceof Element)) continue;
                    // If the added node itself or any of its descendants include data-i18n-key
                    if (node.matches && node.matches("[data-i18n-key]")) {
                        console.debug(
                            "[translation] MutationObserver: added node with data-i18n-key"
                        );
                        debouncedReapply();
                        return;
                    }
                    if (
                        node.querySelector &&
                        node.querySelector("[data-i18n-key]")
                    ) {
                        console.debug(
                            "[translation] MutationObserver: descendant with data-i18n-key added"
                        );
                        debouncedReapply();
                        return;
                    }
                }
            }
        }
    });

    observer.observe(document.documentElement || document.body, {
        childList: true,
        subtree: true,
    });
} catch (e) {
    // If MutationObserver isn't available, fallback to relying on events only
}
