# 🗄️ Base de Données - HorizonImmo

## 📋 Vue d'ensemble

Ce document détaille la structure de la base de données de HorizonImmo, incluant le schéma complet, les relations entre tables, les index et les bonnes pratiques de développement.

---

## 🏗️ Architecture de Base de Données

### 🔧 Configuration Technique

-   **SGBD** : MySQL 8.0+
-   **Engine** : InnoDB (support ACID et transactions)
-   **Charset** : UTF8MB4 (support emojis et caractères internationaux)
-   **Collation** : utf8mb4_unicode_ci
-   **Time Zone** : UTC (conversion côté application)

### 📊 Statistiques Actuelles

```sql
-- Taille de la base de données
SELECT
    table_schema AS 'Database',
    ROUND(SUM(data_length + index_length) / 1024 / 1024, 2) AS 'Size (MB)'
FROM information_schema.tables
WHERE table_schema = 'horizonimmo';

-- Nombre de tables : 16 tables métier + système
-- Relations : 8 clés étrangères principales
-- Index : 25 index pour optimisation des requêtes
```

---

## 📑 Tables Métier Principales

### 🏠 Properties (Propriétés)

Table centrale stockant toutes les propriétés immobilières.

```sql
CREATE TABLE properties (
    id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    city VARCHAR(255) NOT NULL,
    address TEXT NULL,
    currency VARCHAR(3) NOT NULL DEFAULT 'EUR',
    type VARCHAR(50) NULL,
    transaction_type VARCHAR(20) NULL,
    bedrooms INT NULL,
    bathrooms INT NULL,
    surface_area DECIMAL(8,2) NULL,
    images JSON NULL,
    status VARCHAR(20) NOT NULL DEFAULT 'available',
    is_featured TINYINT(1) NOT NULL DEFAULT 0,
    category_id BIGINT UNSIGNED NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,

    PRIMARY KEY (id),
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL,
    INDEX idx_city_price_status (city, price, status),
    INDEX idx_category_featured (category_id, is_featured),
    INDEX idx_status_created (status, created_at),
    FULLTEXT KEY ft_title_description (title, description)
);
```

#### **Champs détaillés :**

-   **title** : Titre accrocheur de la propriété (SEO-friendly)
-   **description** : Description détaillée (markdown support)
-   **price** : Prix en centimes pour éviter les erreurs de virgule flottante
-   **currency** : Code devise ISO (EUR, USD, etc.)
-   **type** : appartement, maison, terrain, local_commercial
-   **transaction_type** : vente, location, location_saisonniere
-   **images** : Array JSON des URLs d'images
-   **status** : available, reserved, sold, rented

#### **Exemples de requêtes optimisées :**

```sql
-- Recherche multicritères optimisée
SELECT p.*, c.name as category_name
FROM properties p
LEFT JOIN categories c ON p.category_id = c.id
WHERE p.city = 'Paris'
  AND p.price BETWEEN 200000 AND 500000
  AND p.status = 'available'
  AND p.bedrooms >= 2
ORDER BY p.is_featured DESC, p.created_at DESC
LIMIT 20;

-- Recherche full-text
SELECT *, MATCH(title, description) AGAINST('appartement moderne balcon' IN NATURAL LANGUAGE MODE) as relevance
FROM properties
WHERE MATCH(title, description) AGAINST('appartement moderne balcon' IN NATURAL LANGUAGE MODE)
  AND status = 'available'
ORDER BY relevance DESC, is_featured DESC;
```

### 🏷️ Categories (Catégories de Biens)

Classification des types de propriétés.

```sql
CREATE TABLE categories (
    id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,
    description TEXT NULL,
    is_active TINYINT(1) NOT NULL DEFAULT 1,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,

    PRIMARY KEY (id),
    UNIQUE KEY categories_slug_unique (slug),
    INDEX idx_active_name (is_active, name)
);
```

#### **Données de référence :**

```sql
INSERT INTO categories (name, slug, description, is_active) VALUES
('Appartements', 'appartements', 'Appartements et studios en ville', 1),
('Maisons', 'maisons', 'Maisons individuelles et villas', 1),
('Terrains', 'terrains', 'Terrains constructibles et agricoles', 1),
('Locaux Commerciaux', 'locaux-commerciaux', 'Commerces et bureaux', 1),
('Parkings', 'parkings', 'Places de parking et garages', 1);
```

### 👥 Users (Utilisateurs)

Gestion des comptes utilisateurs avec système de rôles.

```sql
CREATE TABLE users (
    id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    avatar VARCHAR(255) NULL,
    email_verified_at TIMESTAMP NULL,
    password VARCHAR(255) NOT NULL,
    remember_token VARCHAR(100) NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,

    PRIMARY KEY (id),
    UNIQUE KEY users_email_unique (email),
    INDEX idx_email_verified (email_verified_at),
    INDEX idx_created_at (created_at)
);
```

#### **Relation avec les rôles :**

```sql
-- Via le package Spatie Permission
-- Table model_has_roles pour attribution des rôles
-- Rôles disponibles : 'admin', 'client'
```

### 💬 Messages (Communications)

Système de messagerie entre clients et agents.

```sql
CREATE TABLE messages (
    id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    phone VARCHAR(20) NULL,
    subject VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    property_id BIGINT UNSIGNED NULL,
    is_read TINYINT(1) NOT NULL DEFAULT 0,
    read_at TIMESTAMP NULL,
    admin_response TEXT NULL,
    responded_at TIMESTAMP NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,

    PRIMARY KEY (id),
    FOREIGN KEY (property_id) REFERENCES properties(id) ON DELETE SET NULL,
    INDEX messages_property_id_index (property_id),
    INDEX messages_is_read_created_at_index (is_read, created_at),
    INDEX idx_email_created (email, created_at)
);
```

#### **Requêtes d'administration :**

```sql
-- Messages non lus par priorité
SELECT m.*, p.title as property_title
FROM messages m
LEFT JOIN properties p ON m.property_id = p.id
WHERE m.is_read = 0
ORDER BY m.created_at ASC;

-- Statistiques de réponse
SELECT
    COUNT(*) as total_messages,
    COUNT(admin_response) as responded,
    AVG(TIMESTAMPDIFF(HOUR, created_at, responded_at)) as avg_response_hours
FROM messages
WHERE created_at >= DATE_SUB(NOW(), INTERVAL 30 DAY);
```

### 📋 Accompaniment Requests (Demandes d'Accompagnement)

Demandes de services personnalisés des clients.

```sql
CREATE TABLE accompaniment_requests (
    id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    first_name VARCHAR(255) NOT NULL,
    last_name VARCHAR(255) NOT NULL,
    country_residence VARCHAR(255) NOT NULL,
    age INT NOT NULL,
    profession VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    desired_city VARCHAR(255) NOT NULL,
    property_type VARCHAR(100) NOT NULL,
    budget_range VARCHAR(100) NOT NULL,
    additional_info TEXT NULL,
    message TEXT NOT NULL,
    personal_contribution_percentage INT NULL,
    status VARCHAR(20) NOT NULL DEFAULT 'pending',
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,

    PRIMARY KEY (id),
    INDEX idx_status_created (status, created_at),
    INDEX idx_email (email),
    INDEX idx_city_budget (desired_city, budget_range)
);
```

#### **États de traitement :**

-   **pending** : Nouvelle demande
-   **processing** : En cours de traitement
-   **proposal_sent** : Proposition envoyée
-   **completed** : Accompagnement terminé
-   **cancelled** : Annulé

---

## 🔐 Tables de Sécurité et Système

### 🔑 Système d'Authentification

#### **Personal Access Tokens (Laravel Sanctum)**

```sql
CREATE TABLE personal_access_tokens (
    id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    tokenable_type VARCHAR(255) NOT NULL,
    tokenable_id BIGINT UNSIGNED NOT NULL,
    name VARCHAR(255) NOT NULL,
    token VARCHAR(64) NOT NULL UNIQUE,
    abilities TEXT NULL,
    last_used_at TIMESTAMP NULL,
    expires_at TIMESTAMP NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,

    PRIMARY KEY (id),
    UNIQUE KEY personal_access_tokens_token_unique (token),
    INDEX personal_access_tokens_tokenable_type_tokenable_id_index (tokenable_type, tokenable_id)
);
```

#### **Password Reset Tokens**

```sql
CREATE TABLE password_reset_tokens (
    email VARCHAR(255) NOT NULL,
    token VARCHAR(255) NOT NULL,
    created_at TIMESTAMP NULL,

    PRIMARY KEY (email)
);
```

### 👤 Gestion des Rôles et Permissions (Spatie)

#### **Roles (Rôles)**

```sql
CREATE TABLE roles (
    id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    guard_name VARCHAR(255) NOT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,

    PRIMARY KEY (id),
    UNIQUE KEY roles_name_guard_name_unique (name, guard_name)
);
```

#### **Permissions**

```sql
CREATE TABLE permissions (
    id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    guard_name VARCHAR(255) NOT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,

    PRIMARY KEY (id),
    UNIQUE KEY permissions_name_guard_name_unique (name, guard_name)
);
```

#### **Tables de Liaison**

```sql
-- Attribution rôles aux utilisateurs
CREATE TABLE model_has_roles (
    role_id BIGINT UNSIGNED NOT NULL,
    model_type VARCHAR(255) NOT NULL,
    model_id BIGINT UNSIGNED NOT NULL,

    PRIMARY KEY (role_id, model_id, model_type),
    INDEX model_has_roles_model_id_model_type_index (model_id, model_type),
    FOREIGN KEY (role_id) REFERENCES roles(id) ON DELETE CASCADE
);

-- Attribution permissions aux rôles
CREATE TABLE role_has_permissions (
    permission_id BIGINT UNSIGNED NOT NULL,
    role_id BIGINT UNSIGNED NOT NULL,

    PRIMARY KEY (permission_id, role_id),
    INDEX role_has_permissions_role_id_foreign (role_id),
    FOREIGN KEY (permission_id) REFERENCES permissions(id) ON DELETE CASCADE,
    FOREIGN KEY (role_id) REFERENCES roles(id) ON DELETE CASCADE
);
```

---

## 🔧 Optimisations et Index

### 📊 Index Stratégiques

#### **Index Composites pour Recherches Fréquentes**

```sql
-- Properties : Recherche par ville, prix et statut
ALTER TABLE properties ADD INDEX idx_search_main (city, price, status);

-- Properties : Filtrage par catégorie et featured
ALTER TABLE properties ADD INDEX idx_category_featured (category_id, is_featured);

-- Messages : Administration des messages
ALTER TABLE messages ADD INDEX idx_admin_management (is_read, created_at);

-- Accompaniment : Suivi des demandes
ALTER TABLE accompaniment_requests ADD INDEX idx_status_tracking (status, created_at);
```

#### **Index Full-Text pour Recherche**

```sql
-- Recherche textuelle dans les propriétés
ALTER TABLE properties ADD FULLTEXT(title, description);

-- Utilisation :
SELECT * FROM properties
WHERE MATCH(title, description) AGAINST('appartement paris balcon' IN NATURAL LANGUAGE MODE)
  AND status = 'available';
```

### 🚀 Optimisations de Performance

#### **Vues Matérialisées (Simulation)**

```sql
-- Vue pour statistiques rapides (à implémenter côté application)
CREATE VIEW property_stats AS
SELECT
    city,
    COUNT(*) as total_properties,
    AVG(price) as avg_price,
    MIN(price) as min_price,
    MAX(price) as max_price,
    COUNT(CASE WHEN status = 'available' THEN 1 END) as available_count
FROM properties
GROUP BY city;
```

#### **Partitioning par Date (Futur)**

```sql
-- Pour les grandes volumétries, partitioning des messages par mois
ALTER TABLE messages PARTITION BY RANGE (YEAR(created_at) * 100 + MONTH(created_at)) (
    PARTITION p202401 VALUES LESS THAN (202402),
    PARTITION p202402 VALUES LESS THAN (202403),
    -- ... autres partitions
    PARTITION p_future VALUES LESS THAN MAXVALUE
);
```

---

## 📋 Migrations Laravel

### 🏗️ Structure des Migrations

#### **Migration Création Properties**

```php
<?php
// database/migrations/xxxx_create_properties_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->decimal('price', 10, 2);
            $table->string('city');
            $table->text('address')->nullable();
            $table->string('currency', 3)->default('EUR');
            $table->string('type')->nullable();
            $table->string('transaction_type')->nullable();
            $table->integer('bedrooms')->nullable();
            $table->integer('bathrooms')->nullable();
            $table->decimal('surface_area', 8, 2)->nullable();
            $table->json('images')->nullable();
            $table->enum('status', ['available', 'reserved', 'sold'])->default('available');
            $table->boolean('is_featured')->default(false);
            $table->foreignId('category_id')->nullable()->constrained()->onDelete('set null');
            $table->timestamps();

            // Index
            $table->index(['city', 'price', 'status']);
            $table->index(['category_id', 'is_featured']);
            $table->fullText(['title', 'description']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('properties');
    }
};
```

#### **Migration Ajout Avatar Users**

```php
<?php
// database/migrations/xxxx_add_avatar_to_users_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('avatar')->nullable()->after('email');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('avatar');
        });
    }
};
```

### 🌱 Seeders

#### **Category Seeder**

```php
<?php
// database/seeders/CategorySeeder.php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            [
                'name' => 'Appartements',
                'slug' => 'appartements',
                'description' => 'Appartements et studios en ville',
                'is_active' => true
            ],
            [
                'name' => 'Maisons',
                'slug' => 'maisons',
                'description' => 'Maisons individuelles et villas',
                'is_active' => true
            ],
            [
                'name' => 'Terrains',
                'slug' => 'terrains',
                'description' => 'Terrains constructibles et agricoles',
                'is_active' => true
            ],
            [
                'name' => 'Locaux Commerciaux',
                'slug' => 'locaux-commerciaux',
                'description' => 'Commerces et bureaux',
                'is_active' => true
            ]
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
```

#### **Role & Permission Seeder**

```php
<?php
// database/seeders/RoleAndPermissionSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleAndPermissionSeeder extends Seeder
{
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            'dashboard.admin',
            'dashboard.client',
            'properties.view',
            'properties.create',
            'properties.update',
            'properties.delete',
            'categories.view',
            'categories.create',
            'categories.update',
            'categories.delete',
            'users.view',
            'users.create',
            'users.update',
            'users.delete',
            'messages.view',
            'messages.respond',
            'applications.view',
            'applications.update'
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create roles and assign permissions
        $adminRole = Role::create(['name' => 'admin']);
        $clientRole = Role::create(['name' => 'client']);

        // Admin gets all permissions
        $adminRole->givePermissionTo(Permission::all());

        // Client gets limited permissions
        $clientRole->givePermissionTo(['dashboard.client']);
    }
}
```

---

## 🏭 Factories pour Tests

### 🎲 Property Factory

```php
<?php
// database/factories/PropertyFactory.php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class PropertyFactory extends Factory
{
    public function definition()
    {
        return [
            'title' => $this->faker->sentence(4),
            'description' => $this->faker->paragraphs(3, true),
            'price' => $this->faker->numberBetween(100000, 1000000),
            'city' => $this->faker->city,
            'address' => $this->faker->address,
            'currency' => 'EUR',
            'type' => $this->faker->randomElement(['appartement', 'maison', 'studio', 'villa']),
            'transaction_type' => $this->faker->randomElement(['vente', 'location']),
            'bedrooms' => $this->faker->numberBetween(1, 5),
            'bathrooms' => $this->faker->numberBetween(1, 3),
            'surface_area' => $this->faker->numberBetween(30, 200),
            'images' => $this->generateImageUrls(),
            'status' => $this->faker->randomElement(['available', 'reserved']),
            'is_featured' => $this->faker->boolean(20), // 20% chance
            'category_id' => Category::factory(),
        ];
    }

    private function generateImageUrls()
    {
        $count = $this->faker->numberBetween(1, 5);
        $urls = [];

        for ($i = 0; $i < $count; $i++) {
            $urls[] = '/storage/properties/sample-' . $this->faker->numberBetween(1, 10) . '.jpg';
        }

        return $urls;
    }

    public function featured()
    {
        return $this->state(['is_featured' => true]);
    }

    public function sold()
    {
        return $this->state(['status' => 'sold']);
    }
}
```

---

## 📊 Requêtes d'Administration

### 🔍 Requêtes de Monitoring

#### **Statistiques Générales**

```sql
-- Vue d'ensemble de la plateforme
SELECT
    (SELECT COUNT(*) FROM properties WHERE status = 'available') as available_properties,
    (SELECT COUNT(*) FROM properties WHERE created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)) as new_properties_week,
    (SELECT COUNT(*) FROM users) as total_users,
    (SELECT COUNT(*) FROM users WHERE created_at >= DATE_SUB(NOW(), INTERVAL 30 DAY)) as new_users_month,
    (SELECT COUNT(*) FROM messages WHERE is_read = 0) as unread_messages,
    (SELECT COUNT(*) FROM accompaniment_requests WHERE status = 'pending') as pending_requests;
```

#### **Performance par Ville**

```sql
-- Top villes par nombre de propriétés
SELECT
    city,
    COUNT(*) as total_properties,
    COUNT(CASE WHEN status = 'available' THEN 1 END) as available,
    AVG(price) as avg_price,
    MAX(price) as max_price
FROM properties
GROUP BY city
HAVING total_properties >= 5
ORDER BY total_properties DESC
LIMIT 10;
```

#### **Analyse des Messages**

```sql
-- Temps de réponse moyen par mois
SELECT
    YEAR(created_at) as year,
    MONTH(created_at) as month,
    COUNT(*) as total_messages,
    COUNT(admin_response) as responded_messages,
    ROUND(COUNT(admin_response) * 100.0 / COUNT(*), 2) as response_rate,
    AVG(TIMESTAMPDIFF(HOUR, created_at, responded_at)) as avg_response_hours
FROM messages
WHERE created_at >= DATE_SUB(NOW(), INTERVAL 12 MONTH)
GROUP BY YEAR(created_at), MONTH(created_at)
ORDER BY year DESC, month DESC;
```

### 🧹 Maintenance

#### **Nettoyage des Données**

```sql
-- Suppression des tokens expirés
DELETE FROM personal_access_tokens
WHERE expires_at < NOW();

-- Archivage des anciens messages (>2 ans)
-- À adapter selon la politique de rétention
CREATE TABLE messages_archive LIKE messages;

INSERT INTO messages_archive
SELECT * FROM messages
WHERE created_at < DATE_SUB(NOW(), INTERVAL 2 YEAR);

DELETE FROM messages
WHERE created_at < DATE_SUB(NOW(), INTERVAL 2 YEAR);
```

#### **Vérification de l'Intégrité**

```sql
-- Propriétés sans catégorie active
SELECT p.id, p.title, p.category_id
FROM properties p
LEFT JOIN categories c ON p.category_id = c.id
WHERE p.category_id IS NOT NULL
  AND (c.id IS NULL OR c.is_active = 0);

-- Messages orphelins (propriété supprimée)
SELECT m.id, m.subject, m.property_id
FROM messages m
LEFT JOIN properties p ON m.property_id = p.id
WHERE m.property_id IS NOT NULL
  AND p.id IS NULL;
```

---

## 🔄 Backup et Récupération

### 💾 Stratégie de Sauvegarde

#### **Script de Backup Quotidien**

```bash
#!/bin/bash
# backup-db.sh

DATE=$(date +%Y%m%d_%H%M%S)
BACKUP_DIR="/var/backups/horizonimmo"
DB_NAME="horizonimmo"

# Backup complet
mysqldump --single-transaction --routines --triggers \
  -u backup_user -p$BACKUP_PASSWORD \
  $DB_NAME > $BACKUP_DIR/full_backup_$DATE.sql

# Compression
gzip $BACKUP_DIR/full_backup_$DATE.sql

# Nettoyage (garder 30 jours)
find $BACKUP_DIR -name "full_backup_*.sql.gz" -mtime +30 -delete

echo "Backup completed: full_backup_$DATE.sql.gz"
```

#### **Backup Incrémental**

```sql
-- Activer le binlog MySQL pour backup incrémental
-- my.cnf
[mysqld]
log-bin=mysql-bin
binlog-format=ROW
expire-logs-days=7
```

### 🔧 Restauration

#### **Restauration Complète**

```bash
#!/bin/bash
# restore-db.sh

BACKUP_FILE="$1"

if [ -z "$BACKUP_FILE" ]; then
    echo "Usage: $0 backup_file.sql.gz"
    exit 1
fi

# Arrêt application (mode maintenance)
php artisan down

# Restauration
zcat $BACKUP_FILE | mysql -u root -p horizonimmo

# Réindexation
mysql -u root -p horizonimmo -e "OPTIMIZE TABLE properties, messages, users;"

# Redémarrage application
php artisan up

echo "Restoration completed"
```

---

## 📈 Évolutions Futures

### 🚀 Améliorations Prévues

#### **Phase 1 : Performance (3 mois)**

-   **Partitioning** des tables de logs par date
-   **Index covering** pour requêtes fréquentes
-   **Read replicas** pour les requêtes analytiques
-   **Connection pooling** pour optimiser les connexions

#### **Phase 2 : Analytique (6 mois)**

-   **Tables de reporting** dénormalisées
-   **ETL** vers data warehouse (BigQuery/Redshift)
-   **Time-series data** pour métriques temps réel
-   **Elasticsearch** pour recherche avancée

#### **Phase 3 : Scale (12 mois)**

-   **Sharding** horizontal par région
-   **CQRS** pour séparer lecture/écriture
-   **Event sourcing** pour audit complet
-   **Multi-tenant** architecture

### 🔧 Nouvelles Tables Planifiées

#### **Property Views (Analytics)**

```sql
CREATE TABLE property_views (
    id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    property_id BIGINT UNSIGNED NOT NULL,
    user_id BIGINT UNSIGNED NULL,
    ip_address VARCHAR(45) NOT NULL,
    user_agent TEXT,
    referrer VARCHAR(255) NULL,
    viewed_at TIMESTAMP NOT NULL,

    PRIMARY KEY (id),
    FOREIGN KEY (property_id) REFERENCES properties(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_property_date (property_id, viewed_at),
    INDEX idx_user_date (user_id, viewed_at)
);
```

#### **Saved Searches (Alertes)**

```sql
CREATE TABLE saved_searches (
    id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    user_id BIGINT UNSIGNED NOT NULL,
    name VARCHAR(255) NOT NULL,
    criteria JSON NOT NULL,
    notification_frequency ENUM('immediate', 'daily', 'weekly') DEFAULT 'daily',
    is_active BOOLEAN DEFAULT TRUE,
    last_notified_at TIMESTAMP NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,

    PRIMARY KEY (id),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_user_active (user_id, is_active),
    INDEX idx_notification_schedule (notification_frequency, last_notified_at)
);
```

---

## 📚 Documentation Complémentaire

### 🔗 Ressources Internes

-   **[Architecture Technique](./architecture-technique.md)** : Vue d'ensemble système
-   **[Guide d'Installation](./installation.md)** : Setup base de données
-   **[API Documentation](./api.md)** : Endpoints et modèles de données

### 📖 Standards et Conventions

#### **Naming Conventions**

-   **Tables** : snake_case, pluriel (users, properties)
-   **Colonnes** : snake_case, descriptif (created_at, is_active)
-   **Index** : idx*[table]*[colonnes] (idx_properties_city_price)
-   **Foreign Keys** : fk*[table]*[referenced_table] (optionnel, auto-généré)

#### **Types de Données Standards**

-   **ID** : BIGINT UNSIGNED AUTO_INCREMENT
-   **Timestamps** : TIMESTAMP (UTC)
-   **Prix** : DECIMAL(10,2) (centimes)
-   **Booléens** : TINYINT(1)
-   **Texte long** : TEXT (descriptions)
-   **JSON** : JSON (arrays, objets complexes)

---

_Documentation maintenue par l'équipe technique_  
_Dernière mise à jour : Septembre 2025_  
_Version : 1.0_
