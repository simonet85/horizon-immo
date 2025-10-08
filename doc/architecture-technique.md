# 🏗️ Architecture Technique - HorizonImmo

## 📋 Vue d'ensemble

HorizonImmo est une plateforme immobilière moderne construite avec une architecture robuste et évolutive. Ce document détaille l'architecture technique, les choix technologiques et les bonnes pratiques implémentées.

---

## 🏗️ Stack Technologique

### 🎯 Backend Framework

#### **Laravel 10.48.29**

-   **PHP** : 8.1.10
-   **Framework MVC** : Structure organisée et maintenable
-   **Eloquent ORM** : Gestion élégante de la base de données
-   **Artisan CLI** : Outils en ligne de commande
-   **Package manager** : Composer

#### **Packages Laravel Principaux**

-   **Laravel Sanctum 3.3.3** : Authentification API
-   **Laravel Breeze 1.29.1** : Authentification et profils
-   **Laravel Pint 1.20.0** : Code formatting
-   **Laravel Sail 1.45.0** : Environnement Docker
-   **Laravel Prompts 0.1.25** : Interface CLI interactive

### ⚡ Frontend Technologies

#### **Livewire 3.6.4**

-   **Livewire Core** : Composants full-stack PHP
-   **Livewire Volt 1.7.2** : API fonctionnelle et class-based
-   **Alpine.js 3.14.9** : Interactivité JavaScript légère
-   **Intégration automatique** : Alpine inclus dans Livewire 3

#### **CSS & Design**

-   **Tailwind CSS 3.4.17** : Framework CSS utility-first
-   **Design responsive** : Mobile-first approach
-   **Components** : Bibliothèque de composants réutilisables
-   **Dark mode** : Support natif

### 🗄️ Base de Données

#### **MySQL (Production)**

-   **Engine** : InnoDB pour la cohérence ACID
-   **Charset** : UTF-8 Unicode
-   **Indexes** : Optimisation des requêtes
-   **Foreign Keys** : Intégrité référentielle

#### **Structure Principale**

```sql
-- Tables métier
properties (biens immobiliers)
categories (types de biens)
users (utilisateurs)
messages (communications)
accompaniment_requests (demandes d'accompagnement)

-- Tables système
roles, permissions (contrôle d'accès)
personal_access_tokens (API tokens)
failed_jobs (gestion des queues)
```

### 🔧 Build Tools

#### **Vite**

-   **Hot Module Replacement** : Développement ultra-rapide
-   **Tree shaking** : Optimisation bundle
-   **Asset pipeline** : CSS/JS preprocessing
-   **Production builds** : Minification et optimisation

---

## 🏛️ Architecture Applicative

### 📁 Structure des Dossiers

```
app/
├── Console/           # Commandes Artisan
├── Exceptions/        # Gestion des erreurs
├── Http/
│   ├── Controllers/   # Contrôleurs MVC
│   ├── Middleware/    # Middlewares HTTP
│   └── Kernel.php     # Configuration HTTP
├── Livewire/          # Composants Livewire
│   ├── Actions/       # Actions métier
│   └── Forms/         # Formulaires interactifs
├── Models/            # Modèles Eloquent
├── Providers/         # Service Providers
└── View/
    └── Components/    # Composants Blade

resources/
├── css/              # Styles Tailwind
├── js/               # JavaScript/Alpine
├── views/            # Templates Blade
│   ├── components/   # Composants réutilisables
│   ├── layouts/      # Layouts principaux
│   └── livewire/     # Vues Livewire

routes/
├── web.php           # Routes web principales
├── api.php           # Routes API
└── auth.php          # Routes authentification

database/
├── migrations/       # Migrations schéma
├── seeders/         # Données de test
└── factories/       # Factory pour tests
```

### 🔄 Pattern MVC Étendu

#### **Models (Éloquent)**

```php
// Exemple : Model Property
class Property extends Model
{
    protected $fillable = [
        'title', 'description', 'price',
        'category_id', 'images'
    ];

    protected $casts = [
        'images' => 'array',
        'is_featured' => 'boolean',
        'price' => 'decimal:2'
    ];

    // Relations
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
```

#### **Controllers (Actions)**

```php
// Exemple : PropertyController
class PropertyController extends Controller
{
    public function index()
    {
        $properties = Property::with('category')
            ->latest()
            ->paginate(10);

        return view('admin.properties.index',
            compact('properties'));
    }
}
```

#### **Views (Blade + Livewire)**

```blade
{{-- Layout principal --}}
@extends('layouts.admin')

@section('content')
    {{-- Composant Livewire --}}
    @livewire('property-list', ['filters' => $filters])
@endsection
```

### 🔀 Architecture Livewire

#### **Composants Class-Based**

```php
// Composant traditionnel
class PropertyForm extends Component
{
    public Property $property;
    public $title = '';
    public $price = 0;

    protected $rules = [
        'title' => 'required|min:3',
        'price' => 'required|numeric|min:0'
    ];

    public function save()
    {
        $this->validate();

        $this->property->update([
            'title' => $this->title,
            'price' => $this->price
        ]);

        session()->flash('message', 'Propriété mise à jour');
    }

    public function render()
    {
        return view('livewire.property-form');
    }
}
```

#### **Livewire Volt (Functional API)**

```php
<?php
// Composant Volt fonctionnel
use Livewire\Volt\Component;
use function Livewire\Volt\{state, rules, save};

state(['name' => '', 'email' => '']);

rules(['name' => 'required', 'email' => 'required|email']);

$save = function () {
    $this->validate();

    User::create($this->only(['name', 'email']));

    $this->reset();
};
?>

<div>
    <form wire:submit="save">
        <!-- Formulaire HTML -->
    </form>
</div>
```

---

## 🔐 Sécurité et Authentification

### 🛡️ Système d'Authentification

#### **Laravel Breeze + Sanctum**

-   **Sessions** : Authentification web traditionnelle
-   **API Tokens** : Sanctum pour API REST
-   **CSRF Protection** : Tokens automatiques
-   **Rate Limiting** : Protection force brute

#### **Contrôle d'Accès (Spatie Permissions)**

```php
// Définition des rôles et permissions
Role::create(['name' => 'admin']);
Role::create(['name' => 'client']);

Permission::create(['name' => 'properties.view']);
Permission::create(['name' => 'properties.create']);

// Attribution
$user->assignRole('admin');
$user->givePermissionTo('properties.create');

// Vérification dans les vues
@can('properties.create')
    <a href="{{ route('properties.create') }}">Ajouter</a>
@endcan
```

#### **Middleware de Sécurité**

```php
// Middleware admin personnalisé
class AdminMiddleware
{
    public function handle($request, Closure $next, $role)
    {
        if (!auth()->user()?->hasRole($role)) {
            abort(403, 'Accès non autorisé');
        }

        return $next($request);
    }
}

// Usage dans les routes
Route::middleware(['auth', 'admin:admin'])->group(function () {
    Route::resource('properties', PropertyController::class);
});
```

### 🔒 Protection des Données

#### **Validation Stricte**

```php
// Validation des uploads
$request->validate([
    'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    'images' => 'nullable|array',
    'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
]);
```

#### **Nettoyage des Données**

```php
// Suppression automatique anciennes images
if ($user->avatar && $user->avatar !== $newAvatar) {
    Storage::disk('public')->delete(
        str_replace('/storage/', '', $user->avatar)
    );
}
```

---

## 💾 Gestion des Données

### 🗃️ Migrations et Schéma

#### **Migration Exemple : Properties**

```php
public function up()
{
    Schema::create('properties', function (Blueprint $table) {
        $table->id();
        $table->string('title');
        $table->text('description');
        $table->decimal('price', 10, 2);
        $table->string('city');
        $table->text('address')->nullable();
        $table->integer('bedrooms')->nullable();
        $table->integer('bathrooms')->nullable();
        $table->decimal('surface_area', 8, 2)->nullable();
        $table->json('images')->nullable();
        $table->enum('status', ['available', 'reserved', 'sold'])
              ->default('available');
        $table->boolean('is_featured')->default(false);
        $table->foreignId('category_id')
              ->nullable()
              ->constrained()
              ->onDelete('set null');
        $table->timestamps();
    });
}
```

#### **Seeders pour Données de Test**

```php
class PropertySeeder extends Seeder
{
    public function run()
    {
        $categories = Category::all();

        foreach ($categories as $category) {
            Property::factory(10)->create([
                'category_id' => $category->id
            ]);
        }
    }
}
```

### 🏭 Factories pour Tests

```php
class PropertyFactory extends Factory
{
    public function definition()
    {
        return [
            'title' => $this->faker->sentence(4),
            'description' => $this->faker->paragraphs(3, true),
            'price' => $this->faker->numberBetween(100000, 1000000),
            'city' => $this->faker->city,
            'bedrooms' => $this->faker->numberBetween(1, 5),
            'bathrooms' => $this->faker->numberBetween(1, 3),
            'surface_area' => $this->faker->numberBetween(30, 200),
            'status' => $this->faker->randomElement(['available', 'reserved']),
            'is_featured' => $this->faker->boolean(20), // 20% chance
        ];
    }
}
```

---

## 🎨 Frontend Architecture

### 🎯 Composants Livewire

#### **Gestion d'État Réactive**

```php
class PropertyFilter extends Component
{
    public $search = '';
    public $priceMin = 0;
    public $priceMax = 1000000;
    public $category = 'all';

    protected $queryString = [
        'search',
        'priceMin' => ['except' => 0],
        'priceMax' => ['except' => 1000000],
        'category' => ['except' => 'all']
    ];

    public function updatedSearch()
    {
        $this->resetPage(); // Reset pagination
    }

    public function render()
    {
        $properties = Property::query()
            ->when($this->search, fn($q) =>
                $q->where('title', 'like', '%'.$this->search.'%')
            )
            ->when($this->category !== 'all', fn($q) =>
                $q->where('category_id', $this->category)
            )
            ->whereBetween('price', [$this->priceMin, $this->priceMax])
            ->paginate(12);

        return view('livewire.property-filter', compact('properties'));
    }
}
```

#### **Interactions Alpine.js**

```blade
<div x-data="{
    showFilters: false,
    priceRange: @entangle('priceMax')
}">
    <!-- Toggle filters -->
    <button @click="showFilters = !showFilters">
        Filtres
    </button>

    <!-- Filters panel -->
    <div x-show="showFilters" x-transition>
        <!-- Price range slider -->
        <input type="range"
               x-model="priceRange"
               wire:model.live="priceMax"
               min="100000"
               max="1000000">
        <span x-text="priceRange.toLocaleString() + ' €'"></span>
    </div>
</div>
```

### 🎨 Design System Tailwind

#### **Configuration Personnalisée**

```javascript
// tailwind.config.js
module.exports = {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {
            colors: {
                "horizon-blue": {
                    50: "#eff6ff",
                    500: "#3b82f6",
                    900: "#1e3a8a",
                },
            },
            fontFamily: {
                sans: ["Figtree", "sans-serif"],
            },
        },
    },
    plugins: [
        require("@tailwindcss/forms"),
        require("@tailwindcss/typography"),
    ],
};
```

#### **Composants Réutilisables**

```blade
{{-- resources/views/components/button.blade.php --}}
@props([
    'variant' => 'primary',
    'size' => 'md',
    'type' => 'button'
])

@php
$classes = [
    'primary' => 'bg-blue-600 hover:bg-blue-700 text-white',
    'secondary' => 'bg-gray-200 hover:bg-gray-300 text-gray-900',
    'danger' => 'bg-red-600 hover:bg-red-700 text-white'
][$variant];

$sizes = [
    'sm' => 'px-3 py-1.5 text-sm',
    'md' => 'px-4 py-2',
    'lg' => 'px-6 py-3 text-lg'
][$size];
@endphp

<button {{ $attributes->merge([
    'type' => $type,
    'class' => "rounded-md font-medium focus:outline-none focus:ring-2 focus:ring-offset-2 transition-colors {$classes} {$sizes}"
]) }}>
    {{ $slot }}
</button>
```

---

## 🔧 Outils de Développement

### 🏗️ Build Process

#### **Vite Configuration**

```javascript
// vite.config.js
import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    plugins: [
        laravel({
            input: ["resources/css/app.css", "resources/js/app.js"],
            refresh: true,
        }),
    ],
    build: {
        rollupOptions: {
            output: {
                manualChunks: {
                    alpine: ["alpinejs"],
                    vendor: ["axios"],
                },
            },
        },
    },
});
```

#### **Asset Pipeline**

```css
/* resources/css/app.css */
@tailwind base;
@tailwind components;
@tailwind utilities;

/* Composants personnalisés */
@layer components {
    .btn-primary {
        @apply bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md;
    }

    .card {
        @apply bg-white rounded-lg shadow-md p-6;
    }
}
```

### 🧪 Testing Strategy

#### **Configuration PHPUnit**

```xml
<!-- phpunit.xml -->
<phpunit bootstrap="vendor/autoload.php">
    <testsuites>
        <testsuite name="Unit">
            <directory suffix="Test.php">./tests/Unit</directory>
        </testsuite>
        <testsuite name="Feature">
            <directory suffix="Test.php">./tests/Feature</directory>
        </testsuite>
    </testsuites>
    <php>
        <env name="APP_ENV" value="testing"/>
        <env name="DB_CONNECTION" value="mysql"/>
        <env name="DB_DATABASE" value="horizon_immo_test"/>
    </php>
</phpunit>
```

#### **Tests Livewire**

```php
class PropertyFormTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_create_property()
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();

        Livewire::actingAs($user)
            ->test(PropertyForm::class)
            ->set('title', 'Appartement Test')
            ->set('price', 250000)
            ->set('category_id', $category->id)
            ->call('save')
            ->assertHasNoErrors()
            ->assertRedirect();

        $this->assertDatabaseHas('properties', [
            'title' => 'Appartement Test',
            'price' => 250000
        ]);
    }
}
```

### 🔍 Quality Assurance

#### **Laravel Pint (Code Style)**

```json
{
    "preset": "laravel",
    "rules": {
        "simplified_null_return": true,
        "braces": {
            "position_after_control_structures": "same"
        },
        "concat_space": {
            "spacing": "one"
        }
    }
}
```

#### **Commandes de Qualité**

```bash
# Formatage du code
./vendor/bin/pint

# Tests unitaires
php artisan test

# Analyse statique (optionnel)
./vendor/bin/phpstan analyse

# Coverage des tests
php artisan test --coverage
```

---

## 🚀 Déploiement et Infrastructure

### 🐳 Docker avec Laravel Sail

#### **Configuration Docker**

```yaml
# docker-compose.yml (Sail)
services:
    laravel.test:
        build:
            context: ./vendor/laravel/sail/runtimes/8.1
        image: sail-8.1/app
        ports:
            - "${APP_PORT:-80}:80"
            - "${VITE_PORT:-5173}:${VITE_PORT:-5173}"
        environment:
            WWWUSER: "${WWWUSER}"
            LARAVEL_SAIL: 1
        volumes:
            - ".:/var/www/html"
        networks:
            - sail
        depends_on:
            - mysql
            - redis

    mysql:
        image: "mysql/mysql-server:8.0"
        environment:
            MYSQL_ROOT_PASSWORD: "${DB_PASSWORD}"
            MYSQL_DATABASE: "${DB_DATABASE}"
```

### 📦 Process de Déploiement

#### **Scripts de Déploiement**

```bash
#!/bin/bash
# deploy.sh

# 1. Mise à jour du code
git pull origin main

# 2. Installation des dépendances
composer install --no-dev --optimize-autoloader

# 3. Mise à jour de la base de données
php artisan migrate --force

# 4. Optimisations Laravel
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 5. Build des assets
npm ci
npm run build

# 6. Permissions
chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache

# 7. Redémarrage des services
sudo systemctl restart php8.1-fpm
sudo systemctl restart nginx
```

### 🔄 CI/CD avec GitHub Actions

```yaml
# .github/workflows/laravel.yml
name: Laravel Tests

on:
    push:
        branches: [main, develop]
    pull_request:
        branches: [main]

jobs:
    test:
        runs-on: ubuntu-latest

        services:
            mysql:
                image: mysql:8.0
                env:
                    MYSQL_ROOT_PASSWORD: root
                    MYSQL_DATABASE: horizon_immo_test
                ports:
                    - 3306:3306

        steps:
            - uses: actions/checkout@v3

            - name: Setup PHP
              uses: shivammathur/setup-php@v2
              with:
                  php-version: "8.1"
                  extensions: mbstring, dom, fileinfo, mysql

            - name: Install dependencies
              run: composer install --prefer-dist --no-progress

            - name: Run tests
              run: php artisan test
              env:
                  DB_CONNECTION: mysql
                  DB_HOST: 127.0.0.1
                  DB_PORT: 3306
                  DB_DATABASE: horizon_immo_test
                  DB_USERNAME: root
                  DB_PASSWORD: root
```

---

## 📊 Monitoring et Performance

### 📈 Métriques de Performance

#### **Monitoring Laravel**

-   **Telescope** : Debug et profiling en développement
-   **Horizon** : Monitoring des queues Redis
-   **Health checks** : Endpoints de santé de l'application

#### **Métriques Clés**

```php
// Routes de monitoring
Route::get('/health', function () {
    return response()->json([
        'status' => 'ok',
        'timestamp' => now(),
        'services' => [
            'database' => DB::connection()->getPdo() ? 'ok' : 'error',
            'cache' => Cache::store()->getStore()->connection()->ping() ? 'ok' : 'error'
        ]
    ]);
});
```

### 🔧 Optimisations

#### **Cache Strategies**

```php
// Cache des requêtes fréquentes
public function getFeaturedProperties()
{
    return Cache::remember('featured-properties', 3600, function () {
        return Property::where('is_featured', true)
            ->with('category')
            ->limit(6)
            ->get();
    });
}

// Tags de cache pour invalidation
Cache::tags(['properties', 'featured'])->put('key', $value, 3600);
Cache::tags(['properties'])->flush(); // Invalide tout le cache properties
```

#### **Optimisation Base de Données**

```php
// Eager loading pour éviter N+1
$properties = Property::with(['category', 'images'])
    ->paginate(10);

// Index composites pour recherches complexes
Schema::table('properties', function (Blueprint $table) {
    $table->index(['city', 'price', 'status']);
    $table->index(['category_id', 'is_featured']);
});
```

---

## 🔮 Évolutions Techniques Prévues

### 🚀 Phase 1 : Optimisations (3 mois)

#### **Performance**

-   **Queue System** : Redis + Horizon pour jobs asynchrones
-   **CDN** : CloudFlare pour assets statiques
-   **Image Optimization** : Compression et formats modernes

#### **Monitoring**

-   **APM** : New Relic ou Datadog
-   **Error Tracking** : Sentry
-   **Uptime Monitoring** : Pingdom

### 🔧 Phase 2 : Extensibilité (6 mois)

#### **API REST**

-   **Laravel Passport** : OAuth 2.0 pour API publique
-   **API Resources** : Transformation standardisée
-   **Rate Limiting** : Protection par utilisateur/endpoint

#### **Microservices Préparation**

-   **Event Sourcing** : Journal des événements métier
-   **Message Queues** : RabbitMQ pour communication inter-services
-   **Service Discovery** : Préparation architecture distribuée

### 🤖 Phase 3 : Intelligence (12 mois)

#### **Machine Learning**

-   **Recommendation Engine** : Elasticsearch + ML
-   **Price Estimation** : Modèles prédictifs
-   **Image Recognition** : Classification automatique photos

#### **Real-time Features**

-   **WebSockets** : Laravel Websockets ou Pusher
-   **Live Updates** : Notifications temps réel
-   **Collaborative Features** : Édition collaborative

---

## 📚 Documentation Technique

### 📖 Ressources Internes

-   **[Installation et Configuration](./installation.md)** : Setup environnement
-   **[API Documentation](./api.md)** : Endpoints et authentification
-   **[Guide Base de Données](./database.md)** : Schéma et migrations

### 🔗 Références Externes

#### **Documentation Officielle**

-   [Laravel 10.x](https://laravel.com/docs/10.x)
-   [Livewire 3.x](https://livewire.laravel.com/docs)
-   [Tailwind CSS](https://tailwindcss.com/docs)
-   [Alpine.js](https://alpinejs.dev/start-here)

#### **Best Practices**

-   [Laravel Best Practices](https://github.com/alexeymezenin/laravel-best-practices)
-   [PHP Standards](https://www.php-fig.org/psr/)
-   [Tailwind Best Practices](https://tailwindcss.com/docs/reusing-styles)

---

_Documentation maintenue par l'équipe technique_  
_Dernière mise à jour : Septembre 2025_  
_Version : 1.0_
