<?php

namespace App\Adapters;

use App\Providers\ProviderOne;

class ProviderOneAdapter implements ProviderAdaptorInterface
{
    /**
     * @return array
     */
    public function getIssueList()
    {
        return $this->modify((new ProviderOne())->getAll());
    }

    /**
     * @param array $dataList
     * @return array
     */
    public function modify(array $dataList)
    {   $modifiedList = [];
        foreach ($dataList as $data) {
            $modifiedList[] = [
                'name' => $data['id'],
                'timing' => $data['sure'],
                'difficulty' => $data['zorluk']
            ];
        }

        return$modifiedList;
    }
}
