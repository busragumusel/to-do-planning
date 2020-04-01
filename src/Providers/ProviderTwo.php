<?php

namespace App\Providers;

use Symfony\Component\HttpClient\HttpClient;

class ProviderTwo
{
    public function get()
    {
        $client = HttpClient::create();
        try {
            return $client->request('GET', 'http://www.mocky.io/v2/5d47f235330000623fa3ebf7')->toArray();
        } catch (\Exception $exception) {
            return null;
        }
    }
}