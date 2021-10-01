<?php

namespace App\Wrappers\Github;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;

abstract class AbstractRequest
{
    protected PendingRequest $request;

    public function __construct()
    {
        $url = Config::get('github.url');
        $this->request = Http::baseUrl($url);
    }
}
