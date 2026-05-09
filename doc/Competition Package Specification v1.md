# COLOC NEXT

# Competition Package Specification v1

Version :

```text id="jlwmwd"
1.0
```

Statut :

```text id="jlwm34"
Draft / Bootstrap Phase
```

Objectif :
définir un format standard portable pour représenter une compétition complète dans COLOC NEXT.

Le package doit permettre :

* bootstrap application
* démonstration
* sauvegarde
* import/export
* environnement de test
* migration progressive depuis ancien système

---

# 1 — Principes

Le Competition Package est :

```text id="jlwmpr"
autonome
portable
versionnable
rejouable
```

Il contient :

* données SQL métier
* ressources images
* exports associés
* métadonnées de compétition

---

# 2 — Objectifs techniques

Le package doit permettre :

| Fonction                        | Support |
| ------------------------------- | ------- |
| Bootstrap première installation | OUI     |
| Démonstration locale            | OUI     |
| Tests techniques                | OUI     |
| Développement offline           | OUI     |
| Migration progressive           | OUI     |
| Sauvegarde                      | FUTUR   |
| Import ZIP                      | FUTUR   |

---

# 3 — Structure officielle v1

```text id="jlwmna"
competition/
└── 2020_N_293_00_0099/
    ├── metadata.json
    │
    ├── sql/
    │   ├── competitions.sql
    │   ├── competition_meta.sql
    │   ├── participants.sql
    │   ├── clubs.sql
    │   └── photos.sql
    │
    ├── photos/
    ├── thumbs/
    ├── export/
    ├── csv/
    ├── pdf/
    ├── pte/
    └── temp/
```

---

# 4 — Convention de nommage

Format recommandé :

```text id="jlwmeo"
YYYY_T_NNN_XX_XXXX
```

Exemple :

```text id="jlwmjy"
2020_N_293_00_0099
```

---

# 5 — Description des dossiers

| Dossier | Description          |
| ------- | -------------------- |
| sql     | données métier       |
| photos  | images originales    |
| thumbs  | miniatures           |
| export  | exports applicatifs  |
| csv     | exports CSV          |
| pdf     | exports PDF          |
| pte     | fichiers historiques |
| temp    | fichiers temporaires |

---

# 6 — SQL autorisé

Les fichiers SQL doivent contenir UNIQUEMENT :

```sql id="jlwm7d"
INSERT INTO ...
```

---

# Interdits dans v1

```text id="jlwm7m"
DROP TABLE
CREATE TABLE
ALTER TABLE
AUTO_INCREMENT
```

Le schéma reste géré par :

```text id="jlwm88"
CI4 migrations
```

---

# 7 — Tables minimales obligatoires

| Table            | Obligatoire |
| ---------------- | ----------- |
| competitions     | OUI         |
| competition_meta | OUI         |
| participants     | OUI         |
| clubs            | OUI         |
| photos           | OUI         |

---

# 8 — Tables optionnelles futures

| Table    | Statut |
| -------- | ------ |
| notes    | FUTUR  |
| judges   | FUTUR  |
| sessions | FUTUR  |
| imports  | FUTUR  |

---

# 9 — metadata.json

## Objectif

Fournir :

* identification package
* validation rapide
* bootstrap application
* compatibilité future

---

# Exemple v1

```json id="jlwm4e"
{
  "format_version": 1,
  "code": "2020_N_293_00_0099",
  "competition_id": 293,
  "bootstrap": true,
  "label": "TEST NATIONAL COLOC",
  "year": 2020,
  "type": "AUTEUR",
  "support": "IP",
  "mode": "DIRECT",
  "photos_count": 9,
  "has_thumbs": true,
  "has_exports": true
}
```

---

# 10 — Ordre de chargement recommandé

Le loader doit respecter :

```text id="jlwm7x"
1. clubs
2. participants
3. competitions
4. competition_meta
5. photos
```

---

# 11 — Active Competition

Lors du bootstrap :

```text id="jlwmph"
SI aucune compétition active
ALORS
charger package bootstrap
ET
définir compétition active
```

---

# 12 — ActiveCompetitionService

Responsabilité future :

```text id="jlwm4u"
- getCurrent()
- setCurrent()
- loadMeta()
- getPaths()
- initialize()
```

---

# 13 — Objectif architectural

Le Competition Package devient :

```text id="jlwmj7"
l’unité métier portable officielle
```

de COLOC NEXT.

---

# 14 — Contraintes v1

| Contrainte                        | Statut |
| --------------------------------- | ------ |
| Compatible ancien projet          | OUI    |
| Compatible COPAIN                 | OUI    |
| Compatible migration incrémentale | OUI    |
| Compatible spark serve            | OUI    |
| Compatible Win/Mac                | OUI    |

---

# 15 — Risques identifiés

| Risque                       | Impact |
| ---------------------------- | ------ |
| FK implicites historiques    | élevé  |
| chemins physiques hardcodés  | élevé  |
| session ↔ compétition active | élevé  |
| dépendance import COPAIN     | moyen  |

---

# 16 — Recommandations importantes

## Éviter

```php id="jlwmjq"
session('competition')
```

directement dans le code.

---

## Centraliser

dans :

```text id="jlwm3j"
ActiveCompetitionService
```

---

# 17 — Évolutions futures possibles

| Fonction           | Statut |
| ------------------ | ------ |
| package ZIP        | FUTUR  |
| import UI          | FUTUR  |
| backup automatique | FUTUR  |
| validation package | FUTUR  |
| versioning package | FUTUR  |
| cloud sync         | FUTUR  |

---

# 18 — Première compétition bootstrap officielle

```text id="jlwm2q"
2020_N_293_00_0099
```

Statut :

```text id="jlwm7n"
Bootstrap dataset de référence
```



/Applications/MAMP/Library/bin/mysqldump \
-u root \
-proot \
-P 8889 \
coloc competitions \
--where="id=293" \
--no-create-info \
--skip-comments \
--skip-add-locks \
--compact \
> competitions.sql