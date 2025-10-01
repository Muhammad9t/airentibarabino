<?php

namespace Database\Seeders\Services;

use Illuminate\Database\Seeder;
use App\Models\Service;
use App\Models\SubService;
use App\Services\TranslationService;
use Illuminate\Support\Str;

class AziendeServiceSeeder extends Seeder
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
            'name' => 'AZIENDE',
            'description' => 'Servizi professionali per aziende in materia fiscale, societaria, bilancio e consulenza del lavoro.',
            'menu_order' => 1,
            'sub_services' => [
                [
                    'title' => 'Consulenza fiscale, societaria e di bilancio',
                    'points' => [
                        'Redazione dei verbali e tenuta dei libri sociali',
                        'Aggiornamento periodico sulle novità legislative e calendario mensile',
                        'Riunioni e sessioni periodiche con il cliente, assistenza nella definizione delle strategie aziendali',
                        'Incontri e sessioni periodiche con il cliente, assistenza nella definizione delle strategie aziendali',
                    ],
                    'sort_order' => 1,
                ],
                [
                    'title' => 'Redazione del bilancio',
                    'points' => [
                        'Consulenza per ammortamenti, accantonamenti e valutazioni',
                        'Consulenza per la predisposizione e registrazione delle scritture di assestamento di fine anno',
                        'Predisposizione del bilancio completo di nota integrativa riclassificata ai sensi del D.Lgs. 197/91 e successive, Relazione sulla gestione',
                    ],
                    'sort_order' => 2,
                ],
                [
                    'title' => 'Dichiarazioni dei Redditi',
                    'points' => [
                        'Preparazione e invio telematico delle comunicazioni IVA, contatori di spesa, determinazione del reddito d\'impresa',
                        'Dichiarazione IVA annuale',
                        'Preparazione e invio telematico del modello UNICO comprensivo di:',
                        'Dichiarazione dei redditi',
                        'Dichiarazione IRAP',
                        'Dichiarazione modello 770 per lavoratori autonomi',
                    ],
                    'sort_order' => 3,
                ],
                [
                    'title' => 'Consulenza per l\'avvio d\'impresa',
                    'points' => [
                        'Contabilità',
                        'Business plan e controllo di gestione',
                        'Redazione del bilancio annuale',
                        'Bilanci',
                    ],
                    'sort_order' => 4,
                ],
                [
                    'title' => 'Consulenza societaria e operazioni straordinarie',
                    'points' => [
                        'Redazione di statuti di società ed enti',
                        'Operazioni straordinarie (fusioni, scissioni, trasformazioni, ecc.)',
                        'Verbalizzazione delle assemblee e dei consigli di amministrazione',
                        'Contrattualistica',
                    ],
                    'sort_order' => 5,
                ],
                [
                    'title' => 'Consulenza del lavoro',
                    'points' => [
                        'Contratti di lavoro',
                        'Cedolini paga',
                        'Dichiarazioni contributive',
                        'Gestione del personale, studio di forme di fringe benefit e welfare aziendale',
                    ],
                    'sort_order' => 6,
                ],
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
