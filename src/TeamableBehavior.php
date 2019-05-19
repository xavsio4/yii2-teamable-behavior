<?php
/**
 * @link https://github.com/xavsio4/yii2-teamable-behavior
 * @copyright Copyright (c) 2019 X Villamuera
 * @license http://opensource.org/licenses/BSD-3-Clause
 */

namespace xavsio4\teamable;

use yii\base\Behavior;
use yii\db\ActiveRecord;
use yii\db\Query;

/**
 * TeamableBehavior
 *
 * @property ActiveRecord $owner
 *
 * @author Alexander Kochetov <creocoder@gmail.com>
 */
class TeamableBehavior extends Behavior
{
    /**
     * @var boolean whether to return teams as array instead of string
     */
    public $teamValuesAsArray = false;
    /**
     * @var string the teams relation name
     */
    public $teamRelation = 'teams';
    /**
     * @var string the teams model value attribute name
     */
    public $teamValueAttribute = 'name';
    
    /**
     * @var string[]
     */
    private $_teamValues;

    /**
     * @inheritdoc
     */
    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_INSERT => 'afterSave',
            ActiveRecord::EVENT_AFTER_UPDATE => 'afterSave',
            ActiveRecord::EVENT_BEFORE_DELETE => 'beforeDelete',
        ];
    }

    /**
     * Returns teams.
     * @param boolean|null $asArray
     * @return string|string[]
     */
    public function getTeamValues($asArray = null)
    {
        if (!$this->owner->getIsNewRecord() && $this->_teamValues === null) {
            $this->_teamValues = [];

            /* @var ActiveRecord $team */
            foreach ($this->owner->{$this->teamRelation} as $team) {
                $this->_teamValues[] = $team->getAttribute($this->teamValueAttribute);
            }
        }

        if ($asArray === null) {
            $asArray = $this->teamValuesAsArray;
        }

        if ($asArray) {
            return $this->_teamValues === null ? [] : $this->_teamValues;
        } else {
            return $this->_teamValues === null ? '' : implode(', ', $this->_teamValues);
        }
    }

    /**
     * Sets teams.
     * @param string|string[] $values
     */
    public function setTeamValues($values)
    {
        $this->_teamValues = $this->filterTeamValues($values);
    }

    /**
     * Adds teams.
     * @param string|string[] $values
     */
    public function addTeamValues($values)
    {
        $this->_teamValues = array_unique(array_merge($this->getTeamValues(true), $this->filterTeamValues($values)));
    }

    /**
     * Removes teams.
     * @param string|string[] $values
     */
    public function removeTeamValues($values)
    {
        $this->_teamValues = array_diff($this->getTeamValues(true), $this->filterTeamValues($values));
    }

    /**
     * Removes all teams.
     */
    public function removeAllTeamValues()
    {
        $this->_teamValues = [];
    }

    /**
     * Returns a value indicating whether teams exists.
     * @param string|string[] $values
     * @return boolean
     */
    public function hasTeamValues($values)
    {
        $teamValues = $this->getTeamValues(true);

        foreach ($this->filterTeamValues($values) as $value) {
            if (!in_array($value, $teamValues)) {
                return false;
            }
        }

        return true;
    }

    /**
     * @return void
     */
    public function afterSave()
    {
        if ($this->_teamValues === null) {
            return;
        }

        if (!$this->owner->getIsNewRecord()) {
            $this->beforeDelete();
        }

        $teamRelation = $this->owner->getRelation($this->teamRelation);
        $pivot = $teamRelation->via->from[0];
        /* @var ActiveRecord $class */
        $class = $teamRelation->modelClass;
        $rows = [];

        foreach ($this->_teamValues as $value) {
            /* @var ActiveRecord $team */
            $team = $class::findOne([$this->teamValueAttribute => $value]);

            if ($team === null) {
                $team = new $class();
                $team->setAttribute($this->teamValueAttribute, $value);
            }


            if ($team->save()) {
                $rows[] = [$this->owner->getPrimaryKey(), $team->getPrimaryKey()];
            }
        }

        if (!empty($rows)) {
            $this->owner->getDb()
                ->createCommand()
                ->batchInsert($pivot, [key($teamRelation->via->link), current($teamRelation->link)], $rows)
                ->execute();
        }
    }

    /**
     * @return void
     */
    public function beforeDelete()
    {
        $teamRelation = $this->owner->getRelation($this->teamRelation);
        $pivot = $teamRelation->via->from[0];

      /*  if ($this->teamFrequencyAttribute !== false) {
            $class = $teamRelation->modelClass;

            $pks = (new Query())
                ->select(current($teamRelation->link))
                ->from($pivot)
                ->where([key($teamRelation->via->link) => $this->owner->getPrimaryKey()])
                ->column($this->owner->getDb());

            if (!empty($pks)) {
                $class::updateAllCounters([$this->teamFrequencyAttribute => -1], ['in', $class::primaryKey(), $pks]);
            }
    } */

        $this->owner->getDb()
            ->createCommand()
            ->delete($pivot, [key($teamRelation->via->link) => $this->owner->getPrimaryKey()])
            ->execute();
    }

    /**
     * Filters teams.
     * @param string|string[] $values
     * @return string[]
     */
    public function filterTeamValues($values)
    {
        return array_unique(preg_split(
            '/\s*,\s*/u',
            preg_replace('/\s+/u', ' ', is_array($values) ? implode(',', $values) : $values),
            -1,
            PREG_SPLIT_NO_EMPTY
        ));
    }
}
