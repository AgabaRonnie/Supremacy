<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Yaza\LaravelGoogleDriveStorage\Gdrive;
use ZipArchive;

class DatabaseBackup extends Command
{
  protected $signature = 'db:backup';
  protected $description = 'Backup the database and zip the file';

  public function __construct()
  {
    parent::__construct();
  }

  public function handle()
  {
    // Define file paths
    $filename = 'backup-' . date('Y-m-d_H-i-s') . '.sql';
    $filepath = storage_path('app/' . $filename);

    $zipFilename = $filename . '.zip';
    $zipPath = public_path(env("GOOGLE_DRIVE_FOLDER")."/".$zipFilename);

    //if the folder does not exist, create it
    if (!file_exists(public_path(env("GOOGLE_DRIVE_FOLDER")))) {
      mkdir(public_path(env("GOOGLE_DRIVE_FOLDER")), 0777, true);
    }

    // Export the database
    $command = sprintf(
      'mysqldump --user=%s --password=%s --host=%s %s > %s',
      env('DB_USERNAME'),
      env('DB_PASSWORD'),
      env('DB_HOST'),
      env('DB_DATABASE'),
      $filepath
    );

    exec($command);

    // Zip the exported file
    $zip = new ZipArchive();
    if ($zip->open($zipPath, ZipArchive::CREATE) === TRUE) {
      $zip->addFile($filepath, $filename);
      $zip->close();
    }

    // Delete the original SQL file
    unlink($filepath);


    $fileSizeBytes = filesize($zipPath);
    $fileSizeMB = $fileSizeBytes / 1048576;
    $fileTotalMB = number_format($fileSizeMB, 2);

    //JUST IN CASE U WANT TO SEND EMAIL --------------------------------------------------------------------
    //"Prime Learn Database Backed Up",
    //"The system requests that you download a copy of the zipped database from https://api.prime-learn.com/$zipFilename and its size is $fileTotalMB MB."

    //Upload to drive
    Gdrive::put( env("APP_NAME") .'/'.$zipFilename, $zipPath );


    $this->info('Database backup and zip completed successfully.');
  }
}
