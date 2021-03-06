<?php

namespace backend\modules\fix\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Home;

/**
 * HomeSearch represents the model behind the search form about `common\models\Home`.
 */
class HomeSearch extends Home
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'project_id',  'status', 'home_status', 'compact_status', 'transfer_status', 'created_at', 'created_by', 'date_insurance'], 'integer'],
            [['plan_no', 'home_no', 'type'], 'safe'],
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
        		 'sort' => ['defaultOrder'=>[
        		 	'project_id' => SORT_ASC,
           			 'home_no' => SORT_ASC,
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
            'plan_no' => $this->plan_no,
            'home_price' => $this->home_price,
            'land' => $this->land,
            'use_area' => $this->use_area,
            'home_status' => $this->home_status,
            'compact_status' => $this->compact_status,
            'transfer_status' => $this->transfer_status,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'date_insurance' => $this->date_insurance,
        ]);

        $query->andFilterWhere(['like', 'home_no', $this->home_no])

            ->andFilterWhere(['like', 'type', $this->type]);

        return $dataProvider;
    }
}
