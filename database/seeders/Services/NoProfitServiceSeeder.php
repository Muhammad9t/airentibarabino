<?php

namespace Database\Seeders\Services;

use Illuminate\Database\Seeder;
use App\Models\Service;
use App\Models\SubService;
use App\Services\TranslationService;
use Illuminate\Support\Str;

class NoProfitServiceSeeder extends Seeder
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
            'name' => 'NO PROFIT',
            'description' => 'Servizi dedicati ad associazioni, fondazioni, enti del terzo settore e realtà sportive dilettantistiche.',
            'menu_order' => 2,
            'sub_services' => [
                [
                    'title' => 'Associazioni, ASD, Fondazioni, Enti del Terzo Settore ETS',
                    'points' => [
                        'Consulenza del lavoro ed elaborazione cedolini paga E poi:',
                    ],
                    'sort_order' => 1,
                ],
                [
                    'title' => 'Gestione attività istituzionale',
                    'points' => [
                        'Redazione e registrazione dello statuto',
                        'Corretta tenuta libri contabili',
                        'Bilancio annuale',
                    ],
                    'sort_order' => 2,
                ],
                [
                    'title' => 'Gestione attività commerciale',
                    'points' => [
                        'Gestion des affaires commerciales',
                    ],
                    'sort_order' => 3,
                ],
                [
                    'title' => 'Gestione compensi per attività sportiva dilettantistica',
                    'points' => [
                        'Redazione contratti di collaborazione',
                        'Ritenuta d\'acconto',
                        'Compilazione e invio telematico formulare 770',
                        'Tenuta libri contabili e fiscali',
                        'Regime fiscale di cui alla legge 398 del 1991',
                        'Tenuta contabilità e gestione delle relative scadenze periodiche',
                        'Tenuta libri contabili e fiscali',
                        'Compilazione e invio telematico dichiarazione Iva',
                        'Irap',
                    ],
                    'sort_order' => 4,
                ],
                [
                    'title' => 'Enti del terzo settore ETS',
                    'points' => [
                        'Redazione dello statuto',
                        'Iscrizione al RUNTS, richiesta di riconoscimento della personalità giuridica',
                        'Tenuta della contabilità',
                        'Dichiarazioni dei redditi IRAP ed IVA, Mod. 770',
                        'Redazione e deposito al RUNTS del bilancio (formato da stato patrimoniale, rendiconto gestionale, e relazione di missione), oppure del rendiconto di cassa ove applicabile',
                        'Scadenziario ed aggiornamento sulle novità legislative',
                    ],
                    'sort_order' => 5,
                ],
                [
                    'title' => 'Contenzioso tributario',
                    'points' => [
                        'Esame della contestazione',
                        'Assistenza in contraddittorio per la definizione con l\'Agenzia delle Entrate e altri Enti',
                        'Redazione Ricorsi presso Corte di Giustizia Tributaria (ex Commissione Tributaria)',
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
