<?php

namespace app\models;

use app\models\notification\Notification;
use yii\data\ActiveDataProvider;

class NotificationSearch extends Notification
{
    const PAGE_SIZE = 10;

    public function rules()
    {
        return [
            [['title', 'recipientId', 'senderId', 'eventName'], 'safe']
        ];
    }

    public function search($params)
    {
        $query = Notification::find()
            ->with(['recipient', 'sender']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query
        ]);
        $dataProvider->sort->defaultOrder = [
            'createdAt' => SORT_DESC
        ];

        if ($this->load($params)) {
            $query->andWhere(['like', 'title', $this->title]);
        }

        $dataProvider->pagination->pageSize = self::PAGE_SIZE;
        return $dataProvider;
    }
}