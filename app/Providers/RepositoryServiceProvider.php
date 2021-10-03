<?php

namespace App\Providers;

use App\Repository\Eloquent\RepositoryRepository;
use App\Repository\Eloquent\UserRepository;
use App\Repository\RepositoryRepositoryInterface;
use App\Repository\UserRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(RepositoryRepositoryInterface::class, RepositoryRepository::class);
    }

    public function boot()
    {
        //
    }
}
