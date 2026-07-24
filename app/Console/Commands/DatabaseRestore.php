<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class DatabaseRestore extends Command
{
  protected $signature = 'db:restore';

  protected $description = 'Restore the most recent database backup';

  public function __construct()
  {
    parent::__construct();
  }

  public function handle()
  {
    $backups = Storage::files('app');
    $mostRecentBackup = "";
    $mostRecentBackupTimestamp = 0;
    foreach ($backups as $backup) {
      $backupTimestamp = strtotime(substr($backup, 8, -4));
      if ($backupTimestamp > $mostRecentBackupTimestamp) {
        $mostRecentBackupTimestamp = $backupTimestamp;
        $mostRecentBackup = $backup;
      }
    }

    if ($mostRecentBackup != "") {
      $command = "mysql --user=".env('DB_USERNAME')." --password=".env('DB_PASSWORD')." --host=".env('DB_HOST')." ".env('DB_DATABASE')." < storage/app/".$mostRecentBackup;
      shell_exec($command);
      $this->info('The restore was successful.');
    } else {
      $this->error('No backup found.');
    }
  }
}
