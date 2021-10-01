<?php

namespace App\Providers;

use App\Services\Github\GithubService;
use App\Services\Github\GithubServiceInterface;
use Illuminate\Support\ServiceProvider;

class GithubServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(GithubServiceInterface::class, GithubService::class);
    }

    public function boot()
    {
        //
    }
}
