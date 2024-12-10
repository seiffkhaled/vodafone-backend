<?php

namespace App\Providers;

use App\Console\Commands\SendTaskReports;
use App\Models\Task;
use App\Policies\TaskPolicy;
use Illuminate\Support\Facades\Gate;
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
        Gate::policy(Task::class,TaskPolicy::class);
        $this->commands([
            SendTaskReports::class,
        ]);
    }
}
