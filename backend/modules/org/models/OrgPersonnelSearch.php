<?php

namespace backend\modules\org\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\org\models\OrgPersonnel;

/**
 * OrgPersonnelSearch represents the model behind the search form about `backend\modules\org\models\OrgPersonnel`.
 */
class OrgPersonnelSearch extends OrgPersonnel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['q'], 'string'],
            [['id', 'prefix_id', 'day_probation', 'idcard_province_id', 'idcard_amphur_id', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['code', 'prefix_name_th', 'prefix_name_en', 'firstname_th', 'firstname_en', 'middlename_th', 'middlename_en', 'lastname_th', 'lastname_en', 'birthday', 'work_status', 'work_type', 'status', 'nationality', 'race', 'religion', 'idcard', 'blood', 'living_status', 'marriage_status', 'idcard_date_expiry', 'military_status', 'nickname'], 'safe'],
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
        $query = OrgPersonnel::find();

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
            'prefix_id' => $this->prefix_id,
            'birthday' => $this->birthday,
            'day_probation' => $this->day_probation,
            'idcard_province_id' => $this->idcard_province_id,
            'idcard_amphur_id' => $this->idcard_amphur_id,
            'idcard_date_expiry' => $this->idcard_date_expiry,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
            'work_status' => $this->work_status,
        ]);

        $query->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 'prefix_name_th', $this->prefix_name_th])
            ->andFilterWhere(['like', 'prefix_name_en', $this->prefix_name_en])
            ->andFilterWhere(['like', 'firstname_th', $this->firstname_th])
            ->andFilterWhere(['like', 'firstname_en', $this->firstname_en])
            ->andFilterWhere(['like', 'middlename_th', $this->middlename_th])
            ->andFilterWhere(['like', 'middlename_en', $this->middlename_en])
            ->andFilterWhere(['like', 'lastname_th', $this->lastname_th])
            ->andFilterWhere(['like', 'lastname_en', $this->lastname_en])
            ->andFilterWhere(['like', 'work_status', $this->work_status])
            ->andFilterWhere(['like', 'work_type', $this->work_type])
            ->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['like', 'nationality', $this->nationality])
            ->andFilterWhere(['like', 'race', $this->race])
            ->andFilterWhere(['like', 'religion', $this->religion])
            ->andFilterWhere(['like', 'idcard', $this->idcard])
            ->andFilterWhere(['like', 'blood', $this->blood])
            ->andFilterWhere(['like', 'living_status', $this->living_status])
            ->andFilterWhere(['like', 'marriage_status', $this->marriage_status])
            ->andFilterWhere(['like', 'military_status', $this->military_status])
            ->andFilterWhere(['like', 'nickname', $this->nickname]);
        return $dataProvider;
    }
}
