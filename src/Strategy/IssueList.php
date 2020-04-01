<?php

namespace App\Strategy;

use App\Adapters\ProviderAdaptorInterface;

class IssueList
{
    private $providerAdaptor;

    public function __construct(ProviderAdaptorInterface $providerAdaptor)
    {
        $this->providerAdaptor = $providerAdaptor;
    }

    /**
     * @return mixed
     */
    public function getAll()
    {
        return $this->providerAdaptor->getIssueList();
    }
}
