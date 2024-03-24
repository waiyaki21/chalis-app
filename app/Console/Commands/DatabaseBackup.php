<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;

class DatabaseBackup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'database:backup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This Command backs up the local Database';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $filename = "Backup-" . Carbon::now()->format('d-m-y') . ".sql";

        $command =  "" . env('DUMP_PATH') .
            " -u" . env('DB_USERNAME') .
            " " . env('DB_DATABASE') .
            " >  C:\Users\Waiyaki^ Kelvin\Desktop\projects\Kim^ Project\writers-app\public\backup\database\DB_" . $filename;

        $returnVar = NULL;
        $output = NULL;

        exec($command, $output, $returnVar);
    }
}
