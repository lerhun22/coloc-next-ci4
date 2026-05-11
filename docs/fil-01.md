```text id="j7m4qp"
Objectif du nouveau fil :

Stabilisation finale du runtime slideshow + nettoyage architecture runtime COLOC NEXT.

État actuel validé :
- RuntimeService opérationnel
- ActivationCompetitionService opérationnel
- RuntimeDTO opérationnel
- SlideshowService runtime-aware
- RuntimeImageController opérationnel
- ADR-018 logs opérationnels
- writable runtime opérationnel
- fallback legacy opérationnel
- services CI4 stabilisés
- PSR-4 stabilisé
- namespace officiel : App\Domain\

Architecture runtime actuelle :
ActivationCompetitionService
    ↓
RuntimeService
    ↓
RuntimeDTO
    ↓
CompetitionPathService
    ↓
SlideshowService
    ↓
RuntimeImageController

Conventions obligatoires :
- jamais App\Domains\
- jamais new RuntimeService()
- toujours service('runtime')
- session = uniquement activeCompetitionId
- tous les chemins via CompetitionPathService
- logs ADR-018 obligatoires
- runtime services sans HTML ni SQL complexe
- controllers sans SQL

Prochaines étapes :
1. Nettoyage final namespaces/runtime
2. Déplacement futur Domain/Competition/Runtime → Domain/Runtime
3. Runtime debug toolbar
4. Runtime dashboard
5. Runtime slideshow cache/thumbnails
6. Runtime image resizing pipeline
7. Runtime multi-competition support
8. Runtime filesystem initializer automatique
9. Runtime import/export raccordement
10. ADR Runtime consolidation
```
