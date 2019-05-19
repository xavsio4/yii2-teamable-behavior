# Teamable Behavior for Yii 2

** THIS IS STILL IN DEVELOPMENT DON'T USE IT RIGHT NOW **

This extension is based on the work of Alexander Kochetov (https://github.com/creocoder)

With teamable-behavior, attach any entity asset to a team. That is a kind of a way to group things. For example, you have some articles, docs, snippets,....and you want to give only access to a team or several teams. This means that you also have to attach users to a team which you can do as well with the teamable-behavior. It means that you can use it more than once in you application.

There are some widgets provided in order to manage the team entity and the relations you've created.

Also, in this readme file you'll find code samples using simple select and select2.


## Installation

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```bash
$ composer require xavsio4/yii2-teamable-behavior
```

or add

```
"xavsio4/yii2-teamable-behavior": "~2.0"
```

to the `require` section of your `composer.json` file.

## Migrations

That is the first step. You'll be creating the team table. It is up to you to modify this step

Run the following commands to create the tables needed:
* team
* team_user
* asset_team

```bash
$ yii migrate/create m190517_125543_team
```

```bash
$ yii migrate/create m190517_125631_team_user
```

```bash
$ yii migrate/create m190517_125825_asset_team
```


## Configuring

Configure model as follows

```php
use xavsio4\teamable\TeamableBehavior;

/**
 * ...
 * @property string $tagValues
 */
class Post extends \yii\db\ActiveRecord
{
    public function behaviors()
    {
        return [
            'teamable' => [
                'class' => TeamableBehavior::className(),
                // 'tagValuesAsArray' => false,
                // 'teamRelation' => 'teams',
                // 'teamValueAttribute' => 'name',
            ],
        ];
    }

    public function rules()
    {
        return [
            //...
            ['teamValues', 'safe'],
        ];
    }

    public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }


    public function getTeams()
    {
        return $this->hasMany(Team::className(), ['id' => 'team_id'])
            ->viaTable('{{%team_assn}}', ['asset_id' => 'id']);
    }
}
```

Model `Team` can be generated using Gii.

Configure query class as follows

```php
use xavsio4\teamable\TeamableQueryBehavior;

class YourTableQuery extends \yii\db\ActiveQuery
{
    public function behaviors()
    {
        return [
            TeamableQueryBehavior::className(),
        ];
    }
}
```

## Usage

### Setting teams to the entity

To set teams to the entity

```php
$post = new Post();

// through string
$post->teamValues = 'foo, bar, baz';

// through array
$post->teamValues = ['foo', 'bar', 'baz'];
```

### Adding tags to the entity

To add tags to the entity

```php
$post = Post::findOne(1);

// through string
$post->addTeamValues('bar, baz');

// through array
$post->addTeamValues(['bar', 'baz']);
```

### Remove tags from the entity

To remove tags from the entity

```php
$post = YourEntity::findOne(1);

// through string
$post->removeTeamValues('bar, baz');

// through array
$post->removeTeamValues(['bar', 'baz']);
```

### Remove all tags from the entity

To remove all tags from the entity

```php
$post = YourEntity::findOne(1);
$post->removeAllTeamValues();
```

### Getting tags from the entity

To get tags from the entity

```php
$posts = yourEntity::find()->with('teams')->all();

foreach ($posts as $post) {
    // as string
    $teamValues = $post->teamValues;

    // as array
    $teamValues = $post->getTeamValues(true);
}
```

Return type of `getTeamValues` can also be configured globally via `teamValuesAsArray` property.

### Checking for teams in the entity

To check for tags in the entity

```php
$post = Post::findOne(1);

// through string
$result = $post->hasTeamValues('foo, bar');

// through array
$result = $post->hasTeamValues(['foo', 'bar']);
```

### Search entities by any tags

To search entities by any tags

```php
// through string
$posts = Post::find()->anyTeamValues('foo, bar')->all();

// through array
$posts = Post::find()->anyTeamValues(['foo', 'bar'])->all();
```

To search entities by any teams using custom team model attribute

```php
// through string
$posts = Post::find()->anyTeamValues('foo-slug, bar-slug', 'slug')->all();

// through array
$posts = Post::find()->anyTeamValues(['foo-slug', 'bar-slug'], 'slug')->all();
```

### Search entities by all teams

To search entities by all teams

```php
// through string
$posts = Post::find()->allTeamValues('foo, bar')->all();

// through array
$posts = Post::find()->allTeamValues(['foo', 'bar'])->all();
```

To search entities by all tags using custom tag model attribute

```php
// through string
$posts = Post::find()->allTeamValues('foo-slug, bar-slug', 'slug')->all();

// through array
$posts = Post::find()->allTeamValues(['foo-slug', 'bar-slug'], 'slug')->all();
```

### Search entities related by teams

To search entities related by teams

```php
// through string
$posts = Post::find()->relatedByTeamValues('foo, bar')->all();

// through array
$posts = Post::find()->relatedByTeamValues(['foo', 'bar'])->all();
```

To search entities related by tags using custom tag model attribute

```php
// through string
$posts = Post::find()->relatedByTeamValues('foo-slug, bar-slug', 'slug')->all();

// through array
$posts = Post::find()->relatedByTeamValues(['foo-slug', 'bar-slug'], 'slug')->all();
```

```php
//use kartik/select2(widgets) to display teams in your asset table's form.


```

