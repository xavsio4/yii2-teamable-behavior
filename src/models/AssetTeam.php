<?php

namespace xavsio4\teamable\models;

use Yii;
use frontend\modules\snippet\models\Snippet;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "asset_team".
 *
 * @property int $id
 * @property int $team_id
 * @property int $item_id
 * @property string $model
 * @property int $created_by
 * @property int $created_at
 * @property int $updated_by
 * @property int $updated_at
 */
class AssetTeam extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'asset_team';
    }

     /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            BlameableBehavior::className(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['team_id', 'item_id', 'created_by', 'created_at', 'updated_by', 'updated_at'], 'integer'],
            [['model'], 'string', 'max' => 300],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'team_id' => Yii::t('app', 'Team ID'),
            'item_id' => Yii::t('app', 'Item ID'),
            'model' => Yii::t('app', 'Model'),
            'created_by' => Yii::t('app', 'Created By'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return AssetTeamQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AssetTeamQuery(get_called_class());
    }

    public function getSnippet()
    {
        return $this->hasOne(Snippet::className(),['id' => 'item_id']);
    }


}
