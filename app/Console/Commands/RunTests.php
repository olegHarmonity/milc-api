<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class RunTests extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'run:tests {dbName?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command for running php tests with database setup';

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
        $this->info("\nCreating database...\n");

        $this->call('db:create');

        $this->info("\nInstalling migrations...\n");

    //    $this->call('migrate:install');

        $this->info("\nRunning migrations...\n");

        $this->call('migrate:fresh');

        $this->info("\nRunning seeders...\n");

        $this->call('db:seed');

        $this->info("\nClearing cache...\n");

        $this->call('cache:clear');
        $this->call('config:cache');
        $this->call('route:cache');

        $this->info("\nRunning tests...\n");

        $this->call('test');

        return 0;
    }
}
