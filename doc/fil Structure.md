Projet : COLOC
Framework : CodeIgniter 4
Objectif : migration progressive depuis ancien projet
Architecture cible :
- CI4 propre
- spark serve
- architecture domaine
- services/repositories
- installation novice-friendly

Règles :
- conserver les briques existantes
- migration domaine par domaine
- éviter les réécritures massives
- documenter chaque étape

CONTEXTE
Migration du domaine Import vers nouveau CI4

OBJECTIF
Partir d'une installation vierge
Migrer la page d'accueil
Documenter l'installation pour novices win/mac

CONTRAINTES
- conserver tables existantes
- compatible COPAINS
- éviter régression

ÉTAT ACTUEL
Import fonctionne dans legacy

RISQUES
Couplage session + compétition active

Domain/
└── Competition/
    ├── DTO/
    ├── Infrastructure/
    ├── Logging/
    ├── Models/
    ├── Repositories/
    └── Runtime/
        ├── ActivationCompetitionService
        └── RuntimeService

    [Service] Action | key=value | key=value

        log_message(
            'info',
            sprintf(
                '[ActivationCompetitionService] Competition activated | code=%s | title=%s',
                $competition->code,
                $competition->title
            )
        );





        FIL STRUCTURE

COLOC NEXT
- CI4
- Namespace officiel : App\Domain\
- Runtime centralisé
- RuntimeService = source runtime
- ADR-018 logs obligatoires
- Writable-first avec fallback legacy

