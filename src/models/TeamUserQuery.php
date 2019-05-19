<?php

namespace xavsio4\teamable\models;

/**
 * This is the ActiveQuery class for [[TeamUser]].
 *
 * @see TeamUser
 */
class TeamUserQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    public function belongsto()
    {
        return $this->andWhere('[[user_id]]='.\Yii::$app->user->id);
    }

    /**
     * {@inheritdoc}
     * @return TeamUser[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return TeamUser|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
