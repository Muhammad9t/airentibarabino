# Service Seeders

This directory contains individual seeders for each service, providing better maintainability and performance.

## Structure

```
database/seeders/Services/
├── ServiceSeederFactory.php      # Main factory to manage all service seeders
├── AziendeServiceSeeder.php      # AZIENDE service seeder
├── NoProfitServiceSeeder.php     # NO PROFIT service seeder
├── ServiceSeederTemplate.php     # Template for creating new service seeders
└── README.md                     # This documentation
```

## Usage

### Console Commands

```bash
# List all available services
php artisan seed:service --list

# Seed a specific service
php artisan seed:service aziende
php artisan seed:service no-profit

# Seed all services
php artisan seed:service --all
```

### Programmatic Usage

```php
use Database\Seeders\Services\ServiceSeederFactory;

$factory = new ServiceSeederFactory();

// Seed all services
$factory->run();

// Seed specific service
$factory->runService('aziende');
```

## Adding New Services

### 1. Create New Seeder

Copy `ServiceSeederTemplate.php` and rename it to `YourServiceNameSeeder.php`:

```bash
cp database/seeders/Services/ServiceSeederTemplate.php database/seeders/Services/YourServiceNameSeeder.php
```

### 2. Update the Seeder

- Change the class name
- Fill in your service data
- Update menu_order (increment for each new service)

### 3. Register the Seeder

Add your seeder to `ServiceSeederFactory.php`:

```php
$this->call([
    AziendeServiceSeeder::class,
    NoProfitServiceSeeder::class,
    YourServiceNameSeeder::class, // Add this line
]);
```

### 4. Add Console Command Mapping

Update the `getSeederClass()` method in `ServiceSeederFactory.php`:

```php
$seeders = [
    'aziende' => AziendeServiceSeeder::class,
    'no-profit' => NoProfitServiceSeeder::class,
    'your-service' => YourServiceNameSeeder::class, // Add this line
];
```

### 5. Update Available Services List

Update the `listAvailableServices()` method in `ServiceSeederFactory.php`:

```php
return [
    'aziende' => 'AZIENDE service',
    'no-profit' => 'NO PROFIT service',
    'your-service' => 'Your Service Name', // Add this line
];
```

## Benefits

- **Maintainability**: Each service is self-contained
- **Performance**: Only seed what you need
- **Modularity**: Easy to add/remove services
- **Team Collaboration**: Multiple developers can work on different services
- **Testing**: Can test individual services independently
- **Deployment**: Can deploy specific services without affecting others

## Translation Support

All seeders automatically generate translations for:
- Service names (Italian → English, French)
- Service descriptions (Italian → English, French)
- Sub-service titles (Italian → English, French)
- Sub-service points (Italian → English, French)

The `TranslationService` handles all translation logic with fallback to manual translations when Google Translate is unavailable.
