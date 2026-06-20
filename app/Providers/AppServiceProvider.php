<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // If running on Vercel and using SQLite, automatically create the database file and migrate it
        if (env('RUNNING_ON_VERCEL') || env('VERCEL') || isset($_SERVER['VERCEL'])) {
            // Ensure necessary directories exist in /tmp
            $dirs = [
                '/tmp/logs',
                '/tmp/uploads',
                '/tmp/framework/views',
                '/tmp/framework/cache/data',
                '/tmp/framework/sessions'
            ];
            foreach ($dirs as $dir) {
                if (!is_dir($dir)) {
                    mkdir($dir, 0755, true);
                }
            }

            if (config('database.default') === 'sqlite') {
                // Force database path to /tmp/database.sqlite on Vercel to bypass read-only filesystem
                $dbPath = '/tmp/database.sqlite';
                config(['database.connections.sqlite.database' => $dbPath]);

                if (!file_exists($dbPath)) {
                    touch($dbPath);
                    
                    try {
                        \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
                        \Illuminate\Support\Facades\Log::info('Vercel SQLite: Database created and migrated successfully.');
                    } catch (\Exception $e) {
                        \Illuminate\Support\Facades\Log::error('Vercel SQLite Migration Failed: ' . $e->getMessage());
                    }
                }
            }
        }
    }
}
