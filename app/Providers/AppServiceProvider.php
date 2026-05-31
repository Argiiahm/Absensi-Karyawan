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

    public function boot(): void
    {
        view()->composer(['components.layout-admin', 'components.features.admin.dashboard.index'], function ($view) {
            if (auth()->check() && auth()->user()->role === 'admin') {
                $pendingLeavesCount = \App\Models\Leave::where('status', 'pending')->count();
                $pendingSubmissionsCount = \App\Models\Submission::where('status', 'pending')->count();
                $view->with([
                    'pendingLeavesCount' => $pendingLeavesCount,
                    'pendingSubmissionsCount' => $pendingSubmissionsCount,
                    'totalPendingNotificationsCount' => $pendingLeavesCount + $pendingSubmissionsCount,
                ]);
            }
        });
    }
}
