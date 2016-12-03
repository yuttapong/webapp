<?php

namespace backend\modules\setting\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\SysTambon;

/**
 * SysTambonSearch represents the model behind the search form about `common\models\SysTambon`.
 */
class SysTambonSearch extends SysTambon
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'province_id', 'amphur_id', 'geography_id', 'active', 'created_at', 'created_by'], 'integer'],
            [['code', 'name_th', 'amphur_code', 'province_code', 'zip_cpde', 'master_id'], 'safe'],
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
        $query = SysTambon::find();

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
            'province_id' => $this->province_id,
            'amphur_id' => $this->amphur_id,
            'geography_id' => $this->geography_id,
            'active' => $this->active,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
        ]);

        $query->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 'name_th', $this->name_th])
            ->andFilterWhere(['like', 'amphur_code', $this->amphur_code])
            ->andFilterWhere(['like', 'province_code', $this->province_code])
            ->andFilterWhere(['like', 'zip_cpde', $this->zip_cpde])
            ->andFilterWhere(['like', 'master_id', $this->master_id]);

        return $dataProvider;
    }
}
