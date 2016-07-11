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
		return $this->hasMany(NotifyUser::className(), ['user_id' => 'id']);
	}

	public function getTransports()
	{
		return $this->hasMany(NotifyTransport::className(), ['notify_user_id' => 'id'])
			->viaTable('{{%notify_user}}', ['user_id' => 'id']);
	}
	
}