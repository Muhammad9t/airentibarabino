<?php

namespace Database\Seeders\Services;

use Illuminate\Database\Seeder;
use App\Models\Service;
use App\Models\SubService;
use App\Services\TranslationService;
use Illuminate\Support\Str;

class PrivatiFamiglieServiceSeeder extends Seeder
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
            'name' => 'Privati e Famiglie',
            'description' => 'Servizi personalizzati per famiglie e privati in materia fiscale, immobiliare, patrimoniale e gestione del personale.',
            'menu_order' => 3,
            'sub_services' => [
                [
                    'title' => 'Dichiarazioni fiscali',
                    'points' => [
                        'Assistenza fiscale in materia di imposte dirette e indirette',
                        'Dichiarazioni dei redditi, dichiarazioni di successione',
                        'Assistenza fiscale per la proprietà e gestione di beni detenuti all\'estero da cittadini italiani (Quadro RW, Modello Reddito PF)',
                    ],
                    'sort_order' => 1,
                ],
                [
                    'title' => 'Gestione immobiliare',
                    'points' => [
                        'Consulenza sulla tassazione delle locazioni e delle vendite',
                        'Calcoli, dichiarazioni, pagamenti per le imposte locali (IMU, TASI)',
                        'Redazione e registrazione dei contratti di locazione',
                        'Calcolo delle imposte di registro e preparazione dei moduli di pagamento',
                        'Costituzione Società semplice',
                    ],
                    'sort_order' => 2,
                ],
                [
                    'title' => 'Gestione personale domestico',
                    'points' => [
                        'Contratti di lavoro',
                        'Cedolini paga',
                        'Dichiarazioni contributive',
                        'Gestione del personale',
                    ],
                    'sort_order' => 3,
                ],
                [
                    'title' => 'Pianificazione patrimoniale',
                    'points' => [
                        'Consulenza nella gestione e trasmissione dei beni in ambito successorio',
                        'Costituzione Società semplice',
                    ],
                    'sort_order' => 4,
                ],
                [
                    'title' => 'Intestazioni fiduciari',
                    'points' => [
                        'Airenti&Barabino si avvale di una società fiduciaria indipendente autorizzata ai sensi della Legge 23/11/1939 N.1966',
                    ],
                    'sort_order' => 5,
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
