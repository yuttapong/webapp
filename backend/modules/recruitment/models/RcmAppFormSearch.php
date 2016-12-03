<?php

namespace backend\modules\recruitment\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;


/**
 * backend\modules\recruitment\models\RcmAppFormSearch represents the model behind the search form about `backend\modules\recruitment\models\RcmAppForm`.
 */
class RcmAppFormSearch extends RcmAppForm
{

    public $q;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'company_id', 'personnel_id', 'created_at', 'created_by', 'status', 'type'], 'integer'],
            [['salary_desired', 'interview_status',
                'description', 'position_id', 'q', 'fullname', 'code'], 'safe'],
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
        $query = RcmAppForm::find();


        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['id' => SORT_DESC]]
        ]);
        $dataProvider->sort->attributes['fullname'] = [
            'asc' => ['org_personnel.firstname_th' => SORT_ASC],
            'desc' => ['org_personnel.firstname_th' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['statusName'] = [
            'asc' => ['rcm_app_form.status' => SORT_ASC],
            'desc' => ['rcm_app_form.status' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }


        $query->joinWith(['personnel']);

        $query->andFilterWhere([
            'rcm_app_form.id' => $this->id,
            'rcm_app_form.company_id' => $this->company_id,
            'rcm_app_form.personnel_id' => $this->personnel_id,
            'rcm_app_form.created_at' => $this->created_at,
            'rcm_app_form.created_by' => $this->created_by,
            'rcm_app_form.status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'rcm_app_form.salary_desired', $this->salary_desired])
            ->andFilterWhere(['like', 'ircm_app_form.nterview_status', $this->interview_status])
            ->andFilterWhere(['like', 'rcm_app_form.type', $this->type])
            ->andFilterWhere(['like', 'rcm_app_form.description', $this->description])
            ->andFilterWhere(['like', 'org_personnel.firstname_th', $this->q]);


        return $dataProvider;
    }
}
