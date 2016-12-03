<?php

namespace backend\modules\org\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;


/**
 * OrgSiteSearch represents the model behind the search form about `common\models\OrgSite`.
 */
class OrgSiteSearch extends OrgSite
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['site_id', 'company_id', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['site_name', 'site_description'], 'safe'],
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
        $query = OrgSite::find();

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
            'site_id' => $this->site_id,
            'company_id' => $this->company_id,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'site_name', $this->site_name])
            ->andFilterWhere(['like', 'site_description', $this->site_description]);

        return $dataProvider;
    }
}
