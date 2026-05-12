# COLOC NEXT — Mini Context Architecture
* CI4 officiel via `php spark serve`
* Aucun VirtualHost obligatoire
* Namespace officiel unique : `App\Domain\`
* Architecture officielle : `app/Domain/*`
* Runtime centralisé
* `RuntimeService` = source unique runtime
* `ActivationCompetitionService` = activation compétition runtime
* `CompetitionPathService` = source unique chemins runtime
* Runtime session : stocker uniquement `activeCompetitionId`
* Aucun DTO / objet métier / image / path en session
* Tous les chemins filesystem passent par `CompetitionPathService`
* Interdiction `ROOTPATH . '...'` dans services/controllers
* Runtime writable-first :

  * `writable/competitions/{code}/photos/`
* Fallback legacy temporaire autorisé
* Contrôleurs :

  * jamais SQL
  * jamais logique métier
  * jamais runtime manuel
* Runtime services :

  * pas HTML
  * pas vues
  * pas SQL complexe
* Architecture tables :

  * brut : `competitions`, `photos`, `notes`
  * normalisé : `competition_meta`
  * dérivé : `*_enriched`, `*_metrics`, `*_quotas`
* `CompetitionRegistry` = source métier centrale
* `Competition Code` persisté dans `competition_meta`
* `CDF` officiel partout pour Coupe de France
* `DIRECT = N` centralisé dans `CompetitionRegistry`
* Projection et saisie séparées
* Local sync first
* ADR-018 logs obligatoires :

  * `[Service] Action | key=value`
* Runtime = futur :

  * slideshow central
  * activeSession
  * runtime UI
  * debug production
  * orchestration compétition active
* Services CI4 :

  * utiliser `service('runtime')`
  * éviter `new RuntimeService()`
* PSR-4 strict :

  * namespace = chemin exact
* Runtime image flow :

  * `/runtime/image/{competition}/{file}`
* Runtime observability obligatoire via `log_message()` [Service] Action | key=value | key=value à chaque étape du process   



