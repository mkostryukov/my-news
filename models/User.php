<?php
namespace app\models;

use Yii;
use dektrium\user\models\User as BaseUser;

class User extends BaseUser
{
	public function setDefaultRole()
	{
		$auth = Yii::$app->authManager;
		$authUser = $auth->getRole('auth_user');
		$auth->assign($authUser, $this->owner->getId());
	}
	
	public static function findByRole()
	{
		return static::find()
			->join('LEFT JOIN','auth_assignment','auth_assignment.user_id = id')
			->where(['auth_assignment.item_name' => $role->name])
			->all();	
	}
	
}