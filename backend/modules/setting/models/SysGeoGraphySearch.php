<?php

namespace backend\modules\setting\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\SysGeography;

/**
 * SysGeoGraphySearch represents the model behind the search form about `common\models\SysGeoGraphy`.
 */
class SysGeoGraphySearch extends SysGeoGraphy
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'active', 'create_time', 'create_by'], 'integer'],
            [['code', 'name_th', 'name_en'], 'safe'],
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
        $query = SysGeoGraphy::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
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
            'active' => $this->active,
            'create_time' => $this->create_time,
            'create_by' => $this->create_by,
        ]);

        $query->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 'name_th', $this->name_th])
            ->andFilterWhere(['like', 'name_en', $this->name_en]);

        return $dataProvider;
    }
}
