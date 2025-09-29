<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;
use App\Models\SubService;
use App\Services\TranslationService;
use Illuminate\Support\Str;

class SimpleServiceSeeder extends Seeder
{
    protected TranslationService $translationService;

    public function __construct(TranslationService $translationService)
    {
        $this->translationService = $translationService;
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing data (handle foreign key constraints)
        SubService::query()->delete();
        Service::query()->delete();

        $servicesData = [
            [
                'name' => "Per le Imprese",
                'sub_services' => [
                    "Legale",
                    "Consulenza Societaria e Contabile",
                    "Consulenza",
                    "Consulenza del Lavoro",
                ],
            ],
            [
                'name' => "Per l'Estero",
                'sub_services' => [
                    "Accoglienza di società estere",
                    "Assunzioni e verifiche legali",
                    "Consulenza per espatriati",
                    "Consulenza per l'apertura di una stabile organizzazione o filiale.",
                ],
            ],
            [
                'name' => "Per il Settore Non-profit",
                'sub_services' => [
                    "Gestione attività istituzionale",
                    "Gestione attività commerciale",
                    "Sport dilettantistico",
                    "Gestione compensi per attività",
                    "Contratti di lavoro",
                    "Consulenza Fiscale",
                    "Revisione Legale",
                ],
            ],
            [
                'name' => "Per Famiglie e Privati",
                'sub_services' => [
                    "Dichiarazioni dei Redditi",
                    "Gestione Immobiliare",
                    "Gestione del Personale Domestico",
                    "Sistemazioni Patrimoniali",
                    "Intestazioni Fiduciarie",
                ],
            ],
        ];

        foreach ($servicesData as $index => $serviceData) {
            // Generate slug from Italian name
            $slug = Str::slug($serviceData['name']);
            
            // Generate translations for service name
            $nameTranslations = $this->translationService->generateTranslations($serviceData['name'], 'it');
            
            // Generate description based on service name
            $description = "Servizi professionali per " . strtolower($serviceData['name']);
            $descriptionTranslations = $this->translationService->generateTranslations($description, 'it');
            
            // Create service
            $service = Service::create([
                'name' => $serviceData['name'],
                'name_translations' => $nameTranslations,
                'slug' => $slug,
                'description' => $description,
                'description_translations' => $descriptionTranslations,
                'menu_order' => $index + 1,
                'status' => 'active'
            ]);

            // Create sub-services for this service
            foreach ($serviceData['sub_services'] as $subIndex => $subServiceTitle) {
                // Generate translations for sub-service title
                $titleTranslations = $this->translationService->generateTranslations($subServiceTitle, 'it');
                
                SubService::create([
                    'service_id' => $service->id,
                    'title' => $subServiceTitle,
                    'title_translations' => $titleTranslations,
                    'points' => [],
                    'points_translations' => null,
                    'is_expanded' => false,
                    'sort_order' => $subIndex + 1,
                    'status' => 'active'
                ]);
            }
        }
    }
}