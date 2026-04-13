# SchoolPrepar — TP3

## Développement Web II (IT 232) — Symfony 5.4

### 🎯 Objectif du TP3
Implémentation de la base de données avec Doctrine ORM, migrations, CRUD complets et données de test.

---

## 📦 Installation

```bash
# 1. Cloner / dézipper le projet
cd schoolprepar_tp3

# 2. Installer les dépendances
composer install

# 3. Configurer la base de données dans .env
# Par défaut : SQLite (aucune installation requise)
DATABASE_URL="sqlite:///%kernel.project_dir%/var/data.db"

# 4. Créer la base et exécuter la migration
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate

# 5. (Optionnel) Charger les données de test
composer require --dev doctrine/doctrine-fixtures-bundle
php bin/console doctrine:fixtures:load

# 6. Lancer le serveur
symfony server:start
# ou
php -S localhost:8000 -t public/
```

---

## 🗂️ Entités Doctrine (TP3)

| Entité | Table | Description |
|--------|-------|-------------|
| `Filiere` | `filiere` | Filière d'études (GL, WIM, RT…) |
| `Etablissement` | `etablissement` | École, université, institut |
| `Evenement` | `evenement` | Conférence, webinaire, JPO, salon |

### Relations
- **Filiere ↔ Etablissement** : ManyToMany (N:N) → table pivot `filiere_etablissement`
- **Filiere → Evenement** : OneToMany (1:N) → `filiere_id` dans `evenement`
- **Etablissement → Evenement** : OneToMany (1:N) → `etablissement_id` dans `evenement`

---

## 🌐 Routes principales

### Front-office
| Route | URL | Controller |
|-------|-----|-----------|
| Accueil | `/` | HomeController |
| Filières | `/filieres` | FiliereController |
| Détail filière | `/filieres/{id}` | FiliereController |
| Établissements | `/etablissements` | EtablissementController |

### Back-office (Admin)
| Route | URL | Controller |
|-------|-----|-----------|
| Dashboard | `/admin` | AdminDashboardController |
| Filières CRUD | `/admin/filieres/*` | AdminFiliereController |
| Établissements CRUD | `/admin/etablissements/*` | AdminEtablissementController |
| Événements CRUD | `/admin/evenements/*` | AdminEvenementController |

---

## 📁 Structure src/ (TP3)

```
src/
├── Controller/
│   ├── AdminFiliereController.php        ← CRUD complet
│   ├── AdminEtablissementController.php  ← CRUD complet
│   ├── AdminEvenementController.php      ← CRUD complet (nouveau TP3)
│   ├── AdminDashboardController.php      ← Stats live depuis DB
│   ├── FiliereController.php             ← Front (Doctrine)
│   └── EtablissementController.php       ← Front (Doctrine)
├── Entity/
│   ├── Filiere.php
│   ├── Etablissement.php
│   └── Evenement.php
├── Form/
│   ├── FiliereType.php
│   ├── EtablissementType.php
│   └── EvenementType.php
├── Repository/
│   ├── FiliereRepository.php
│   ├── EtablissementRepository.php
│   └── EvenementRepository.php
└── DataFixtures/
    └── AppFixtures.php   ← 6 filières, 6 établissements, 6 événements
```

---

## 📄 Livrables TP3

- [x] Entités Doctrine (`src/Entity/`)
- [x] Relations 1:N et N:N implémentées
- [x] Migration SQL (`migrations/Version20260413000001.php`)
- [x] CRUD complets × 3 entités
- [x] Back-office intégré avec template TP2
- [x] Données de test (`src/DataFixtures/AppFixtures.php`)
- [x] Document de justification (`justification_technique_TP3.pdf`)
- [x] README structuré

---

*IT 232 — Développement Web II — Année Académique 2025-2026*
