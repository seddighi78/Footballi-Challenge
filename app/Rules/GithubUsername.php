<?php

namespace App\Rules;

use App\Services\Github\GithubServiceInterface;
use Illuminate\Contracts\Validation\Rule;

class GithubUsername implements Rule
{
    private GithubServiceInterface $github;

    public function __construct()
    {
        $this->github = app()->make(GithubServiceInterface::class);
    }

    public function passes($attribute, $value)
    {
        $user = $this->github->users()->show($value);

        return !is_null($user);
    }

    public function message()
    {
        return __('validation.custom.github-username');
    }
}
