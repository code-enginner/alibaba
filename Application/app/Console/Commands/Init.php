<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class Init extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:init';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Initialize Application';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->info('Running composer install...');
        exec('composer install');
        $this->info('Composer install completed.');
        //
        $this->info('Running npm install...');
        exec('npm install');
        $this->info('NPM install completed.');
        //
        $this->call('migrate');
        //
        $this->info('Database seeding...');
        exec('php artisan db:seed');
        $this->info('Database seeded.');
        //
        $this->info('Starting Laravel server...');
        exec('php artisan serve');
        $this->info('Laravel server started.');
        //
        $this->info('Compiling assets...');
        exec('npm run dev');
        $this->info('Assets compiled successfully.');
    }
}
