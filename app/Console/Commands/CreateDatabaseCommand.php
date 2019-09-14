<?php

namespace App\Console\Commands;

use DB;
use Illuminate\Console\Command;

class CreateDatabaseCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mysql:createdb';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new mysql database';

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
     * @return mixed
     */
    public function handle()
    {
        $schema = config('database.connections.mysql.database');
        $charset = config('database.connections.mysql.charset', 'utf8mb4');
        $collation = config('database.connections.mysql.collation', 'utf8mb4_unicode_ci');

        config(["database.connections.mysql.database" => null]);

        $query = "CREATE DATABASE IF NOT EXISTS $schema CHARACTER SET $charset COLLATE $collation;";
        DB::statement($query);

        config(["database.connections.mysql.database" => $schema]);

        $this->info("Created database: {$schema}.");
    }
}
