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
	
	public static function findByRole($role)
	{
		return static::find()
			->join('LEFT JOIN','auth_assignment','auth_assignment.user_id = id')
			->where(['auth_assignment.item_name' => $role->name])
			->all();	
	}

	public function getNotifications()
	{
		return $this->hasMany(UserNotification::className(), ['user_id' => 'id'])->indexBy('key');
	}
	
	public function getTransports()
	{
		return $this->hasMany(UserTransport::className(), ['user_id' => 'id'])->indexBy('transport_id');
	}
	
}