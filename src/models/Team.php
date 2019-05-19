<?php

namespace xavsio4\teamable\models;

use Yii;
use frontend\modules\invitation\models\TeamInvitation;
use frontend\modules\invitation\models\AssetTeam;
use frontend\modules\snippet\models\Snippet;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "team".
 *
 * @property int $id
 * @property string $name
 * @property int $status
 * @property string $invitation_email_text
 * @property int $invitation_code
 * @property int $created_by
 * @property int $created_at
 * @property int $updated_at
 * @property int $updated_by
 * @property int $is_deleted
 * @property int $deleted_date
 */
class Team extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'team';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status', 'invitation_code', 'created_by', 'created_at', 'updated_at', 'updated_by', 'is_deleted', 'deleted_date'], 'integer'],
            [['name'], 'string', 'max' => 350],
            [['invitation_email_text'], 'string', 'max' => 255],
        ];
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
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Team\'s name'),
            'status' => Yii::t('app', 'Status'),
            'invitation_email_text' => Yii::t('app', 'Invitation Email Text'),
            'invitation_code' => Yii::t('app', 'Invitation Code'),
            'created_by' => Yii::t('app', 'Created By'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'is_deleted' => Yii::t('app', 'Is Deleted'),
            'deleted_date' => Yii::t('app', 'Deleted Date'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return TeamQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TeamQuery(get_called_class());
    }


    /**
     * @return \yii\db\ActiveQuery
     */

    public function getSnippets()
    {
        return $this->hasMany(Snippet::className(), ['id' => 'item_id'])
            ->viaTable('{{%asset_team}}', ['team_id' => 'id']);
    }  

    public function getAssets()
    {
        return $this->hasMany(AssetTeam::className(),['team_id' => 'id']);
    }
}
