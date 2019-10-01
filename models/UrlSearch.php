<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Url;

/**
 * UrlSearch represents the model behind the search form of `app\models\Url`.
 */
class UrlSearch extends Url
{
    /**
     * {@inheritdoc}
     */

    public $Term;

    public function rules()
    {
        return [
            [['EnterpriseCode', 'Code', 'UserCode'], 'integer'],
            [['DateTimeCreate', 'Address', 'Response', 'Status', 'Term'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = Url::find();


        /*********** search *******/

        // add conditions that should always apply here
        $pageSize = isset($params['per-page']) ? intval($params['per-page']) : 10;
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' =>  ['pageSize' => $pageSize,],
        ]);



        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'EnterpriseCode' => $this->EnterpriseCode,
            'Code' => $this->Code,
            'UserCode' => $this->UserCode,
            'DateTimeCreate' => $this->DateTimeCreate,
        ]);



        $query->orFilterWhere(['like', 'Address', $this->Term]);


        return $dataProvider;


    }
}
