<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::before(function($user) {
            if($user->roles->where('name', 'super_admin')->count())
                return true;
        });

        Gate::define('view_voucher', function ($user) {
            return $user->roles->where('name', 'view_list_billdetail_payment')->count();
        });

        Gate::define('add_voucher', function ($user) {
            return $user->roles->where('name', 'add_payment')->count();
        });

        Gate::define('modify_voucher', function ($user) {
            return $user->roles->where('name', 'modify_payment')->count();
        });

        Gate::define('delete_voucher', function ($user) {
            return $user->roles->where('name', 'delete_payment')->count();
        });
        
        Gate::define('sync_voucher', function ($user) {
            return $user->roles->whereIn('name', ['add_payment', 'modify_payment', 'delete_payment'])->count();
        });

        Gate::define('view_reports', function ($user) {
            return $user->roles->where('name', 'view_report_external_accounting')->count();
        });

        Gate::define('view_log', function ($user) {
            return $user->roles->where('name', 'view_log')->count();
        });

        Gate::define('manage_app', function ($user) {
            return $user->roles->where('name', 'contacoop_admin')->count();
        });
    }
}
