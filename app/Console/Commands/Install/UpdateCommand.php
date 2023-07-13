<?php

namespace App\Console\Commands\Install;

use Exception;
use Illuminate\Console\Command;

class UpdateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'install:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Execute the actions to perform the system update';

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
        $this->call('down');

        $this->info('Step 1 of 3 - Creating the database tables');
        $this->call('migrate', ['--force' => true]);

        $this->info('Step 2 of 3 - Introducing the data in the database');
        $this->call('db:seed', ['--force' => true]);

        $this->info('Step 3 of 3 - Update cache');
        $this->call('route:clear');
        $this->call('cache:clear');
        $this->call('config:clear');
        $this->call('view:clear');
        $this->call('optimize:clear');

        $data = json_encode(
            [
                'date' => date('Y/m/d h:i:s'),
            ],
            JSON_THROW_ON_ERROR
        );

        file_put_contents(storage_path('installed'), $data, FILE_APPEND | LOCK_EX);

        $this->call('up');
        $this->info('Update completed successfully');
        return true;
    }
}
