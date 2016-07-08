<?php
namespace app\behaviors;

use Yii;
use yii\base\Behavior;
use yii\db\ActiveRecord;

class AuthorBehavior extends Behavior
{
    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_VALIDATE => 'setUserId',
        ];
    }

    public function setUserId()
    {
		if (Yii::$app instanceof yii\web\Application)
			$this->owner->author = Yii::$app->user->getId();
    }
}