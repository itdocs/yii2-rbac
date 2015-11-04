<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace dektrium\rbac\models;

use yii\base\Model;
use yii\data\ArrayDataProvider;
use yii\db\Query;

/**
 * @author Dmitry Erofeev <dmeroff@gmail.com>
 */
class Search extends Model
{
    /** @var string */
    public $name;
    
    /** @var string */
    public $description;
    
    /** @var string */
    public $rule_name;
    
    /** @var \dektrium\rbac\components\DbManager */
    protected $manager;
    
    /** @var int */
    protected $type;

    /** @inheritdoc */
    public function __construct($type, $config = [])
    {
        parent::__construct($config);
        $this->manager = \Yii::$app->authManager;
        $this->type    = $type;
    }
    
    /** @inheritdoc */
    public function scenarios()
    {
        return [
            'default' => ['name', 'description', 'rule_name'],
        ];
    }
    
    /**
     * @param  array              $params
     * @return ActiveDataProvider
     */
    public function search($params = [])
    {
        $dataProvider = \Yii::createObject(ArrayDataProvider::className());
        
        $query = (new Query)->select(['name', 'description', 'rule_name'])
                ->andWhere(['type' => $this->type])
                ->from($this->manager->itemTable);
        
        if ($this->load($params) && $this->validate()) {
            $query->andFilterWhere(['like', 'name', $this->name])
                ->andFilterWhere(['like', 'description', $this->description])
                ->andFilterWhere(['like', 'rule_name', $this->rule_name]);
        }
        
        $dataProvider->allModels = $query->all($this->manager->db);
        
        return $dataProvider;
    }

    public function children()
    {
        $query = (new Query)->select(['name', 'description', 'rule_name'])
            ->andWhere(['type' => $this->type])
            ->from($this->manager->itemTable);

        $arr = $query->all($this->manager->db);

        foreach ($arr as $k=>$v) {
            $children = (new Query())->select(['child','description'])
                ->from('auth_item_child')
                ->leftJoin('auth_item','child = name')
                ->where(['parent' => $v['name']])
                ->all();
            $new = [];
            $new_desc = [];
            foreach($children as $ch){
                array_push($new, $ch['child']);
                array_push($new_desc, $ch['description']);
            }
            $arr[$k]['child'] = $new;
            $arr[$k]['child_desc'] = $new_desc;
        }
//        print_r($arr);exit;
        return $arr;
    }

    public function permissions()
    {
        $query = (new Query)->select(['name','description'])
            ->andWhere(['type' => 2])
            ->from('auth_item');

        $arr = $query->all();
//        print_r($arr);exit;
        return $arr;
    }
}
