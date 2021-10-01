<?php

namespace App\Wrappers\Github;

class User extends AbstractRequest
{
    public function show(string $username)
    {
        $response = $this->request->get("/users/{$username}");

        if ($response->failed()) {
            return null;
        }

        return $response->json();
    }
}
