ADR-001 spark serve
ADR-002 no mandatory virtualhost
ADR-003 domain architecture
ADR-004 local sync first
ADR-005 app/conf/Copain.php
ADR-005 Source metier centrale app/conf/CompetitionsRegistry.php
ADR-006 tables séparées en 3 goupes data brutesvs enrichies - brute(competition,photo,notes) normalisée (compettioin-meta) dérivés (_enriched, _metrice_quotas)
ADR-007 projection vs Saisie (passage)
ADR-008 CDF Partout pour Coupe de France
ADR-009 La sessiion ne stocke que activeCompetitionId jamais package,chemeins, images, objets metier (domains)
ADR-010 tous les chemeins filesystem passent pas PathsService INTERDIR ROOTPATH . ' ...'
ADR-011 Les controlleurs ne parlent jamais SQL TOUJOURS Service/Repository/Model
ADR-012 Les services runtime  PAS DE SAL COMPLEXE / PAS DE VUES / PAS HTML
ADR-013 STOCKAGE UNIQUE RUNTIME writable/competitions/{package}/images/
ADR-014 RUNTIME architecture
ADR-015 Domain et non pas Domains
ADR-016 Competiton Code enregistré dans competition-meta au moment de l'importation
ADR-017 DIRECT = N
ADR-018 log_message de la forme [Service] Action | key=value | key=value à chaque étape du process   
ex : DEBUG - 2026-05-10 15:53:29 --> [RuntimeService] Active competition loaded | code=2020_N_293_00_0099 | title=TEST NATIONAL C
ADR-019 domain architecture
ADR-020 local sync firest
ADR-019 configuration metier centrale
ADR-020 séparation tables brutes enrichies
ADR-021 Runtime competitiion activation - Le Runtime deviendra ensuite : source unique de compétition active , point central slideshow , activeSession , UI runtime , debug production
ADR-022 Runtime session architecture
ADR-023 Runtime Image Flow : writable first,fallback legcy
ADR-024 Runtime Orchestration  : runtime unique orchestration active séparation runtime/UI services autorisés
ADR-025 Slideshow Runtime projection découplée / slideshow state / runtime slideshow flow
ADR-026 INTERDIRE ROOTPATH et FCPATH hors bootstrap/config/path services



# ADR-001 — Utiliser `spark serve` comme runtime local officiel

## Statut

Accepté

## Décision

Le développement local standard de COLOC NEXT utilise :

```bash id="jlwms4"
php spark serve
```

## Motivation

* environnement identique Win/Mac
* suppression dépendance Apache complexe
* onboarding simplifié
* moins de problèmes `.htaccess`
* compatible CI4 natif

---

# ADR-002 — Aucun VirtualHost obligatoire

## Statut

Accepté

## Décision

COLOC NEXT doit fonctionner sans configuration Apache spécifique.

## Motivation

* installation novice-friendly
* simplification support utilisateur
* compatibilité MAMP/XAMPP/WAMP

---

# ADR-003 — Architecture Domain-Driven progressive

## Statut

Accepté

## Décision

Le projet migre progressivement vers :

```text id="jlwmb1"
app/Domain/
```

## Motivation

* migration domaine par domaine
* réduction régressions
* découplage legacy/runtime

---

# ADR-004 — Local Sync First

## Statut

Accepté

## Décision

Le runtime local est prioritaire avant :

* cloud
* sync distante
* multi-user

## Motivation

* stabiliser le runtime
* simplifier debugging
* réduire dépendances externes

---

# ADR-005 — `app/Config/Copain.php` conservé

## Statut

Accepté

## Décision

La compatibilité COPAIN reste maintenue via :

```text id="jlwmu8"
app/Config/Copain.php
```

## Motivation

* compatibilité historique
* migration progressive
* éviter régression fédération

---

# ADR-006 — Source métier centrale : `CompetitionRegistry`

## Statut

Accepté

## Décision

Le mapping métier compétition centralisé reste :

```text id="jlwms9"
app/Config/CompetitionRegistry.php
```

## Responsabilités

* mappings métier
* règles legacy
* capabilities compétition
* normalisation métier

## Interdits

* SQL
* session
* filesystem
* runtime actif

---

# ADR-007 — Tables séparées en 3 groupes

## Statut

Accepté

## Décision

### Données brutes

```text id="jlwmd1"
competitions
photos
notes
```

---

### Données normalisées

```text id="jlwmbm"
competition_meta
```

---

### Données dérivées

```text id="jlwmu7"
*_enriched
*_metrics
*_quotas
```

## Motivation

* séparation responsabilités
* pipeline analytique
* éviter pollution métier

---

# ADR-008 — Projection séparée de la saisie

## Statut

Accepté

## Décision

Les écrans :

* projection
* slideshow
* diffusion

sont séparés de :

* saisie
* jugement
* notation

## Motivation

* réduction couplage UI
* stabilité projection
* évolution indépendante

---

# ADR-009 — `CDF` partout pour Coupe de France

## Statut

Accepté

## Décision

Le code officiel standardisé devient :

```text id="jlwmy0"
CDF
```

## Motivation

* homogénéité
* lisibilité
* compatibilité runtime

---

# ADR-010 — Session minimale runtime

## Statut

Accepté

## Décision

La session ne stocke JAMAIS :

* objets métier
* DTO
* chemins
* packages
* images

La session stocke UNIQUEMENT :

```text id="jlwmp7"
activeCompetitionId
```

## Motivation

* éviter état implicite
* éviter objets sérialisés
* simplifier runtime

---

# ADR-011 — Tous les chemins passent par `PathsService`

## Statut

Accepté

## Décision

Interdiction :

```php id="jlwms4"
ROOTPATH . '...'
```

dans :

* controllers
* services métier
* slideshow
* runtime

Tous les chemins passent par :

```text id="jlwmd6"
PathsService
```

ou futur :

```text id="jlwmbh"
CompetitionPathService
```

---

# ADR-012 — Les contrôleurs ne parlent jamais SQL

## Statut

Accepté

## Décision

Les contrôleurs utilisent uniquement :

* Services
* Repositories
* Models

## Interdits

* query SQL
* db_connect()
* logique persistence

---

# ADR-013 — Services runtime strictement techniques

## Statut

Accepté

## Décision

Les services runtime :

* PAS de SQL complexe
* PAS de HTML
* PAS de vues
* PAS de rendu UI

## Motivation

* testabilité
* découplage
* stabilité runtime

---

# ADR-014 — Stockage runtime unique

## Statut

Accepté

## Décision

Le runtime officiel unique devient :

```text id="jlwmu4"
writable/competitions/{package}/images/
```

## Motivation

* sécurité CI4
* séparation public/runtime
* préparation cloud/Docker

---

# ADR-015 — Services runtime officiels

## Statut

Accepté

| Rôle                       | Service                          |
| -------------------------- | -------------------------------- |
| compétition active runtime | ActiveCompetitionService         |
| chemins runtime            | CompetitionPathService           |
| chargement package         | CompetitionPackageLoader         |
| bootstrap filesystem       | CompetitionFilesystemInitializer |

---

# ADR-016 — `Domain` et non `Domains`

## Statut

Accepté

## Décision

Architecture officielle :

```text id="jlwmsu"
App\Domain\
```

## Motivation

* cohérence architecture
* éviter duplication namespaces
* simplification autoload

---

# ADR-017 — Competition Code persisté dans `competition_meta`

## Statut

Accepté

## Décision

Le code compétition officiel :

```text id="jlwmy1"
2020_N_293_00_0099
```

est enregistré dans :

```text id="jlwmp0"
competition_meta.code
```

au moment de l’importation.

## Motivation

* éviter reconstruction fragile
* stabiliser runtime
* stabiliser filesystem
* stabiliser bootstrap

## Interdits

* sprintf runtime
* concaténations manuelles
* reconstruction depuis year/id

---

# ADR-018 — Mapping métier `DIRECT = N`

## Statut

Accepté

## Décision

Le mapping historique :

```text id="jlwmd5"
DIRECT => N
```

reste centralisé dans :

```text id="jlwmbu"
CompetitionRegistry
```

## Motivation

* compatibilité legacy
* normalisation runtime
* stabilité imports historiques

## Important

Cette logique :

* ne doit jamais être dispersée
* ne doit jamais être recalculée dans controllers/services runtime.




Je ferais exactement ceci maintenant :
RuntimeImageService
RuntimeImageController
route /runtime/image/...
Slideshow branché runtime image flow
Runtime logs homogènes
Runtime toolbar collector
SlideshowRuntimeService
ActiveCompetitionOrchestrator




































































