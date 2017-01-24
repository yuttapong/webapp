<?php

namespace backend\modules\purchase\Models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\purchase\models\PrinDetail;

/**
 * PrinDetailSearch represents the model behind the search form about `backend\modules\fix\Models\PrinDetail`.
 */
class PrDetailSearch extends PrDetail
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'project_id', 'prin_id','unit_id', 'inventory_id', 'status','is_confirm', 'vendor_id', 'home_id', 'job_list_id', 'is_deductions'], 'integer'],
            [['code_po', 'inventory_name', 'job_name'], 'safe'],
            [['qty'], 'number'],
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
        $query = PrinDetail::find();

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
            'prin_id' => $this->prin_id,
            'inventory_id' => $this->inventory_id,
            'qty' => $this->qty,
            'status' => $this->status,
        	'is_confirm' => $this->is_confirm,
            'vendor_id' => $this->vendor_id,
            'home_id' => $this->home_id,
            'job_list_id' => $this->job_list_id,
            'is_deductions' => $this->is_deductions,
        ]);

        $query->andFilterWhere(['like', 'code_po', $this->code_po])
            ->andFilterWhere(['like', 'inventory_name', $this->inventory_name])
            ->andFilterWhere(['like', 'job_name', $this->job_name]);

        return $dataProvider;
    }
}
