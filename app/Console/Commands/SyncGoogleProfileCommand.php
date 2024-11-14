<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SyncGoogleProfileCommand extends Command
{
    protected $signature ='browser:sync-google-profiles';
    protected $description = 'Sync tmp google profiles symlinks to tmp directory';

    public function handle()
    {
        $config = config('chrome.profile');
        if (!is_dir(base_path('tmp/chrome_profiles'))) {
            symlink($config['path'], base_path('tmp/chrome_profiles'));
        }
    }
}
