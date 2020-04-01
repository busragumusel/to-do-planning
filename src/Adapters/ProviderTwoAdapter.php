<?php

namespace App\Adapters;

use App\Providers\ProviderTwo;

class ProviderTwoAdapter implements ProviderAdaptorInterface
{
    /**
     * @return array
     */
    public function getIssueList()
    {
        return $this->modify((new ProviderTwo())->get());
    }

    /**
     * @param array $dataList
     * @return array
     */
    public function modify(array $dataList)
    {
        $modifiedList = [];
        foreach ($dataList as $data) {
            foreach ($data as $key => $val) {
                $modifiedList[] = [
                    'name' => $key,
                    'timing' => $val['estimated_duration'],
                    'difficulty' => $val['level']
                ];
            }
        }

        return$modifiedList;
    }
}
