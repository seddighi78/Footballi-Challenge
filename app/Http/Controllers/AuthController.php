<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\DefaultResource;
use App\Models\User;
use App\Repository\UserRepositoryInterface;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(LoginRequest $request, UserRepositoryInterface $users)
    {
        $user = $users->findByUsername($request->username);

        if (!$user) {
            throw new AuthorizationException(__('auth.failed'));
        }

        if (!$this->isPasswordValid($user, $request->password)) {
            throw new AuthorizationException(__('auth.failed'));
        }

        return new DefaultResource(['access_token' => auth('api')->login($user)]);
    }

    private function isPasswordValid(User $user, string $password): bool
    {
        return Hash::check($password, $user->password);
    }

    public function register(RegisterRequest $request, UserRepositoryInterface $users)
    {
        $data = $request->only(['name', 'username']);
        $data['password'] = Hash::make($request->password);

        $user = $users->create($data);

        return new DefaultResource(['access_token' => auth('api')->login($user)]);
    }
}
