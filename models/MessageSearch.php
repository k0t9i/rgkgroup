<?php

namespace app\models;

use yii\data\ActiveDataProvider;

class MessageSearch extends Message
{
    const PAGE_SIZE = 10;

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