<?php
namespace app\models;

use Yii;
use app\behaviors\UserBehavior;
use dektrium\user\models\User as BaseUser;

class User extends BaseUser
{

	public function setDefaultRole()
	{
		$auth = Yii::$app->authManager;
		$authUser = $auth->getRole('auth_user');
		$auth->assign($authUser, $this->owner->getId());
	}
	
}