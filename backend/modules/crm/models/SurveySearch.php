<?php

namespace backend\modules\crm\Models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\crm\models\Survey;

/**
 * SurveySearch represents the model behind the search form about `backend\modules\qtn\Models\`.
 */
class SurveySearch extends Survey
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status','site_id'], 'integer'],
            [['name', 'owner', 'realm', 'public', 'title', 'email', 'subtitle', 'info', 'theme', 'thanks_page', 'thank_head', 'thank_body', 'changed'], 'safe'],
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
        $query = Survey::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        $query->andWhere(['status'=>\backend\modules\crm\models\Survey::STATUS_ACTIVE]);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
             $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status,
            'changed' => $this->changed,
            'site_id' => $this->site_id,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'owner', $this->owner])
            ->andFilterWhere(['like', 'realm', $this->realm])
            ->andFilterWhere(['like', 'public', $this->public])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'subtitle', $this->subtitle])
            ->andFilterWhere(['like', 'info', $this->info])
            ->andFilterWhere(['like', 'theme', $this->theme])
            ->andFilterWhere(['like', 'thanks_page', $this->thanks_page])
            ->andFilterWhere(['like', 'thank_head', $this->thank_head])
            ->andFilterWhere(['like', 'thank_body', $this->thank_body]);

        $query->orderBy(['site_id'=>SORT_DESC,'id'=>SORT_DESC]);

        return $dataProvider;
    }
}
