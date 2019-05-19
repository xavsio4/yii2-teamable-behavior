<?php
namespace frontend\widgets;

use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;
/**
 * This is just an example.
 */
class teamList extends \yii\base\Widget {
    
    public $kbId;
    public $nbrec;
    
    
    public function run() {
        $dataProvider = \xavsio4\yii2-teamable-behavior\src\models\Team::find()
        ->orderBy(['created_at'=>SORT_DESC])
        ->all();
        return $this->render('teamList', [
                    'dataProvider' => $dataProvider
        ]);
    }
}