<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SubService extends Model
{
    protected $fillable = [
        'service_id',
        'title',
        'title_translations',
        'points',
        'points_translations',
        'is_expanded',
        'sort_order',
        'status'
    ];

    protected $casts = [
        'points' => 'array',
        'title_translations' => 'array',
        'points_translations' => 'array',
        'is_expanded' => 'boolean',
        'sort_order' => 'integer',
    ];

    // Relationship: A sub-service belongs to a service
    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    // Helper method to get points as array
    public function getPointsArrayAttribute()
    {
        return $this->points ?? [];
    }

    // Helper method to add a point
    public function addPoint($point)
    {
        $points = $this->points ?? [];
        $points[] = $point;
        $this->points = $points;
        $this->save();
    }

    // Helper method to remove a point by index
    public function removePoint($index)
    {
        $points = $this->points ?? [];
        if (isset($points[$index])) {
            unset($points[$index]);
            $this->points = array_values($points); // Re-index array
            $this->save();
        }
    }

    // Helper method to update a point by index
    public function updatePoint($index, $point)
    {
        $points = $this->points ?? [];
        if (isset($points[$index])) {
            $points[$index] = $point;
            $this->points = $points;
            $this->save();
        }
    }

    /**
     * Get translated field value with fallback
     *
     * @param string $field
     * @param string $language
     * @return string|array
     */
    public function getTranslated(string $field, string $language = 'en')
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
        return $this->$field ?? ($field === 'points' ? [] : '');
    }

    /**
     * Get translated title
     *
     * @param string $language
     * @return string
     */
    public function getTranslatedTitle(string $language = 'en'): string
    {
        return $this->getTranslated('title', $language);
    }

    /**
     * Get translated points
     *
     * @param string $language
     * @return array
     */
    public function getTranslatedPoints(string $language = 'en'): array
    {
        return $this->getTranslated('points', $language);
    }
}