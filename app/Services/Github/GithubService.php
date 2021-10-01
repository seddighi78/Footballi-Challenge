<?php

namespace App\Services\Github;

use App\Wrappers\Github\Repository;
use App\Wrappers\Github\User;

class GithubService implements GithubServiceInterface
{
    public function users()
    {
        return new User();
    }

    public function repositories()
    {
        return new Repository();
    }
}
