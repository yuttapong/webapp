<?php

namespace backend\modules\purchase\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\purchase\models\PoinDetail;

/**
 * PoinDetailSearch represents the model behind the search form about `backend\modules\fix\Models\PoinDetail`.
 */
class PoinDetailSearch extends PoinDetail
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'project_id', 'site_id', 'poin_id', 'prin_detail_id', 'inventory_id', 'unit_id', 'status', 'vendor_id', 'home_id', 'job_list_id', 'is_deductions'], 'integer'],
            [['inventory_name', 'unit_name', 'job_name'], 'safe'],
            [['qty', 'price'], 'number'],
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
        $query = PoinDetail::find();

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
            'project_id' => $this->project_id,
            'site_id' => $this->site_id,
            'poin_id' => $this->poin_id,
            'prin_detail_id' => $this->prin_detail_id,
            'inventory_id' => $this->inventory_id,
            'qty' => $this->qty,
            'unit_id' => $this->unit_id,
            'price' => $this->price,
            'status' => $this->status,
            'vendor_id' => $this->vendor_id,
            'home_id' => $this->home_id,
            'job_list_id' => $this->job_list_id,
            'is_deductions' => $this->is_deductions,
        ]);

        $query->andFilterWhere(['like', 'inventory_name', $this->inventory_name])
            ->andFilterWhere(['like', 'unit_name', $this->unit_name])
            ->andFilterWhere(['like', 'job_name', $this->job_name]);

        return $dataProvider;
    }
}
