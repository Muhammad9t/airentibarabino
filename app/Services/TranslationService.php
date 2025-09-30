<?php

namespace App\Services;

use Statickidz\GoogleTranslate;
use Illuminate\Support\Facades\Log;

class TranslationService
{
    private GoogleTranslate $translator;
    private array $supportedLanguages = ['en', 'it', 'fr'];

    public function __construct()
    {
        $this->translator = new GoogleTranslate();
    }

    /**
     * Generate translations for all supported languages
     *
     * @param string $text The text to translate
     * @param string $sourceLanguage The source language (en, it, fr)
     * @return array JSON object with translations for all languages
     */
    public function generateTranslations(string $text, string $sourceLanguage = 'en'): array
    {
        if (empty(trim($text))) {
            return $this->getEmptyTranslations();
        }

        $translations = [];
        $translations[$sourceLanguage] = $text;

        // Try Google Translate first, fallback to manual translations
        foreach ($this->supportedLanguages as $targetLanguage) {
            if ($targetLanguage === $sourceLanguage) {
                continue;
            }

            try {
                $translatedText = $this->translator->translate($sourceLanguage, $targetLanguage, $text);
                $translations[$targetLanguage] = $translatedText;
                
                // Add a small delay to avoid rate limiting
                usleep(100000); // 0.1 second
            } catch (\Exception $e) {
                Log::warning("Translation failed for {$sourceLanguage} to {$targetLanguage}: " . $e->getMessage());
                // Use manual translation fallback
                $translations[$targetLanguage] = $this->getManualTranslation($text, $sourceLanguage, $targetLanguage);
            }
        }

        return $translations;
    }

    /**
     * Generate translations for an array of texts (like points)
     *
     * @param array $texts Array of texts to translate
     * @param string $sourceLanguage The source language
     * @return array JSON object with translations for all languages
     */
    public function generateArrayTranslations(array $texts, string $sourceLanguage = 'en'): array
    {
        if (empty($texts)) {
            return $this->getEmptyTranslations();
        }

        $translations = [];
        $translations[$sourceLanguage] = $texts;

        foreach ($this->supportedLanguages as $targetLanguage) {
            if ($targetLanguage === $sourceLanguage) {
                continue;
            }

            $translatedTexts = [];
            foreach ($texts as $text) {
                try {
                    $translatedText = $this->translator->translate($sourceLanguage, $targetLanguage, $text);
                    $translatedTexts[] = $translatedText;
                    
                    // Add a small delay to avoid rate limiting
                    usleep(100000); // 0.1 second
                } catch (\Exception $e) {
                    Log::warning("Array translation failed for {$sourceLanguage} to {$targetLanguage}: " . $e->getMessage());
                    // Use manual translation fallback
                    $translatedTexts[] = $this->getManualTranslation($text, $sourceLanguage, $targetLanguage);
                }
            }
            $translations[$targetLanguage] = $translatedTexts;
        }

        return $translations;
    }

    /**
     * Update existing translations with new content
     *
     * @param array $existingTranslations Current translations
     * @param string $text New text to translate
     * @param string $sourceLanguage Source language
     * @return array Updated translations
     */
    public function updateTranslations(array $existingTranslations, string $text, string $sourceLanguage = 'en'): array
    {
        $newTranslations = $this->generateTranslations($text, $sourceLanguage);
        
        // Merge with existing translations, keeping existing ones if new ones are empty
        foreach ($this->supportedLanguages as $lang) {
            if (isset($existingTranslations[$lang]) && !empty($existingTranslations[$lang])) {
                // Keep existing translation if new one is empty or same as source
                if (empty($newTranslations[$lang]) || $newTranslations[$lang] === $text) {
                    $newTranslations[$lang] = $existingTranslations[$lang];
                }
            }
        }

        return $newTranslations;
    }

    /**
     * Detect the language of the input text
     *
     * @param string $text
     * @return string Detected language code
     */
    public function detectLanguage(string $text): string
    {
        // Simple language detection based on common patterns
        $text = strtolower(trim($text));
        
        // Italian patterns
        if (preg_match('/\b(il|la|lo|gli|le|di|da|del|della|dei|delle|con|per|su|in|a|al|alla|ai|alle)\b/', $text)) {
            return 'it';
        }
        
        // French patterns
        if (preg_match('/\b(le|la|les|du|de|des|avec|pour|sur|dans|à|au|aux)\b/', $text)) {
            return 'fr';
        }
        
        // Default to English
        return 'en';
    }

    /**
     * Get empty translations structure
     *
     * @return array
     */
    private function getEmptyTranslations(): array
    {
        return [
            'en' => '',
            'it' => '',
            'fr' => ''
        ];
    }

    /**
     * Get manual translation fallback for common business terms
     *
     * @param string $text
     * @param string $sourceLanguage
     * @param string $targetLanguage
     * @return string
     */
    private function getManualTranslation(string $text, string $sourceLanguage, string $targetLanguage): string
    {
        // Manual translations for common Italian business terms
        $translations = [
            'it' => [
                'en' => [
                    'AZIENDE' => 'COMPANIES',
                    'NO PROFIT' => 'NON-PROFIT',
                    'Privati e Famiglie' => 'Individuals and Families',
                    'Società Estere' => 'Foreign Companies',
                    'Consulenza fiscale, societaria e di bilancio' => 'Tax, corporate and budget consultancy',
                    'Redazione del bilancio' => 'Budget drafting',
                    'Dichiarazioni dei Redditi' => 'Income tax returns',
                    'Consulenza per l\'avvio d\'impresa' => 'Business start-up consultancy',
                    'Consulenza societaria e operazioni straordinarie' => 'Corporate consultancy and extraordinary operations',
                    'Contenzioso tributario' => 'Tax litigation',
                    'Consulenza del lavoro' => 'Labor consultancy',
                    'Associazioni, ASD, Fondazioni, Enti del Terzo Settore ETS' => 'Associations, ASD, Foundations, Third Sector Entities ETS',
                    'Gestione attività istituzionale' => 'Institutional activity management',
                    'Gestione attività commerciale' => 'Commercial activity management',
                    'Gestione compensi per attività sportiva dilettantistica' => 'Management of compensation for amateur sports activities',
                    'Enti del terzo settore ETS' => 'Third sector entities ETS',
                    'Dichiarazioni fiscali' => 'Tax declarations',
                    'Gestione immobiliare' => 'Real estate management',
                    'Gestione personale domestico' => 'Domestic staff management',
                    'Pianificazione patrimoniale' => 'Wealth planning',
                    'Intestazioni fiduciari' => 'Fiduciary assignments',
                    'Accoglienza di società e investitori esteri in Italia' => 'Welcome of foreign companies and investors in Italy',
                    'Servizi professionali per aziende in materia fiscale, societaria, bilancio e consulenza del lavoro.' => 'Professional services for companies in tax, corporate, budget and labor consultancy matters.',
                    'Servizi dedicati ad associazioni, fondazioni, enti del terzo settore e realtà sportive dilettantistiche.' => 'Services dedicated to associations, foundations, third sector entities and amateur sports organizations.',
                    'Servizi personalizzati per famiglie e privati in materia fiscale, immobiliare, patrimoniale e gestione del personale.' => 'Personalized services for families and individuals in tax, real estate, wealth and personnel management matters.',
                    'Assistenza completa per società e investitori esteri che intendono operare o costituire attività in Italia.' => 'Complete assistance for foreign companies and investors who intend to operate or establish activities in Italy.',
                ],
                'fr' => [
                    'AZIENDE' => 'ENTREPRISES',
                    'NO PROFIT' => 'NON-LUCRATIF',
                    'Privati e Famiglie' => 'Particuliers et Familles',
                    'Società Estere' => 'Sociétés Étrangères',
                    'Consulenza fiscale, societaria e di bilancio' => 'Conseil fiscal, sociétaire et budgétaire',
                    'Redazione del bilancio' => 'Rédaction du budget',
                    'Dichiarazioni dei Redditi' => 'Déclarations de revenus',
                    'Consulenza per l\'avvio d\'impresa' => 'Conseil pour le démarrage d\'entreprise',
                    'Consulenza societaria e operazioni straordinarie' => 'Conseil sociétaire et opérations extraordinaires',
                    'Contenzioso tributario' => 'Contentieux fiscal',
                    'Consulenza del lavoro' => 'Conseil du travail',
                    'Associazioni, ASD, Fondazioni, Enti del Terzo Settore ETS' => 'Associations, ASD, Fondations, Entités du Tiers Secteur ETS',
                    'Gestione attività istituzionale' => 'Gestion des activités institutionnelles',
                    'Gestione attività commerciale' => 'Gestion des activités commerciales',
                    'Gestione compensi per attività sportiva dilettantistica' => 'Gestion des compensations pour activités sportives amateurs',
                    'Enti del terzo settore ETS' => 'Entités du tiers secteur ETS',
                    'Dichiarazioni fiscali' => 'Déclarations fiscales',
                    'Gestione immobiliare' => 'Gestion immobilière',
                    'Gestione personale domestico' => 'Gestion du personnel domestique',
                    'Pianificazione patrimoniale' => 'Planification patrimoniale',
                    'Intestazioni fiduciari' => 'Attributions fiduciaires',
                    'Accoglienza di società e investitori esteri in Italia' => 'Accueil de sociétés et investisseurs étrangers en Italie',
                    'Servizi professionali per aziende in materia fiscale, societaria, bilancio e consulenza del lavoro.' => 'Services professionnels pour les entreprises en matière fiscale, sociétaire, budgétaire et conseil du travail.',
                    'Servizi dedicati ad associazioni, fondazioni, enti del terzo settore e realtà sportive dilettantistiche.' => 'Services dédiés aux associations, fondations, entités du tiers secteur et organisations sportives amateurs.',
                    'Servizi personalizzati per famiglie e privati in materia fiscale, immobiliare, patrimoniale e gestione del personale.' => 'Services personnalisés pour les familles et particuliers en matière fiscale, immobilière, patrimoniale et gestion du personnel.',
                    'Assistenza completa per società e investitori esteri che intendono operare o costituire attività in Italia.' => 'Assistance complète pour les sociétés et investisseurs étrangers qui entendent opérer ou constituer des activités en Italie.',
                ]
            ]
        ];

        // Check if we have a manual translation
        if (isset($translations[$sourceLanguage][$targetLanguage][$text])) {
            return $translations[$sourceLanguage][$targetLanguage][$text];
        }

        // For points and other text, provide basic translations
        if ($sourceLanguage === 'it') {
            if ($targetLanguage === 'en') {
                // Basic Italian to English translations for common terms
                $basicTranslations = [
                    'Redazione dei verbali e tenuta dei libri sociali' => 'Drafting of minutes and keeping of corporate books',
                    'Aggiornamento periodico sulle novità legislative e calendario mensile' => 'Periodic updates on legislative news and monthly calendar',
                    'Riunioni e sessioni periodiche con il cliente, assistenza nella definizione delle strategie aziendali' => 'Periodic meetings and sessions with the client, assistance in defining business strategies',
                    'Meetings and periodic sessions with the client, assistance in defining business strategies' => 'Meetings and periodic sessions with the client, assistance in defining business strategies',
                    'Consulenza per ammortamenti, accantonamenti e valutazioni' => 'Consultancy for depreciation, provisions and valuations',
                    'Consulenza per la predisposizione e registrazione delle scritture di assestamento di fine anno' => 'Consultancy for the preparation and recording of year-end adjustment entries',
                    'Predisposizione del bilancio completo di nota integrativa riclassificata ai sensi del D.Lgs. 197/91 e successive, Relazione sulla gestione' => 'Preparation of the complete financial statement with reclassified explanatory notes pursuant to Legislative Decree 197/91 and subsequent, Management Report',
                    'Preparazione e invio telematico delle comunicazioni IVA, contatori di spesa, determinazione del reddito d\'impresa' => 'Preparation and electronic transmission of VAT communications, expense counters, determination of business income',
                    'Dichiarazione IVA annuale' => 'Annual VAT return',
                    'Preparazione e invio telematico del modello UNICO comprensivo di:' => 'Preparation and electronic transmission of the UNICO model including:',
                    'Dichiarazione dei redditi' => 'Income tax return',
                    'Dichiarazione IRAP' => 'IRAP return',
                    'Dichiarazione modello 770 per lavoratori autonomi' => 'Model 770 return for self-employed workers',
                    'Contabilità' => 'Accounting',
                    'Business plan e controllo di gestione' => 'Business plan and management control',
                    'Redazione del bilancio annuale' => 'Annual budget preparation',
                    'Bilanci' => 'Budgets',
                    'Redazione di statuti di società ed enti' => 'Drafting of company and entity statutes',
                    'Operazioni straordinarie (fusioni, scissioni, trasformazioni, ecc.)' => 'Extraordinary operations (mergers, splits, transformations, etc.)',
                    'Verbalizzazione delle assemblee e dei consigli di amministrazione' => 'Minutes of meetings and board of directors',
                    'Contrattualistica' => 'Contract law',
                    'Esame della contestazione' => 'Examination of the dispute',
                    'Assistenza in contraddittorio per la definizione con l\'Agenzia delle Entrate e altri Enti' => 'Assistance in adversarial proceedings for settlement with the Revenue Agency and other entities',
                    'Redazione Ricorsi presso Corte di Giustizia Tributaria (ex Commissione Tributaria)' => 'Drafting of appeals to the Tax Court (formerly Tax Commission)',
                    'Contratti di lavoro' => 'Employment contracts',
                    'Cedolini paga' => 'Pay slips',
                    'Dichiarazioni contributive' => 'Social security declarations',
                    'Gestione del personale, studio di forme di fringe benefit e welfare aziendale' => 'Personnel management, study of fringe benefit forms and corporate welfare',
                    'Consulenza del lavoro ed elaborazione cedolini paga E poi:' => 'Labor consultancy and pay slip preparation and then:',
                    'Redazione e registrazione dello statuto' => 'Drafting and registration of the statute',
                    'Corretta tenuta libri contabili' => 'Proper keeping of accounting books',
                    'Bilancio annuale' => 'Annual balance sheet',
                    'Gestion des affaires commerciales' => 'Management of commercial affairs',
                    'Redazione contratti di collaborazione' => 'Drafting of collaboration contracts',
                    'Ritenuta d\'acconto' => 'Withholding tax',
                    'Compilazione e invio telematico formulare 770' => 'Compilation and electronic submission of form 770',
                    'Tenuta libri contabili e fiscali' => 'Keeping of accounting and tax books',
                    'Regime fiscale di cui alla legge 398 del 1991' => 'Tax regime under law 398 of 1991',
                    'Tenuta contabilità e gestione delle relative scadenze periodiche' => 'Accounting and management of related periodic deadlines',
                    'Compilazione e invio telematico dichiarazione Iva' => 'Compilation and electronic submission of VAT declaration',
                    'Irap' => 'IRAP',
                    'Redazione dello statuto' => 'Drafting of the statute',
                    'Iscrizione al RUNTS, richiesta di riconoscimento della personalità giuridica' => 'Registration with RUNTS, request for recognition of legal personality',
                    'Tenuta della contabilità' => 'Keeping of accounting',
                    'Dichiarazioni dei redditi IRAP ed IVA, Mod. 770' => 'IRAP and VAT income declarations, Form 770',
                    'Redazione e deposito al RUNTS del bilancio (formato da stato patrimoniale, rendiconto gestionale, e relazione di missione), oppure del rendiconto di cassa ove applicabile' => 'Drafting and filing with RUNTS of the balance sheet (consisting of balance sheet, management report, and mission report), or cash report where applicable',
                    'Scadenziario ed aggiornamento sulle novità legislative' => 'Deadline calendar and updates on legislative news',
                    'Assistenza fiscale in materia di imposte dirette e indirette' => 'Tax assistance in direct and indirect taxes',
                    'Dichiarazioni dei redditi, dichiarazioni di successione' => 'Income tax returns, inheritance declarations',
                    'Assistenza fiscale per la proprietà e gestione di beni detenuti all\'estero da cittadini italiani (Quadro RW, Modello Reddito PF)' => 'Tax assistance for ownership and management of assets held abroad by Italian citizens (RW Form, PF Income Model)',
                    'Consulenza sulla tassazione delle locazioni e delle vendite' => 'Consultancy on taxation of rentals and sales',
                    'Calcoli, dichiarazioni, pagamenti per le imposte locali (IMU, TASI)' => 'Calculations, declarations, payments for local taxes (IMU, TASI)',
                    'Redazione e registrazione dei contratti di locazione' => 'Drafting and registration of rental contracts',
                    'Calcolo delle imposte di registro e preparazione dei moduli di pagamento' => 'Calculation of registration taxes and preparation of payment forms',
                    'Costituzione Società semplice' => 'Formation of Simple Company',
                    'Consulenza nella gestione e trasmissione dei beni in ambito successorio' => 'Consultancy in the management and transmission of assets in inheritance matters',
                    'Airenti&Barabino si avvale di una società fiduciaria indipendente autorizzata ai sensi della Legge 23/11/1939 N.1966' => 'Airenti&Barabino uses an independent fiduciary company authorized under Law 23/11/1939 N.1966',
                    'Attribuzione del numero di identificazione IVA in Italia, per soggetti non residenti, per operare direttamente in Italia' => 'Assignment of VAT identification number in Italy, for non-resident entities, to operate directly in Italy',
                    'Gestione della contabilità IVA e dei versamenti fiscali' => 'Management of VAT accounting and tax payments',
                    'Assistenza contabile e fiscale per la gestione di stabili organizzazioni in Italia di soggetti non residenti' => 'Accounting and tax assistance for the management of permanent establishments in Italy of non-resident entities',
                    'Tenuta della contabilità e presentazione delle dichiarazioni fiscali' => 'Keeping of accounting and presentation of tax declarations',
                    'Assistenza e consulenza per la costituzione di società in Italia da parte di non residenti, domiciliazione della sede presso lo studio e assistenza completa' => 'Assistance and consultancy for the incorporation of companies in Italy by non-residents, domiciliation of the registered office at the firm and complete assistance',
                ];

                if (isset($basicTranslations[$text])) {
                    return $basicTranslations[$text];
                }
            } elseif ($targetLanguage === 'fr') {
                // Basic Italian to French translations for common terms
                $basicTranslations = [
                    'Redazione dei verbali e tenuta dei libri sociali' => 'Rédaction des procès-verbaux et tenue des livres sociaux',
                    'Aggiornamento periodico sulle novità legislative e calendario mensile' => 'Mise à jour périodique sur les nouveautés législatives et calendrier mensuel',
                    'Riunioni e sessioni periodiche con il cliente, assistenza nella definizione delle strategie aziendali' => 'Réunions et sessions périodiques avec le client, assistance dans la définition des stratégies d\'entreprise',
                    'Meetings and periodic sessions with the client, assistance in defining business strategies' => 'Réunions et sessions périodiques avec le client, assistance dans la définition des stratégies d\'entreprise',
                    'Consulenza per ammortamenti, accantonamenti e valutazioni' => 'Conseil pour amortissements, provisions et évaluations',
                    'Consulenza per la predisposizione e registrazione delle scritture di assestamento di fine anno' => 'Conseil pour la préparation et l\'enregistrement des écritures de régularisation de fin d\'année',
                    'Predisposizione del bilancio completo di nota integrativa riclassificata ai sensi del D.Lgs. 197/91 e successive, Relazione sulla gestione' => 'Préparation du bilan complet avec note explicative reclassée selon le D.Lgs. 197/91 et suivants, Rapport de gestion',
                    'Preparazione e invio telematico delle comunicazioni IVA, contatori di spesa, determinazione del reddito d\'impresa' => 'Préparation et envoi électronique des communications TVA, compteurs de dépenses, détermination du revenu d\'entreprise',
                    'Dichiarazione IVA annuale' => 'Déclaration TVA annuelle',
                    'Preparazione e invio telematico del modello UNICO comprensivo di:' => 'Préparation et envoi électronique du modèle UNICO comprenant:',
                    'Dichiarazione dei redditi' => 'Déclaration de revenus',
                    'Dichiarazione IRAP' => 'Déclaration IRAP',
                    'Dichiarazione modello 770 per lavoratori autonomi' => 'Déclaration modèle 770 pour travailleurs indépendants',
                    'Contabilità' => 'Comptabilité',
                    'Business plan e controllo di gestione' => 'Plan d\'affaires et contrôle de gestion',
                    'Redazione del bilancio annuale' => 'Rédaction du bilan annuel',
                    'Bilanci' => 'Bilans',
                    'Redazione di statuti di società ed enti' => 'Rédaction de statuts de sociétés et entités',
                    'Operazioni straordinarie (fusioni, scissioni, trasformazioni, ecc.)' => 'Opérations extraordinaires (fusions, scissions, transformations, etc.)',
                    'Verbalizzazione delle assemblee e dei consigli di amministrazione' => 'Procès-verbaux des assemblées et conseils d\'administration',
                    'Contrattualistica' => 'Droit des contrats',
                    'Esame della contestazione' => 'Examen du litige',
                    'Assistenza in contraddittorio per la definizione con l\'Agenzia delle Entrate e altri Enti' => 'Assistance en procédure contradictoire pour le règlement avec l\'Agence des Revenus et autres entités',
                    'Redazione Ricorsi presso Corte di Giustizia Tributaria (ex Commissione Tributaria)' => 'Rédaction de recours auprès de la Cour de Justice Fiscale (ex Commission Fiscale)',
                    'Contratti di lavoro' => 'Contrats de travail',
                    'Cedolini paga' => 'Bulletins de paie',
                    'Dichiarazioni contributive' => 'Déclarations de cotisations',
                    'Gestione del personale, studio di forme di fringe benefit e welfare aziendale' => 'Gestion du personnel, étude des formes de prestations et bien-être d\'entreprise',
                    'Consulenza del lavoro ed elaborazione cedolini paga E poi:' => 'Conseil du travail et élaboration des bulletins de paie et puis:',
                    'Redazione e registrazione dello statuto' => 'Rédaction et enregistrement des statuts',
                    'Corretta tenuta libri contabili' => 'Tenue correcte des livres comptables',
                    'Bilancio annuale' => 'Bilan annuel',
                    'Gestion des affaires commerciales' => 'Gestion des affaires commerciales',
                    'Redazione contratti di collaborazione' => 'Rédaction de contrats de collaboration',
                    'Ritenuta d\'acconto' => 'Retenue d\'acompte',
                    'Compilazione e invio telematico formulare 770' => 'Compilation et envoi électronique du formulaire 770',
                    'Tenuta libri contabili e fiscali' => 'Tenue des livres comptables et fiscaux',
                    'Regime fiscale di cui alla legge 398 del 1991' => 'Régime fiscal prévu par la loi 398 de 1991',
                    'Tenuta contabilità e gestione delle relative scadenze periodiche' => 'Tenue de la comptabilité et gestion des échéances périodiques correspondantes',
                    'Compilazione e invio telematico dichiarazione Iva' => 'Compilation et envoi électronique de la déclaration TVA',
                    'Irap' => 'IRAP',
                    'Redazione dello statuto' => 'Rédaction des statuts',
                    'Iscrizione al RUNTS, richiesta di riconoscimento della personalità giuridica' => 'Inscription au RUNTS, demande de reconnaissance de la personnalité juridique',
                    'Tenuta della contabilità' => 'Tenue de la comptabilité',
                    'Dichiarazioni dei redditi IRAP ed IVA, Mod. 770' => 'Déclarations de revenus IRAP et TVA, Mod. 770',
                    'Redazione e deposito al RUNTS del bilancio (formato da stato patrimoniale, rendiconto gestionale, e relazione di missione), oppure del rendiconto di cassa ove applicabile' => 'Rédaction et dépôt au RUNTS du bilan (composé du bilan, du compte de gestion, et du rapport de mission), ou du compte de caisse le cas échéant',
                    'Scadenziario ed aggiornamento sulle novità legislative' => 'Calendrier des échéances et mise à jour sur les nouveautés législatives',
                    'Assistenza fiscale in materia di imposte dirette e indirette' => 'Assistance fiscale en matière d\'impôts directs et indirects',
                    'Dichiarazioni dei redditi, dichiarazioni di successione' => 'Déclarations de revenus, déclarations de succession',
                    'Assistenza fiscale per la proprietà e gestione di beni detenuti all\'estero da cittadini italiani (Quadro RW, Modello Reddito PF)' => 'Assistance fiscale pour la propriété et gestion de biens détenus à l\'étranger par des citoyens italiens (Formulaire RW, Modèle Revenus PF)',
                    'Consulenza sulla tassazione delle locazioni e delle vendite' => 'Conseil sur la fiscalité des locations et des ventes',
                    'Calcoli, dichiarazioni, pagamenti per le imposte locali (IMU, TASI)' => 'Calculs, déclarations, paiements pour les impôts locaux (IMU, TASI)',
                    'Redazione e registrazione dei contratti di locazione' => 'Rédaction et enregistrement des contrats de location',
                    'Calcolo delle imposte di registro e preparazione dei moduli di pagamento' => 'Calcul des droits d\'enregistrement et préparation des formulaires de paiement',
                    'Costituzione Società semplice' => 'Constitution de Société simple',
                    'Consulenza nella gestione e trasmissione dei beni in ambito successorio' => 'Conseil dans la gestion et transmission des biens dans le domaine successoral',
                    'Airenti&Barabino si avvale di una società fiduciaria indipendente autorizzata ai sensi della Legge 23/11/1939 N.1966' => 'Airenti&Barabino utilise une société fiduciaire indépendante autorisée selon la Loi 23/11/1939 N.1966',
                    'Attribuzione del numero di identificazione IVA in Italia, per soggetti non residenti, per operare direttamente in Italia' => 'Attribution du numéro d\'identification TVA en Italie, pour les entités non résidentes, pour opérer directement en Italie',
                    'Gestione della contabilità IVA e dei versamenti fiscali' => 'Gestion de la comptabilité TVA et des paiements fiscaux',
                    'Assistenza contabile e fiscale per la gestione di stabili organizzazioni in Italia di soggetti non residenti' => 'Assistance comptable et fiscale pour la gestion d\'établissements stables en Italie d\'entités non résidentes',
                    'Tenuta della contabilità e presentazione delle dichiarazioni fiscali' => 'Tenue de la comptabilité et présentation des déclarations fiscales',
                    'Assistenza e consulenza per la costituzione di società in Italia da parte di non residenti, domiciliazione della sede presso lo studio e assistenza completa' => 'Assistance et conseil pour la constitution de sociétés en Italie par des non-résidents, domiciliation du siège social au cabinet et assistance complète',
                ];

                if (isset($basicTranslations[$text])) {
                    return $basicTranslations[$text];
                }
            }
        }

        // If no manual translation found, return original text
        return $text;
    }

    /**
     * Get supported languages
     *
     * @return array
     */
    public function getSupportedLanguages(): array
    {
        return $this->supportedLanguages;
    }

    /**
     * Validate language code
     *
     * @param string $language
     * @return bool
     */
    public function isValidLanguage(string $language): bool
    {
        return in_array($language, $this->supportedLanguages);
    }
}
