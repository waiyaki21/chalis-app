<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

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
        $databasePath = database_path('database.sqlite'); // Path to the SQLite database file
        $backupPath   = public_path('backup');         // Path to store the backup files

        // Create the backup directory if it doesn't exist
        if (!File::exists($backupPath)) {
            File::makeDirectory($backupPath, 0755, true);
        }

        // Generate a unique backup filename
        $filename = "Backup-" . Carbon::now()->format('d-m-y-h-m-s') . ".sqlite";
        $destination = $backupPath . '/' . $filename;

        // Copy the database file to the backup location
        File::copy($databasePath, $destination);

        $this->info("Database backup created successfully at: " . $destination);
    }
}
