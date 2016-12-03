<?php

namespace backend\modules\fix\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\fix\models\InformJob;

/**
 * InformJobSearch represents the model behind the search form about `backend\modules\fix\Models\InformJob`.
 */
class InformJobSearch extends InformJob
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'inform_fix_id', 'status', 'job_list_id', 'created_at', 'created_by', 'responsible_id', 'job_status', 'apprever_type'], 'integer'],
            [['list', 'description', 'responsible_name'], 'safe'],
            [['pate_price', 'net_price'], 'number'],
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
        $query = InformJob::find();

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
            'inform_fix_id' => $this->inform_fix_id,
            'status' => $this->status,
            'job_list_id' => $this->job_list_id,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'responsible_id' => $this->responsible_id,
            'job_status' => $this->job_status,
            'pate_price' => $this->pate_price,
            'net_price' => $this->net_price,
            'apprever_type' => $this->apprever_type,
        ]);

        $query->andFilterWhere(['like', 'list', $this->list])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'responsible_name', $this->responsible_name]);

        return $dataProvider;
    }
}
