<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'description',
        'description_translations',
        'image',
        'status'
    ];

    protected $casts = [
        'description_translations' => 'array',
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Get translated field value with fallback
     *
     * @param string $field
     * @param string $language
     * @return string
     */
    public function getTranslated(string $field, string $language = 'en'): string
    {
        $translationsField = $field . '_translations';
        
        if ($this->$translationsField && isset($this->$translationsField[$language])) {
            return $this->$translationsField[$language];
        }
        
        // Fallback to English
        if ($this->$translationsField && isset($this->$translationsField['en'])) {
            return $this->$translationsField['en'];
        }
        
        // Fallback to original field
        return $this->$field ?? '';
    }

    /**
     * Get translated description
     *
     * @param string $language
     * @return string
     */
    public function getTranslatedDescription(string $language = 'en'): string
    {
        return $this->getTranslated('description', $language);
    }
}
