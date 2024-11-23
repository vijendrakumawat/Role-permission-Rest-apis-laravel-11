<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\User; // Import the User model
use App\Models\Post; // Import the Post model

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        // Define Gates with the correct method `define`
        // Gate::define('create-delete-users', function (User $user) {
        //     return $user->role_id === 4 || $user->role_id === 3;
        // });

        // Gate::define('create', function (User $user, Post $post) {
        //     return $user->role_id === 4 || $user->role_id === 3;
        // });

        // Gate::define('edit', function (User $user, Post $post) {
        //     return $user->role_id === 4 || $user->role_id === 3 || $user->id === $post->user_id;
        // });

        // Gate::define('delete', function (User $user) {
        //     return $user->role_id === 4;
        // });
    }
}
