<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Support\Facades\Artisan;

class Install extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'software:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install this software without issues, Thanks!';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            DB::connection();
        } catch (Exception $e) {
            $this->error('Unable to connect to database.');
            $this->error('Please fill valid database credentials into .env and rerun this command.');
            return;
        }
        if (!env('APP_KEY')) {
            $this->info('Generating app key');
            Artisan::call('key:generate');
        } else {
            $this->comment('App key exists -- skipping...');
        }
        $this->info('Migrating database...');

        Artisan::call('migrate', ['--force' => true]);

        $this->comment('Database Migrated Successfully...');

        $this->info('Seeding DB data...');

        Artisan::call('db:seed', ['--force' => true]);
        Artisan::call('storage:link', ['--force' => true]);

        $this->comment('Database Seeded Successfully...');
        $this->comment('Successfully Installed! Started Software URL: localhost:8000 / 127.0.0.1:8000');
        Artisan::call('serve');
    }
}
