<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Enum\UserRole;
use App\Models\User;
use Dedoc\Scramble\Scramble;
use Dedoc\Scramble\Support\Generator\OpenApi;
use Dedoc\Scramble\Support\Generator\SecurityScheme;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        Scramble::extendOpenApi(function (OpenApi $openApi) {
            $openApi->secure(
                SecurityScheme::http('bearer', 'JWT')
            );
        });

        $this->registerPolicies();

        Gate::define('super_admin', function (User $user) {
            return $user->getActiveRole()->role_code === UserRole::SUPERADMIN;
        });

        Gate::define('editor', function (User $user) {
            return $user->getActiveRole()->role_code === UserRole::EDITOR;
        });

        Gate::define('moderator', function (User $user) {
            return $user->getActiveRole()->role_code === UserRole::MODERATOR;
        });

        Gate::define('user', function (User $user) {
            return $user->getActiveRole()->role_code === UserRole::USER;
        });
    }
}
