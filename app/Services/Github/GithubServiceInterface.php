<?php

namespace App\Services\Github;

use App\Wrappers\Github\Repository;
use App\Wrappers\Github\User;

interface GithubServiceInterface
{
    /**
     * @return User
     */
    public function users();

    /**
     * @return Repository
     */
    public function repositories();
}
