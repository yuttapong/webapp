<?php

namespace backend\modules\setting\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\SysAmphur;

/**
 * SysAmphurSearch represents the model behind the search form about `common\models\SysAmphur`.
 */
class SysAmphurSearch extends SysAmphur
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'geography_id', 'province_id','active', 'create_at', 'create_by'], 'integer'],
            [['code', 'name_th', 'province_code', 'master_id'], 'safe'],
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
        $query = SysAmphur::find();

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
            'geography_id' => $this->geography_id,
            'province_id' => $this->province_id,
            'active' => $this->active,
            'create_at' => $this->create_at,
            'create_by' => $this->create_by,
        ]);

        $query->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 'name_th', $this->name_th])
            ->andFilterWhere(['like', 'province_code', $this->province_code])
            ->andFilterWhere(['like', 'master_id', $this->master_id]);

        return $dataProvider;
    }
}
