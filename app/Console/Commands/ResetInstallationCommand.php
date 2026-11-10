<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ResetInstallationCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:reset-install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset the system installation state to trigger a fresh start wizard';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $installedFile = storage_path('installed');

        if (file_exists($installedFile)) {
            @unlink($installedFile);
            $this->info('Installation lock file removed successfully.');
        } else {
            $this->comment('System was not marked as installed (already in fresh start mode).');
        }

        $this->info('Next time you visit the web application, you will be redirected to the Installation Wizard (/install).');

        return Command::SUCCESS;
    }
}

