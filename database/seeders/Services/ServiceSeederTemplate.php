<?php

namespace Database\Seeders\Services;

use Illuminate\Database\Seeder;
use App\Models\Service;
use App\Models\SubService;
use App\Services\TranslationService;
use Illuminate\Support\Str;

/**
 * Template for creating new service seeders
 * 
 * To create a new service seeder:
 * 1. Copy this file and rename it to YourServiceNameSeeder.php
 * 2. Update the class name
 * 3. Fill in the service data
 * 4. Add the seeder to ServiceSeederFactory.php
 * 5. Add the service to the console command mapping
 */
class ServiceSeederTemplate extends Seeder
{
    protected TranslationService $translationService;

    public function __construct()
    {
        $this->translationService = app(TranslationService::class);
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $serviceData = [
            'name' => 'YOUR_SERVICE_NAME', // e.g., 'FAMILY', 'FOREIGN_COMPANIES'
            'description' => 'Your service description in Italian.',
            'menu_order' => 3, // Increment for each new service
            'sub_services' => [
                [
                    'title' => 'First Sub-Service Title',
                    'points' => [
                        'First point description',
                        'Second point description',
                        'Third point description',
                    ],
                    'sort_order' => 1,
                ],
                [
                    'title' => 'Second Sub-Service Title',
                    'points' => [
                        'First point description',
                        'Second point description',
                    ],
                    'sort_order' => 2,
                ],
                // Add more sub-services as needed
            ],
        ];

        $this->createService($serviceData);
    }

    /**
     * Create a service with its sub-services
     */
    private function createService(array $serviceData): void
    {
        // Generate slug from Italian name
        $slug = Str::slug($serviceData['name']);
        
        // Generate translations for service name
        $nameTranslations = $this->translationService->generateTranslations($serviceData['name'], 'it');
        
        // Generate translations for service description
        $descriptionTranslations = $this->translationService->generateTranslations($serviceData['description'], 'it');
        
        // Create or update service
        $service = Service::updateOrCreate(
            ['slug' => $slug],
            [
                'name' => $serviceData['name'],
                'name_translations' => $nameTranslations,
                'description' => $serviceData['description'],
                'description_translations' => $descriptionTranslations,
                'menu_order' => $serviceData['menu_order'],
                'status' => 'active'
            ]
        );

        // Create sub-services for this service
        foreach ($serviceData['sub_services'] as $subServiceData) {
            // Generate translations for sub-service title
            $titleTranslations = $this->translationService->generateTranslations($subServiceData['title'], 'it');
            
            // Generate translations for sub-service points
            $pointsTranslations = $this->translationService->generateArrayTranslations($subServiceData['points'], 'it');
            
            SubService::updateOrCreate(
                [
                    'service_id' => $service->id,
                    'sort_order' => $subServiceData['sort_order']
                ],
                [
                    'title' => $subServiceData['title'],
                    'title_translations' => $titleTranslations,
                    'points' => $subServiceData['points'],
                    'points_translations' => $pointsTranslations,
                    'is_expanded' => false,
                    'status' => 'active'
                ]
            );
        }
    }
}
