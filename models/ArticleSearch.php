<?php

namespace app\models;

use yii\data\ActiveDataProvider;

class ArticleSearch extends Article
{
    public function rules()
    {
        return [
            ['title', 'safe']
        ];
    }

    public function search($params)
    {
        $query = Article::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query
        ]);
        $dataProvider->sort->defaultOrder = [
            'createdAt' => SORT_ASC
        ];

        if ($this->load($params)) {
            $query->andWhere(['like', 'title', $this->title]);
        }

        return $dataProvider;
    }
}