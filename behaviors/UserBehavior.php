<?php
namespace app\behaviors;

use Yii;
use yii\base\Behavior;
//use dektrium\user\models\User;

class UserBehavior extends Behavior
{
    public function events()
    {
        return [
            \dektrium\user\models\User::AFTER_CREATE => 'setDefaultRole',
//			\app\models\User::EVENT_NEW_USER => 'createNotification',
        ];
    }

	public function setDefaultRole()
	{
		$auth = Yii::$app->authManager;
		$authUser = $auth->getRole('auth_user');
		$auth->assign($authUser, $this->owner->getId());
		$this->owner->trigger(\app\models\User::EVENT_NEW_USER);
	}

	public function createNotification()
	{
		\Yii::$app->getSession()->setFlash('info', 'New user as created');
	}
	
}