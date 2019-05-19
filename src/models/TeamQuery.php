<?php

namespace xavsio4\teamable\models;

/**
 * This is the ActiveQuery class for [[Team]].
 *
 * @see Team
 */
class TeamQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    public function own()
    {
        return $this->andWhere('[[created_by]]='.\Yii::$app->user->id);
    }

    /**
     * {@inheritdoc}
     * @return Team[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Team|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
