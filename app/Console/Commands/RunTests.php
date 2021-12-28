<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Process\InputStream;
use Symfony\Component\Console\Input\ArrayInput;

class RunTests extends Command
{

    protected $signature = 'run:tests {--filter=}  {--env=}';

    protected $description = 'Command for running php tests with database setup';

    public function __construct(){
        parent::__construct();
    }
    
    public function handle()
    {
        $updateDatabase = $this->option('env');
        $filter = $this->option('filter');

        $this->info("\nCreating database...\n");

        $this->call('db:create');

        if (! empty($updateDatabase)) {

            $this->info("\nDeleting database dump...\n");

            $this->call('snapshot:delete', [
                'name' => 'test-db-dump'
            ]);

            $this->info("\nRunning migrations...\n");

            $this->call('migrate:fresh');

            $this->info("\nRunning seeders...\n");

            $this->call('db:seed');

            $this->info("\nDumping database...\n");

            $this->call('snapshot:create', [
                'name' => 'test-db-dump',
                '--compress' => true
            ]);
        } else {
            $this->call('snapshot:load', [
                'name' => 'test-db-dump'
            ]);
        }

        $this->info("\nClearing cache...\n");

        $this->call('cache:clear');
        $this->call('config:cache');
        $this->call('route:cache');

        $this->info("\nRunning tests...\n");
        
        $this->call('test', [
            '--filter' => $filter,
        ]);

        return 0;
    }
}
