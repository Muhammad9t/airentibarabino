<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Service extends Model
{
    protected $fillable = [
        'name',
        'name_translations',
        'slug',
        'description',
        'description_translations',
        'status',
        'menu_order'
    ];

    protected $casts = [
        'menu_order' => 'integer',
        'name_translations' => 'array',
        'description_translations' => 'array',
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    // Relationship: A service can have many sub-services
    public function subServices(): HasMany
    {
        return $this->hasMany(SubService::class)->orderBy('sort_order');
    }

    // Scope: Get active services ordered by menu order
    public function scopeActive($query)
    {
        return $query->where('status', 'active')->orderBy('menu_order');
    }

    // Scope: Get services for menu dropdown
    public function scopeForMenu($query)
    {
        return $query->active();
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
     * Get translated name
     *
     * @param string $language
     * @return string
     */
    public function getTranslatedName(string $language = 'en'): string
    {
        return $this->getTranslated('name', $language);
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
