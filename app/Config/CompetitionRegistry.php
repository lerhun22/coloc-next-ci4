<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

/**
 * ============================================================
 * CompetitionRegistry
 * ============================================================
 * Source de vérité métier FPF (COLOC)
 *
 * RESPONSABILITÉS :
 * - règles métier FPF
 * - hiérarchie des compétitions
 * - workflow de jugement
 * - règles analytics
 * - invariants métier
 * - projection / classement
 *
 * NE CONTIENT PAS :
 * - endpoints HTTP
 * - URLs API
 * - credentials
 * - logique transport
 *
 * COPAIN :
 * - source officielle FPF
 *
 * COLOC :
 * - couche de service métier
 * - projection
 * - analytics
 * - outils clubs / auteurs / juges
 *
 * ============================================================
 * Version : 2026
 * ============================================================
 */

class CompetitionRegistry extends BaseConfig
{
    /**
     * ============================================================
     * DOMAIN
     * ============================================================
     * Invariants métier officiels
     * ============================================================
     */

    public array $domain = [

        /*
        ============================================================
        SOURCE OF TRUTH
        ============================================================
        */

        'source_of_truth' => [

            'system' => 'COPAIN',

            'description' =>
            'COPAIN est la source officielle des compétitions, notes et classements.',

            'official_results_are_readonly' => true,

            'coloc_role' => [
                'projection',
                'judging',
                'analytics',
                'club_tools',
                'author_tools',
                'regional_tools',
            ],
        ],

        /*
        ============================================================
        ENTITÉS MÉTIER
        ============================================================
        */

        'entities' => [

            /*
            --------------------------------------------------------
            PARTICIPATION
            --------------------------------------------------------
            Une participation représente :
            - une photo
            - dans une compétition
            --------------------------------------------------------
            */

            'participation' => [

                'description' =>
                'Une photo engagée dans une compétition',

                'invariant' =>
                'Une participation est définie par une photo dans une compétition',

                'unique_key' => [
                    'ean',
                    'competition_id',
                ],
            ],

            'photo' => [
                'identifier' => 'ean',
            ],

            'competition' => [
                'identifier' => 'competition_id',
            ],

            'author' => [
                'identifier' => 'participants_id',
            ],

            'club' => [
                'identifier' => 'club_id',
            ],
        ],

        /*
        ============================================================
        JUDGING
        ============================================================
        */

        'judging' => [

            'judges_per_competition' => [

                'min' => 1,

                'max' => null,
            ],

            'score_source' => 'note_totale',

            'score_normalization' => [

                'enabled' => true,

                'method' => 'mean_score',
            ],

            'not_judged_value' => 0,
        ],

        /*
        ============================================================
        RANKING
        ============================================================
        */

        'ranking' => [

            /*
            --------------------------------------------------------
            Une photo gagne une compétition
            --------------------------------------------------------
            */

            'photo_wins_competition' => true,

            /*
            --------------------------------------------------------
            PODIUM
            --------------------------------------------------------
            */

            'podium' => [

                'size' => 3,

                'based_on' => 'photo_rank',
            ],

            /*
            --------------------------------------------------------
            STRIKE
            --------------------------------------------------------
            Auteur plaçant au moins 3 photos
            dans les 5 premières.
            --------------------------------------------------------
            */

            'strike' => [

                'enabled' => true,

                'rule' => [

                    'top_limit' => 5,

                    'min_photos' => 3,
                ],
            ],
        ],
    ];

    /**
     * ============================================================
     * ARCHITECTURE
     * ============================================================
     * Documentation exécutable des tables
     * ============================================================
     */

    public array $architecture = [

        'roles' => [

            'source' =>
            'Données brutes importées',

            'normalized_business' =>
            'Données normalisées selon la logique métier',

            'materialized_business_view' =>
            'Vue matérialisée optimisée métier',

            'analytics' =>
            'Statistiques et analyses',

            'season_cache' =>
            'Cache calculé saisonnier',
        ],

        'tables' => [

            'competitions' => [

                'role' => 'source',

                'description' =>
                'Données FPF brutes',
            ],

            'competition_meta' => [

                'role' => 'normalized_business',

                'description' =>
                'Normalisation métier stable',
            ],

            'competitions_enriched' => [

                'role' => 'materialized_business_view',

                'description' =>
                'Projection métier enrichie',
            ],

            'competition_metrics' => [

                'role' => 'analytics',

                'description' =>
                'Statistiques calculées',
            ],

            'competition_quotas' => [

                'role' => 'season_cache',

                'description' =>
                'Quotas calculés par UR',
            ],
        ],
    ];

    /**
     * ============================================================
     * LEVELS
     * ============================================================
     * Hiérarchie officielle FPF
     * ============================================================
     */

    public array $levels = [

        /*
        ============================================================
        REGIONAL
        ============================================================
        */

        'REGIONAL' => [

            'label' => 'Régional',

            'category' => 'regional',

            'ranking_scope' => 'UR',

            'access' => 'selection_regional',

            'has_progression' => true,

            'uses_quotas' => true,

            'analytics_weight' => 1,

            'workflow' => [

                'uses_projection_order' => true,

                'uses_entry_order' => true,
            ],

            'photos_retained' => null,
        ],

        /*
        ============================================================
        N2
        ============================================================
        */

        'N2' => [

            'label' => 'National 2',

            'category' => 'national',

            'ranking_scope' => 'FRANCE',

            'access' => 'selection_regional',

            'has_progression' => true,

            'analytics_weight' => 2,

            'uses_quotas' => false,

            'photos_retained' => 6,

            'photos_max' => 6,

            'promotion' => [

                'to' => 'N1',

                'top' => 18,
            ],
        ],

        /*
        ============================================================
        N1
        ============================================================
        */

        'N1' => [

            'label' => 'National 1',

            'category' => 'national_elite',

            'ranking_scope' => 'FRANCE',

            'access' => 'selection_national',

            'has_progression' => true,

            'analytics_weight' => 3,

            'uses_quotas' => false,

            'photos_retained' => 15,

            'photos_max' => 18,

            'promotion' => [

                'to' => 'CDF',

                'top' => 12,
            ],

            'relegation' => [

                'to' => 'REGIONAL',

                'from' => 33,
            ],
        ],

        /*
        ============================================================
        CDF
        ============================================================
        */

        'CDF' => [

            'label' => 'Coupe de France',

            'category' => 'elite',

            'ranking_scope' => 'FRANCE',

            'access' => 'selection_national',

            'has_progression' => true,

            'is_elite' => true,

            'analytics_weight' => 5,

            'uses_quotas' => false,

            'photos_retained' => 25,

            'photos_max' => 28,

            'relegation' => [

                'to' => 'N1',

                'from' => 21,
            ],
        ],

        /*
        ============================================================
        DIRECT
        ============================================================
        */

        'DIRECT' => [

            'label' => 'Accès direct',

            'category' => 'direct',

            'ranking_scope' => 'FRANCE',

            'access' => 'direct',

            'has_progression' => false,

            'analytics_weight' => 1,
        ],
    ];


    public array $legacy = [

        'competition_types' => [

            1 => 'REGIONAL',

            2 => 'N1',

            3 => 'CDF',
        ],
    ];


    /**
     * ============================================================
     * DISCIPLINES
     * ============================================================
     */

    public array $disciplines = [

        'MONOCHROME' => [

            'participants' => 'club',

            'supports' => [
                'PAPIER',
                'IP',
            ],
        ],

        'COULEUR' => [

            'participants' => 'club',

            'supports' => [
                'PAPIER',
                'IP',
            ],
        ],

        'NATURE' => [

            'participants' => 'club',

            'supports' => [
                'PAPIER',
                'IP',
            ],
        ],

        'AUTEUR' => [

            'participants' => 'author',

            'supports' => [
                'PAPIER',
            ],
        ],

        'QUADRIMAGE' => [

            'participants' => 'club',

            'supports' => [
                'IP',
            ],

            'levels' => [
                'REGIONAL',
                'N2',
            ],
        ],

        'REPORTAGE' => [

            'participants' => 'author',

            'supports' => [
                'PAPIER',
            ],

            'levels' => [
                'DIRECT',
            ],
        ],

        'LIVRE' => [

            'participants' => 'author',

            'supports' => [
                'PAPIER',
            ],

            'levels' => [
                'DIRECT',
            ],
        ],

        'SUPER_CHALLENGE' => [

            'participants' => 'author',

            'supports' => [
                'IP',
            ],

            'levels' => [
                'DIRECT',
            ],
        ],
    ];

    /**
     * ============================================================
     * RULES
     * ============================================================
     * Workflow global
     * ============================================================
     */

    public array $rules = [

        /*
        ============================================================
        TIE BREAK
        ============================================================
        */

        'tie_break' => [

            'criteria' => [
                'score',
                'nb_20',
                'nb_19',
            ],

            'max_clubs' => 3,
        ],

        /*
        ============================================================
        QUOTAS
        ============================================================
        */

        'quotas' => [

            'formula' =>
            '(total_photos / total_clubs) * region_clubs',
        ],

        /*
        ============================================================
        WORKFLOW
        ============================================================
        */

        'workflow' => [

            /*
            --------------------------------------------------------
            Projection / slideshow
            --------------------------------------------------------
            */

            'projection_order_field' => 'passage',

            /*
            --------------------------------------------------------
            Ordre administratif / import
            --------------------------------------------------------
            */

            'entry_order_field' => 'saisie',
        ],
    ];

    /**
     * ============================================================
     * SCORING
     * ============================================================
     * Moteur de calcul
     * ============================================================
     */

    public array $scoring = [

        /*
        ============================================================
        UNITÉ
        ============================================================
        */

        'unit' => 'participation',

        /*
        ============================================================
        DÉDUPLICATION
        ============================================================
        */

        'dedup_key' => [

            'ean',
            'competition_id',
        ],

        'dedup_strategy' => 'max_points',

        /*
        ============================================================
        POINTS
        ============================================================
        */

        'points' => [

            'source' => 'note_totale',

            'normalization' => 'mean_score',

            'judges_default' => 3,
        ],

        /*
        ============================================================
        AGRÉGATION
        ============================================================
        */

        'aggregation' => [

            'mode' => 'cumulative',

            'group_by' => 'club',
        ],

        /*
        ============================================================
        SOURCE UR
        ============================================================
        */

        'ur_source' => 'participant',

        /*
        ============================================================
        FILTRES
        ============================================================
        */

        'filters' => [

            'exclude_disqualified' => true,

            'exclude_zero' => false,
        ],

        /*
        ============================================================
        JUDGING
        ============================================================
        */

        'judging' => [

            'source' => 'note_totale',

            'special_values' => [

                'not_judged' => 0,
            ],

            /*
            --------------------------------------------------------
            Distinctions
            --------------------------------------------------------
            */

            'medals' => [

                '20' => 18,

                '19' => 17,
            ],

            /*
            --------------------------------------------------------
            Histogrammes / analytics
            --------------------------------------------------------
            */

            'score_ranges' => [

                'low' => [

                    'min' => 6,

                    'max' => 10,
                ],

                'medium' => [

                    'min' => 11,

                    'max' => 15,
                ],

                'high' => [

                    'min' => 16,

                    'max' => 18,
                ],
            ],
        ],
    ];

    /**
     * ============================================================
     * BUSINESS
     * ============================================================
     * Règles métier clubs / UR
     * ============================================================
     */

    public array $business = [

        /*
        ============================================================
        PARTICIPANTS
        ============================================================
        */

        'participants' => [

            'club_only' => true,

            'exclude_individual' => true,

            'individual_condition' => [

                'club_id' => 0,
            ],
        ],

        /*
        ============================================================
        CLUB
        ============================================================
        */

        'club' => [

            'source' => 'clubs_table',

            'id_field' => 'club_id',

            'label_field' => 'club_nom',

            'exclude_invalid' => true,
        ],

        /*
        ============================================================
        DÉDUPLICATION
        ============================================================
        */

        'dedup' => [

            'key' => [
                'ean',
                'competition_id',
            ],

            'strategy' => 'max',
        ],

        /*
        ============================================================
        UR
        ============================================================
        */

        'ur' => [

            'source_priority' => [
                'club',
                'participant',
            ],

            'field' => 'ur',
        ],

        /*
        ============================================================
        FILTRES
        ============================================================
        */

        'filters' => [

            'exclude_disqualified' => true,

            'require_club' => true,
        ],
    ];

    /**
     * ============================================================
     * INTEGRATION
     * ============================================================
     * Synchronisation systèmes externes
     * ============================================================
     */

    public array $integration = [

        'official_source' => 'COPAIN',

        'sync_mode' => 'readonly',

        'import_strategy' => 'external_sync',
    ];

    /**
     * ============================================================
     * HELPERS
     * ============================================================
     */

    public function isElite(string $level): bool
    {
        return ($this->levels[$level]['is_elite'] ?? false) === true;
    }

    public function getProjectionField(): string
    {
        return $this->rules['workflow']['projection_order_field'];
    }

    public function getEntryField(): string
    {
        return $this->rules['workflow']['entry_order_field'];
    }

    public function getParticipationKey(): array
    {
        return $this->domain['entities']['participation']['unique_key'];
    }
}
