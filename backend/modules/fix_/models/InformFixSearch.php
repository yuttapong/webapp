<?php

namespace backend\modules\fix\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\fix\models\InformFix;

/**
 * InformFixSearch represents the model behind the search form about `backend\modules\fix\Models\InformFix`.
 */
class InformFixSearch extends InformFix
{

    public $plan_no;
    public $home_no;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'project_id', 'home_id', 'seq', 'date_inform', 'customer_id', 'job_status', 'job_sub_status', 'work_status', 'created_at', 'created_by', 'type'], 'integer'],
            [['telephone', 'description', 'customer_name', 'plan_no', 'home_no'], 'safe'],
        ];
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
        $query = InformFix::find();
        $query->joinWith(['home']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => [
                'id' => SORT_DESC,
            ]
            ]
        ]);
        $query->andFilterWhere([
            'is_delete' => 0,
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
            'fix_inform_fix.project_id' => $this->project_id,
            'home_id' => $this->home_id,
            'seq' => $this->seq,
            'date_inform' => $this->date_inform,
            'customer_id' => $this->customer_id,
            'job_status' => $this->job_status,
            'job_sub_status' => $this->job_sub_status,
            'work_status' => $this->work_status,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'type' => $this->type,
        ]);

        $query
            ->andFilterWhere(['like', 'sys_home.plan_no', $this->plan_no])
            ->andFilterWhere(['like', 'sys_home.home_no', $this->home_no])
            ->andFilterWhere(['like', 'telephone', $this->telephone])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'customer_name', $this->customer_name]);

        return $dataProvider;
    }
}
