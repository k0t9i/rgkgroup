<?php

namespace app\models;

use yii\data\ActiveDataProvider;

/**
 * Search model for Article active record
 *
 * @package app\models
 */
class ArticleSearch extends Article
{
    const PAGE_SIZE = 10;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['title', 'safe']
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
        $query = Article::find();

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
