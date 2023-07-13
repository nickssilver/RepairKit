<?php

namespace App\Console\Commands\Install;

use Exception;
use Illuminate\Console\Command;

class InitializeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'install:initialize';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Execute the actions to perform the system installation';

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
     * @throws Exception
     */
    public function handle()
    {
        $this->info('Welcome to Repair box');

        $this->call('down');

        $this->info('Step 1 of 7 - Creating the database tables');
        $this->call('migrate');

        $this->info('Step 2 of 7 - Introducing the data in the database');
        $this->call('db:seed');

        $this->info('Step 3 of 7 - Generating the unique key of the application');
        $this->call('key:generate');

        $this->info('Step 4 of 7 - Making storage link');
        $this->call('storage:link');
        $this->info('Step 5 of 7 - Setting up permissions');

        \File::chmod('../storage/framework');
        \File::chmod('../storage/logs');
        \File::chmod('../bootstrap/cache');

        $data = json_encode(
            [
                'date' => date('Y/m/d h:i:s'),
            ],
            JSON_THROW_ON_ERROR
        );

        file_put_contents(storage_path('installed'), $data, FILE_APPEND | LOCK_EX);

        $this->info('Step 6 of 7 - Optimization and clear cache');
        $this->call('route:clear');
        $this->call('cache:clear');
        $this->call('config:clear');
        $this->call('view:clear');
        $this->call('optimize:clear');
        $this->info('Step 7 of 7 - Turning up application live');
        $this->call('up');
        $this->info('Installation completed successfully');
        $this->info('Thank you for purchasing and using our product.');
        return true;
    }
}
