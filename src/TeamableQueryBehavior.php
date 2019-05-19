<?php
/**
 * @link https://github.com/creocoder/yii2-teamable
 * @copyright Copyright (c) 2019 Xavier Villamuera
 * @license http://opensource.org/licenses/BSD-3-Clause
 */

namespace xavsio4\teamable;

use yii\base\Behavior;
use yii\db\Expression;

/**
 * TaggableQueryBehavior
 *
 * @property \yii\db\ActiveQuery $owner
 *
 */
class TeamableQueryBehavior extends Behavior
{
    /**
     * Gets entities by any team.
     * @param string|string[] $values
     * @param string|null $attribute
     * @return \yii\db\ActiveQuery the owner
     */
    public function anyTeamValues($values, $attribute = null)
    {
        $model = new $this->owner->modelClass();
        $tagClass = $model->getRelation($model->teamRelation)->modelClass;

        $this->owner
            ->innerJoinWith($model->teamRelation, false)
            ->andWhere([$teamClass::tableName() . '.' . ($attribute ?: $model->teamValueAttribute) => $model->filterTeamValues($values)])
            ->addGroupBy(array_map(function ($pk) use ($model) { return $model->tableName() . '.' . $pk; }, $model->primaryKey()));

        return $this->owner;
    }

    /**
     * Gets entities by all team.
     * @param string|string[] $values
     * @param string|null $attribute
     * @return \yii\db\ActiveQuery the owner
     */
    public function allTeamValues($values, $attribute = null)
    {
        $model = new $this->owner->modelClass();

        return $this->anyTeamValues($values, $attribute)->andHaving(new Expression('COUNT(*) = ' . count($model->filterTeamValues($values))));
    }

    /**
     * Gets entities related by team.
     * @param string|string[] $values
     * @param string|null $attribute
     * @return \yii\db\ActiveQuery the owner
     */
    public function relatedByTeamValues($values, $attribute = null)
    {
        return $this->anyTeamValues($values, $attribute)->addOrderBy(new Expression('COUNT(*) DESC'));
    }
}
