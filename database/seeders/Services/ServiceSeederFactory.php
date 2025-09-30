<?php

namespace Database\Seeders\Services;

use Illuminate\Database\Seeder;
use App\Models\Service;
use App\Models\SubService;

class ServiceSeederFactory extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing data (handle foreign key constraints)
        SubService::query()->delete();
        Service::query()->delete();

        // Run all service seeders
        $this->call([
            AziendeServiceSeeder::class,
            NoProfitServiceSeeder::class,
            PrivatiFamiglieServiceSeeder::class,
            SocietaEstereServiceSeeder::class,
            // All services are now complete!
        ]);
    }

    /**
     * Run specific service seeder
     */
    public function runService(string $serviceName): void
    {
        $seederClass = $this->getSeederClass($serviceName);
        
        if ($seederClass) {
            $this->call([$seederClass]);
        } else {
            $this->command->error("Service seeder for '{$serviceName}' not found.");
        }
    }

    /**
     * Get seeder class name for a service
     */
    private function getSeederClass(string $serviceName): ?string
    {
        $seeders = [
            'aziende' => AziendeServiceSeeder::class,
            'no-profit' => NoProfitServiceSeeder::class,
            'no_profit' => NoProfitServiceSeeder::class,
            'noprofit' => NoProfitServiceSeeder::class,
            'privati-famiglie' => PrivatiFamiglieServiceSeeder::class,
            'privati_famiglie' => PrivatiFamiglieServiceSeeder::class,
            'privatifamiglie' => PrivatiFamiglieServiceSeeder::class,
            'societa-estere' => SocietaEstereServiceSeeder::class,
            'societa_estere' => SocietaEstereServiceSeeder::class,
            'societaestere' => SocietaEstereServiceSeeder::class,
            'foreign-companies' => SocietaEstereServiceSeeder::class,
            'foreign_companies' => SocietaEstereServiceSeeder::class,
            'foreigncompanies' => SocietaEstereServiceSeeder::class,
        ];

        return $seeders[strtolower($serviceName)] ?? null;
    }

    /**
     * List all available service seeders
     */
    public function listAvailableServices(): array
    {
        return [
            'aziende' => 'AZIENDE service',
            'no-profit' => 'NO PROFIT service',
            'privati-famiglie' => 'Privati e Famiglie service',
            'societa-estere' => 'Società Estere service',
            // All services are now complete!
        ];
    }
}
