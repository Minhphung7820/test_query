<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\File;

class MacroServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        foreach (File::allFiles(app_path('Macros')) as $file) {
            require_once $file->getPathname();
        }
    }

    public function boot(): void
    {
        //
    }
}
