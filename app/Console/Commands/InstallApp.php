<?php

namespace App\Console\Commands;

use App\Services\Installation\AppInstallationService;
use Illuminate\Console\Command;

class InstallApp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:install {--default}';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install Base Application';

    /**
     * Create a new command instance.
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
        $service = app(AppInstallationService::class);
        $this->info('Welcome to the Installer, please provide the following information');
        if (! $this->option('default')) {
            $firstName = $this->ask('What is the Admininstrator\'s first name?');
            $lastName = $this->ask('What is the Admininstrator\'s last name?');
            $username = $this->ask('What is the Admininstrator\'s username?');
            $email = $this->ask('What is the Admininstrator\'s email?');
            $password = $this->ask('What is the Admininstrator\'s password?');
        } else {
            $firstName = 'Admin';
            $lastName = 'D&T';
            $username = 'admin';
            $email = 'admin@domandtom.com';
            $password = '123456789qq';
        }

        $this->info('Installing the app');
        $service->installApp([
            'first_name' => $firstName,
            'last_name' => $lastName,
            'username' => $username,
            'email' => $email,
            'password' => $password,
            'password_confirmation' => $password,
        ]);

        $this->info('All Done');
    }
}
