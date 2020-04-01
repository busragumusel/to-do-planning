<?php

namespace App\Providers;

use Symfony\Component\HttpClient\HttpClient;

class ProviderOne
{
    public function getAll()
    {
        $client = HttpClient::create();
        try {
            return $client->request('GET', 'http://www.mocky.io/v2/5d47f24c330000623fa3ebfa')->toArray();
        } catch (\Exception $exception) {
            return null;
        }
    }
}