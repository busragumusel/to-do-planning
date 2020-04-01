<?php

namespace App\Adapters;

interface ProviderAdaptorInterface
{
    public function getIssueList();
    public function modify(array $datalist);
}
