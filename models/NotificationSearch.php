<?php

namespace app\models;

use app\models\notification\Notification;
use yii\data\ActiveDataProvider;

/**
 * Search model for Notification active record
 */
class NotificationSearch extends Notification
{
    const PAGE_SIZE = 10;

    public function rules()
    {
        return [
            [['name', 'eventName'], 'safe']
        ];
    }

    /**
     * Get active data provider for list action
     *
     * @param $params
     * @return ActiveDataProvider
     */
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
            $query->andFilterWhere(['like', 'name', $this->name]);
            $query->andFilterWhere(['eventName' => $this->eventName]);
        }

        $dataProvider->pagination->pageSize = self::PAGE_SIZE;
        return $dataProvider;
    }
}