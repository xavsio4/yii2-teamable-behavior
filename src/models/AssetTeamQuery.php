<?php

namespace xavsio4\teamable\models;

/**
 * This is the ActiveQuery class for [[AssetTeam]].
 *
 * @see AssetTeam
 */
class AssetTeamQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return AssetTeam[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return AssetTeam|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
