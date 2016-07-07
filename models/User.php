<?php
namespace app\models;

use Yii;
use app\behaviors\UserBehavior;
use \dektrium\user\models\User as BaseUser;

class User extends BaseUser
{
	public function behaviors()
	{
		$behaviors = parent::behaviors();
		return array_merge($behaviors, ['class' => UserBehavior::className()]);
	}
}