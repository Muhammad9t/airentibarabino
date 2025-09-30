<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Blog;
use App\Services\TranslationService;
use Illuminate\Support\Str;

class BlogSeeder extends Seeder
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
        // Clear existing blogs
        Blog::query()->delete();

        $blogsData = [
            [
                'title' => 'Nuove Normative Fiscali 2025: Cosa Cambia per le Imprese',
                'description' => '<p>Il 2025 porta con sé importanti novità nel panorama fiscale italiano. Le nuove normative introdotte dal governo avranno un impatto significativo sulle imprese di tutte le dimensioni.</p>

<p><strong>Principali cambiamenti:</strong></p>
<ul>
<li>Riduzione dell\'aliquota IRES dal 24% al 22%</li>
<li>Nuove agevolazioni per investimenti in ricerca e sviluppo</li>
<li>Modifiche al regime forfettario per le partite IVA</li>
<li>Nuove disposizioni per la digitalizzazione fiscale</li>
</ul>

<p>Le nostre consulenze specializzate vi aiuteranno a navigare questi cambiamenti e ottimizzare la vostra strategia fiscale.</p>',
                'image' => '/images/resources/_DSC5173.jpg'
            ],
            [
                'title' => 'Consulenza per l\'Internazionalizzazione: Opportunità e Sfide',
                'description' => '<p>L\'espansione internazionale rappresenta una grande opportunità per le imprese italiane, ma richiede una preparazione accurata e una conoscenza approfondita dei mercati esteri.</p>

<p><strong>I nostri servizi includono:</strong></p>
<ul>
<li>Analisi di mercato e studio di fattibilità</li>
<li>Assistenza nella costituzione di società all\'estero</li>
<li>Consulenza fiscale internazionale</li>
<li>Supporto per l\'ottenimento di visti e permessi di lavoro</li>
</ul>

<p>Con la nostra esperienza pluriennale, vi accompagniamo in ogni fase del processo di internazionalizzazione.</p>',
                'image' => '/images/resources/_DSC5173.jpg'
            ],
            [
                'title' => 'Gestione del Personale Domestico: Guida Completa',
                'description' => '<p>La gestione del personale domestico richiede attenzione particolare alle normative del lavoro e agli obblighi contributivi. Una gestione corretta evita sanzioni e garantisce i diritti dei lavoratori.</p>

<p><strong>Aspetti da considerare:</strong></p>
<ul>
<li>Contratti di lavoro e tipologie di rapporto</li>
<li>Calcolo e versamento dei contributi INPS</li>
<li>Gestione delle ferie e permessi</li>
<li>Obblighi di sicurezza sul lavoro</li>
</ul>

<p>Il nostro team di esperti vi fornisce supporto completo per una gestione conforme e senza rischi.</p>',
                'image' => '/images/resources/_DSC5173.jpg'
            ]
        ];

        foreach ($blogsData as $index => $blogData) {
            $slug = Str::slug($blogData['title']);
            $descriptionTranslations = $this->translationService->generateTranslations($blogData['description'], 'it');
            
            Blog::create([
                'title' => $blogData['title'],
                'slug' => $slug,
                'description' => $blogData['description'],
                'description_translations' => $descriptionTranslations,
                'image' => $blogData['image'],
                'status' => 'active',
                'created_at' => now()->subDays($index * 7), // Spread creation dates
                'updated_at' => now()->subDays($index * 7),
            ]);
        }
    }
}
