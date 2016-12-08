<?php

namespace backend\modules\setting\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Home;

/**
 * HomeUnitSearch represents the model behind the search form of `common\models\home`.
 */
class HomeUnitSearch extends Home
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'project_id',  'status', 'home_status', 'compact_status', 'transfer_status', 'created_at', 'created_by', 'date_insurance', 'customer_id'], 'integer'],
            [['plan_no', 'home_no', 'type', 'customer_name'], 'safe'],
            [['home_price', 'land', 'use_area'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
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
    public function search($params)
    {
        $query = Home::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'project_id' => SORT_DESC,
                    'plan_no' => SORT_DESC,
                ]
            ]
        ]);

        $this->load($params);



        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'project_id' => $this->project_id,
            'status' => $this->status,
            'home_price' => $this->home_price,
            'land' => $this->land,
            'use_area' => $this->use_area,
            'home_status' => $this->home_status,
            'compact_status' => $this->compact_status,
            'transfer_status' => $this->transfer_status,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'date_insurance' => $this->date_insurance,
            'customer_id' => $this->customer_id,
        ]);

        $query->andFilterWhere(['like', 'plan_no', $this->plan_no])
            ->andFilterWhere(['like', 'home_no', $this->home_no])
            ->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'customer_name', $this->customer_name]);

        return $dataProvider;
    }
}
