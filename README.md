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

| Entité          | Table           | Description                       |
| --------------- | --------------- | --------------------------------- |
| `Filiere`       | `filiere`       | Filière d'études (GL, WIM, RT…)   |
| `Etablissement` | `etablissement` | École, université, institut       |
| `Evenement`     | `evenement`     | Conférence, webinaire, JPO, salon |

### Relations

- **Filiere ↔ Etablissement** : ManyToMany (N:N) → table pivot `filiere_etablissement`
- **Filiere → Evenement** : OneToMany (1:N) → `filiere_id` dans `evenement`
- **Etablissement → Evenement** : OneToMany (1:N) → `etablissement_id` dans `evenement`

---

## 🌐 Routes principales

### Front-office

| Route          | URL               | Controller              |
| -------------- | ----------------- | ----------------------- |
| Accueil        | `/`               | HomeController          |
| Filières       | `/filieres`       | FiliereController       |
| Détail filière | `/filieres/{id}`  | FiliereController       |
| Établissements | `/etablissements` | EtablissementController |

### Back-office (Admin)

| Route               | URL                       | Controller                   |
| ------------------- | ------------------------- | ---------------------------- |
| Dashboard           | `/admin`                  | AdminDashboardController     |
| Filières CRUD       | `/admin/filieres/*`       | AdminFiliereController       |
| Établissements CRUD | `/admin/etablissements/*` | AdminEtablissementController |
| Événements CRUD     | `/admin/evenements/*`     | AdminEvenementController     |

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

---

### 📄 Livrables TP3

- [x] Entités Doctrine (`src/Entity/`)
- [x] Relations 1:N et N:N implémentées
- [x] Migration SQL (`migrations/Version20260413000001.php`)
- [x] CRUD complets × 3 entités
- [x] Back-office intégré avec template TP2
- [x] Données de test (`src/DataFixtures/AppFixtures.php`)
- [x] Document de justification (`justification_technique_TP3.pdf`)
- [x] README structuré

---

---

## TP4 — Formulaires, Validation & Sécurité

### 🎯 Objectif du TP4

Sécuriser l'application avec un système d'authentification complet,
la gestion des rôles, la validation des données et la protection des routes.

---

### 🔐 Système d'authentification

| Route       | Description                         |
| ----------- | ----------------------------------- |
| `/register` | Inscription d'un nouvel utilisateur |
| `/login`    | Connexion                           |
| `/logout`   | Déconnexion                         |
| `/profile`  | Profil de l'utilisateur connecté    |

---

### 👥 Gestion des rôles

| Rôle         | Accès                       |
| ------------ | --------------------------- |
| `ROLE_USER`  | Site public + page profil   |
| `ROLE_ADMIN` | Tout + back-office `/admin` |

---

### ✅ Validation des données

Contraintes appliquées sur toutes les entités :

- `@Assert\NotBlank` — champs obligatoires
- `@Assert\Length` — longueur min/max avec messages personnalisés
- `@Assert\Email` — format email valide
- `@Assert\NotNull` — valeur non nulle (dates)
- `@UniqueEntity` — email unique en base de données

Les erreurs s'affichent directement sous chaque champ dans les formulaires Twig.

---

### 📝 Formulaires personnalisés

Pour chaque entité, les FormType ont été enrichis avec :

- Labels en français explicites
- Types adaptés (`ChoiceType`, `EmailType`, `TelType`, `DateTimeType`, `RepeatedType`)
- Placeholders sur chaque champ
- Organisation logique des champs

---

### 🛡️ Sécurisation des routes

```yaml
# security.yaml
access_control:
  - { path: ^/admin, roles: ROLE_ADMIN }
  - { path: ^/profile, roles: ROLE_USER }
```

- `@IsGranted("ROLE_ADMIN")` sur tous les contrôleurs admin
- Protection CSRF automatique sur tous les formulaires
- Mots de passe hachés avec `UserPasswordEncoderInterface`
- Pages d'erreur 403 et 404 personnalisées

src/
├── Controller/
│ ├── SecurityController.php ← login, logout, register
│ ├── ProfileController.php ← page profil
│ └── AdminUserController.php ← CRUD utilisateurs
├── Entity/
│ └── User.php ← implémente UserInterface
├── Form/
│ └── RegistrationFormType.php ← formulaire d'inscription
templates/
├── security/
│ ├── login.html.twig
│ └── register.html.twig
└── profile/
└── index.html.twig
config/packages/
└── security.yaml ← firewall, rôles, access_control

---

### 📄 Livrables TP4

- [x] Système d'authentification fonctionnel (inscription, connexion, déconnexion)
- [x] Gestion des rôles `ROLE_USER` / `ROLE_ADMIN`
- [x] Formulaires personnalisés avec labels, types et placeholders
- [x] Validation côté serveur avec affichage des erreurs
- [x] Routes sécurisées (`security.yaml` + `@IsGranted`)
- [x] Protection CSRF active
- [x] Pages 403 et 404 personnalisées
- [x] Dépôt Git à jour

---

## _IT 232 — Développement Web II — Année Académique 2025-2026_

### 📁 Fichiers ajoutés (TP4)

_IT 232 — Développement Web II — Année Académique 2025-2026_
