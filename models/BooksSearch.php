<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Books;

/**
 * BooksSearch represents the model behind the search form about `app\models\Books`.
 */
class BooksSearch extends Books {

    public $date_from;
    public $date_to;

    /**
     * @inheritdoc
     */
    public function attributes() {
        return array_merge(parent::attributes(), ['authors.firstname']);
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['id', 'author_id'], 'integer'],
            [['name', 'date_create', 'date_update', 'preview', 'date', 'date_from', 'date_to', 'authors.firstname'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios() {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params) {
        $query = Books::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['authors.firstname'] = [
            'asc' => ['authors.firstname' => SORT_ASC],
            'desc' => ['authors.firstname' => SORT_DESC],
        ];

        $query->joinWith(['authors']);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'date_create' => $this->date_create,
            'date_update' => $this->date_update,
//            'date' => $this->date,
            'author_id' => $this->author_id ? $this->author_id : '',
        ]);


        $query->andFilterWhere(['like', 'name', $this->name])
                ->andFilterWhere(['like', 'preview', $this->preview]);

        if (!empty($this->date_from))
            $query->andFilterWhere(['>', 'date', date('Y-m-d', strtotime(str_replace('/', '-', $this->date_from)))]);
        if (!empty($this->date_to))
            $query->andFilterWhere(['<', 'date', date('Y-m-d', strtotime(str_replace('/', '-', $this->date_to)))]);

        return $dataProvider;
    }

}
