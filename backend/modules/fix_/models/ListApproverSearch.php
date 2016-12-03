<?php

namespace backend\modules\fix\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\fix\models\ListApprover;

/**
 * ListApproverSearch represents the model behind the search form about `backend\modules\fix\Models\ListApprover`.
 */
class ListApproverSearch extends ListApprover
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'inform_fix_id', 'approver_user_id', 'approver_seq', 'user_next_id', 'created_at', 'created_by', 'approval_status'], 'integer'],
            [['description'], 'safe'],
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
        $query = ListApprover::find();

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
            'approver_user_id' => $this->approver_user_id,
            'approver_seq' => $this->approver_seq,
            'user_next_id' => $this->user_next_id,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'approval_status' => $this->approval_status,
        ]);

        $query->andFilterWhere(['like', 'description', $this->description])  ;

        return $dataProvider;
    }
}
