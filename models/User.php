<?php
namespace app\models;

use Yii;
use app\components\Notification;
use dektrium\user\models\User as BaseUser;

class User extends BaseUser
{

	public function setDefaultRole()
	{
		$auth = Yii::$app->authManager;
		$authUser = $auth->getRole('auth_user');
		$auth->assign($authUser, $this->owner->getId());
		$to = new \StdClass();
		$to->email = 'mega@dlp.ru';
		Notification::notify(['app\modules\notifications\transports\Mail'], [$to], Notification::KEY_NEW_USER, $this->owner->getId());
	}
	
}