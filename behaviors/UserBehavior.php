<?php
namespace app\behaviors;

use Yii;
use yii\base\Behavior;
use dektrium\user\models\User;

class UserBehavior extends Behavior
{
    public function events()
    {
        return [
            \dektrium\user\models\User::AFTER_REGISTER => 'setDefaultRole',
        ];
    }

	public function setDefaultRole()
	{
		$auth = Yii::$app->authManager;
		$authUser = $auth->getRole('auth_user');
		$auth->assign($authUser, $this->owner->getId());
	}
}