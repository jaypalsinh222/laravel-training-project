<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use function GuzzleHttp\Promise\all;

class DatabaseBackUp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:backup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $path = storage_path() . '\app\backup\\';
        if (!File::isDirectory($path)) {
            File::makeDirectory($path, 0777, true);
        }
        $filename = env('APP_NAME') . '_' . env('DB_DATABASE') . '_' . Carbon::now()->format('Y-m-d-H-i-s') . ".sql";

        //Save latest sql file in storage/backup folder.
        $command = "C:\\xampp\mysql\bin\mysqldump.exe --user=" . env('DB_USERNAME') . " --password=" . env('DB_PASSWORD') . " --host=" . env('DB_HOST') . " " . env('DB_DATABASE') . " > " . $path . $filename;
        $returnVar = NULL;
        $output = NULL;
        exec($command, $output, $returnVar);

        //Deleting oldest file from storage.
        $files = collect(Storage::disk()->listContents('backup', true))->sortByDesc('lastModified')->pluck('path')->all();//->pop(1)->all();
        $deletedFile = min($files);
        if (count(collect(Storage::disk()->listContents('backup', true))->all()) > 3) {
            if (!empty($deletedFile)) {
                $deleteFile = storage_path("app/" . $deletedFile);
                if (File::exists($deleteFile)) {
                    File::delete($deleteFile);
                }
            }
        }
    }
}
