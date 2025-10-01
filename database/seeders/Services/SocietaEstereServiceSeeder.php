<?php

namespace Database\Seeders\Services;

use Illuminate\Database\Seeder;
use App\Models\Service;
use App\Models\SubService;
use App\Services\TranslationService;
use Illuminate\Support\Str;

class SocietaEstereServiceSeeder extends Seeder
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
            'name' => 'Società Estere',
            'description' => 'Assistenza completa per società e investitori esteri che intendono operare o costituire attività in Italia.',
            'menu_order' => 4,
            'sub_services' => [
                [
                    'title' => 'Accoglienza di società e investitori esteri in Italia',
                    'points' => [
                        'Attribuzione del numero di identificazione IVA in Italia, per soggetti non residenti, per operare direttamente in Italia',
                        'Gestione della contabilità IVA e dei versamenti fiscali',
                        'Assistenza contabile e fiscale per la gestione di stabili organizzazioni in Italia di soggetti non residenti',
                        'Tenuta della contabilità e presentazione delle dichiarazioni fiscali',
                        'Assistenza e consulenza per la costituzione di società in Italia da parte di non residenti, domiciliazione della sede presso lo studio e assistenza completa',
                    ],
                    'sort_order' => 1,
                ]
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
