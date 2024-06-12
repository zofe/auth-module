<?php

namespace App\Modules\Auth\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class AuthCommand extends Command
{
    protected $signature = 'rpd:auth';

    protected $description = 'Make User model';

    public function handle()
    {
        $userModelPath = app_path('Models/User.php');
        $backupPath = app_path('Models/User.bkp.' . date('Y_m_d_His') . '.php');
        $stubPath = __DIR__.'/Templates/Models/User.stub';

        if (File::exists($userModelPath)) {
            File::move($userModelPath, $backupPath);
            $this->info("Backup for User Model: $backupPath");
        }

        File::copy($stubPath, $userModelPath);
        $this->info("User model created");
    }
}
