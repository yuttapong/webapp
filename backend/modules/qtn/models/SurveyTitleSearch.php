<?php

namespace backend\modules\qtn\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\qtn\models\SurveyTitle;

/**
 * SurveyTitleSearch represents the model behind the search form about `backend\modules\qtn\Models\SurveyTitle`.
 */
class SurveyTitleSearch extends SurveyTitle
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id',  'survey_tab_id', 'hide'], 'integer'],
            [['name'], 'safe'],
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
        $query = SurveyTitle::find();
       $query ->join(' JOIN', 'qtn_survey_tab g', 'g.id = survey_tab_id');

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
            'survey_tab_id' => $this->survey_tab_id,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
        ->orderBy(['g.survey_id' => SORT_DESC]);
        return $dataProvider;
    }
}
