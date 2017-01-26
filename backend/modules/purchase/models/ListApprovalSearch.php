<?php

namespace backend\modules\purchase\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;


/**
 * InventorySearch represents the model behind the search form about `backend\modules\purchase\Models\Inventory`.
 */
class ListApprovalSearch extends ListApproval
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['job_list_id', 'created_at', 'created_by', 'updated_at', 'updated_by', 'active', 'approve_user_id', 'approve_seq'], 'integer'],
            [['description', 'requestBy', 'approve_name'], 'string'],
            [['subject','approve_status'], 'string'],

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
        $query = ListApproval::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['id' => SORT_DESC]]
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
            'job_list_id' => $this->job_list_id,
            'approve_user_id' => $this->approve_user_id,
            'approve_status' => $this->approve_status,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
            'active' => $this->active,
        ]);

        $query->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 'subject', $this->subject])
            ->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }

}
