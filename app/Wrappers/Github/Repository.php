<?php

namespace App\Wrappers\Github;

class Repository extends AbstractRequest
{
    public function starred(string $username, int $page = 1, int $perPage = 100)
    {
        $data = ['page' => $page, 'per_page' => $perPage];
        $response = $this->request->get("/users/{$username}/starred", $data);

        if ($response->failed()) {
            return null;
        }

        return $response->json();
    }
}
