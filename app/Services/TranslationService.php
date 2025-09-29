<?php

namespace App\Services;

use Statickidz\GoogleTranslate;
use Illuminate\Support\Facades\Log;

class TranslationService
{
    private GoogleTranslate $translator;
    private array $supportedLanguages = ['en', 'it', 'fr'];

    public function __construct()
    {
        $this->translator = new GoogleTranslate();
    }

    /**
     * Generate translations for all supported languages
     *
     * @param string $text The text to translate
     * @param string $sourceLanguage The source language (en, it, fr)
     * @return array JSON object with translations for all languages
     */
    public function generateTranslations(string $text, string $sourceLanguage = 'en'): array
    {
        if (empty(trim($text))) {
            return $this->getEmptyTranslations();
        }

        $translations = [];
        $translations[$sourceLanguage] = $text;

        foreach ($this->supportedLanguages as $targetLanguage) {
            if ($targetLanguage === $sourceLanguage) {
                continue;
            }

            try {
                $translatedText = $this->translator->translate($sourceLanguage, $targetLanguage, $text);
                $translations[$targetLanguage] = $translatedText;
                
                // Add a small delay to avoid rate limiting
                usleep(100000); // 0.1 second
            } catch (\Exception $e) {
                Log::warning("Translation failed for {$sourceLanguage} to {$targetLanguage}: " . $e->getMessage());
                $translations[$targetLanguage] = $text; // Fallback to original text
            }
        }

        return $translations;
    }

    /**
     * Generate translations for an array of texts (like points)
     *
     * @param array $texts Array of texts to translate
     * @param string $sourceLanguage The source language
     * @return array JSON object with translations for all languages
     */
    public function generateArrayTranslations(array $texts, string $sourceLanguage = 'en'): array
    {
        if (empty($texts)) {
            return $this->getEmptyTranslations();
        }

        $translations = [];
        $translations[$sourceLanguage] = $texts;

        foreach ($this->supportedLanguages as $targetLanguage) {
            if ($targetLanguage === $sourceLanguage) {
                continue;
            }

            $translatedTexts = [];
            foreach ($texts as $text) {
                try {
                    $translatedText = $this->translator->translate($sourceLanguage, $targetLanguage, $text);
                    $translatedTexts[] = $translatedText;
                    
                    // Add a small delay to avoid rate limiting
                    usleep(100000); // 0.1 second
                } catch (\Exception $e) {
                    Log::warning("Array translation failed for {$sourceLanguage} to {$targetLanguage}: " . $e->getMessage());
                    $translatedTexts[] = $text; // Fallback to original text
                }
            }
            $translations[$targetLanguage] = $translatedTexts;
        }

        return $translations;
    }

    /**
     * Update existing translations with new content
     *
     * @param array $existingTranslations Current translations
     * @param string $text New text to translate
     * @param string $sourceLanguage Source language
     * @return array Updated translations
     */
    public function updateTranslations(array $existingTranslations, string $text, string $sourceLanguage = 'en'): array
    {
        $newTranslations = $this->generateTranslations($text, $sourceLanguage);
        
        // Merge with existing translations, keeping existing ones if new ones are empty
        foreach ($this->supportedLanguages as $lang) {
            if (isset($existingTranslations[$lang]) && !empty($existingTranslations[$lang])) {
                // Keep existing translation if new one is empty or same as source
                if (empty($newTranslations[$lang]) || $newTranslations[$lang] === $text) {
                    $newTranslations[$lang] = $existingTranslations[$lang];
                }
            }
        }

        return $newTranslations;
    }

    /**
     * Detect the language of the input text
     *
     * @param string $text
     * @return string Detected language code
     */
    public function detectLanguage(string $text): string
    {
        // Simple language detection based on common patterns
        $text = strtolower(trim($text));
        
        // Italian patterns
        if (preg_match('/\b(il|la|lo|gli|le|di|da|del|della|dei|delle|con|per|su|in|a|al|alla|ai|alle)\b/', $text)) {
            return 'it';
        }
        
        // French patterns
        if (preg_match('/\b(le|la|les|du|de|des|avec|pour|sur|dans|à|au|aux)\b/', $text)) {
            return 'fr';
        }
        
        // Default to English
        return 'en';
    }

    /**
     * Get empty translations structure
     *
     * @return array
     */
    private function getEmptyTranslations(): array
    {
        return [
            'en' => '',
            'it' => '',
            'fr' => ''
        ];
    }

    /**
     * Get supported languages
     *
     * @return array
     */
    public function getSupportedLanguages(): array
    {
        return $this->supportedLanguages;
    }

    /**
     * Validate language code
     *
     * @param string $language
     * @return bool
     */
    public function isValidLanguage(string $language): bool
    {
        return in_array($language, $this->supportedLanguages);
    }
}
