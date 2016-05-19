<?php

namespace app\models;

use yii\data\ActiveDataProvider;

/**
 * Search model for Message active record
 */
class MessageSearch extends Message
{
    const PAGE_SIZE = 10;

    /**
     * Get active data provider for list action
     *
     * @param $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Message::find()
            ->where(['userId' => $this->userId]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query
        ]);
        $dataProvider->sort->defaultOrder = [
            'createdAt' => SORT_DESC
        ];
        
        $dataProvider->pagination->pageSize = self::PAGE_SIZE;
        return $dataProvider;
    }
}