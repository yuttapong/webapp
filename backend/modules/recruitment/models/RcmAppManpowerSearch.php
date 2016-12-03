<?php

namespace backend\modules\recruitment\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * RcmAppManpowerSearch represents the model behind the search form about `backend\modules\recruitment\models\RcmAppManpower`.
 */
class RcmAppManpowerSearch extends RcmAppManpower
{
    public function rules()
    {
        return [
            [['id', 'position_id', 'department_id', 'leader_user_id', 'approver_user_id', 'approver_seq', 'user_next_id', 'company_id', 'status', 'qty', 'created_at', 'created_by'], 'integer'],
            [['code', 'reason_request', 'reason_request_text', 'data_property', 'log_status', 'date_to', 'salary'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = RcmAppManpower::find();


        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
               'defaultOrder' => ['id' => SORT_DESC]
            ]
        ]);

        if (!($this->load($params) && $this->validate())) {
            $query->where(['log_status' => RcmAppManpower::LOG_STATUS_ACTIVE]);
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'position_id' => $this->position_id,
            'department_id' => $this->department_id,
            'leader_user_id' => $this->leader_user_id,
            'approver_user_id' => $this->approver_user_id,
            'approver_seq' => $this->approver_seq,
            'user_next_id' => $this->user_next_id,
            'company_id' => $this->company_id,
            'status' => $this->status,
            'log_status' => !empty($this->log_status)?$this->log_status:RcmAppManpower::LOG_STATUS_ACTIVE,
            'date_to' => $this->date_to,
            'qty' => $this->qty,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
        ]);


        $query->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 'reason_request', $this->reason_request])
            ->andFilterWhere(['like', 'reason_request_text', $this->reason_request_text])
            ->andFilterWhere(['like', 'salary', $this->salary]);

        return $dataProvider;
    }
}
