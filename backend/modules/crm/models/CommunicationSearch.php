<?php
namespace backend\modules\crm\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\crm\models\Communication;

class CommunicationSearch extends Communication

{
    public function rules()
    {
        return [
            [['id', 'created_at', 'created_by', 'updated_at', 'updated_by', 'customer_id'], 'integer'],
            [['title', 'detail', 'type'], 'safe'],
        ];
    }

    public function scenarios()
    {

        // bypass scenarios() implementation in the parent class

        return Model::scenarios();

    }



    public function search($params)
    {

        $query = Communication::find();

        

        $dataProvider = new ActiveDataProvider([

            'query' => $query,

            'sort'=> ['defaultOrder' => ['id'=>SORT_DESC]]

        ]);


        if( ! Yii::$app->user->can('crmResponseManager')){

            $query->andFilterWhere(['created_by'=>Yii::$app->user->id]);

        }

        if (!($this->load($params) && $this->validate())) {

            return $dataProvider;

        }



        $query->andFilterWhere([

            'id' => $this->id,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
            'customer_id' => $this->customer_id,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'detail', $this->detail])
            ->andFilterWhere(['like', 'type', $this->type]);
        return $dataProvider;
    }


    public function searchMyCommunication($params)
    {

        $query = Communication::find();

        

        $dataProvider = new ActiveDataProvider([

            'query' => $query,

            'sort'=> ['defaultOrder' => ['id'=>SORT_DESC]]

        ]);

         $query->andFilterWhere(['created_by'=>Yii::$app->user->id]);

        if (!($this->load($params) && $this->validate())) {

            return $dataProvider;

        }



        $query->andFilterWhere([

            'id' => $this->id,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
            'customer_id' => $this->customer_id,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'detail', $this->detail])
            ->andFilterWhere(['like', 'type', $this->type]);
        return $dataProvider;
    }
}

