<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Database\Seeders\Services\ServiceSeederFactory;

class SeedServiceCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'seed:service 
                            {service? : The service name to seed (aziende, no-profit, etc.)}
                            {--all : Seed all services}
                            {--list : List available services}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seed specific service or all services';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $serviceSeederFactory = new ServiceSeederFactory();

        if ($this->option('list')) {
            $this->listAvailableServices($serviceSeederFactory);
            return;
        }

        if ($this->option('all')) {
            $this->info('Seeding all services...');
            $serviceSeederFactory->run();
            $this->info('All services seeded successfully!');
            return;
        }

        $serviceName = $this->argument('service');
        
        if (!$serviceName) {
            $this->error('Please specify a service name or use --all option.');
            $this->listAvailableServices($serviceSeederFactory);
            return;
        }

        $this->info("Seeding {$serviceName} service...");
        $serviceSeederFactory->runService($serviceName);
        $this->info("{$serviceName} service seeded successfully!");
    }

    /**
     * List available services
     */
    private function listAvailableServices(ServiceSeederFactory $factory): void
    {
        $this->info('Available services:');
        $services = $factory->listAvailableServices();
        
        foreach ($services as $key => $description) {
            $this->line("  - {$key}: {$description}");
        }
        
        $this->newLine();
        $this->info('Usage examples:');
        $this->line('  php artisan seed:service aziende');
        $this->line('  php artisan seed:service no-profit');
        $this->line('  php artisan seed:service --all');
        $this->line('  php artisan seed:service --list');
    }
}
