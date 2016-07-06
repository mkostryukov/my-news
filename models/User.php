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
	
/*    public function register()
    {
        $ret = parent::register();
//		if ($ret) $this->setDefaultRole();
		return $ret;
    }
	
	public function setDefaultRole()
	{
		$auth = Yii::$app->authManager;
		$authUser = $auth->getRole('auth_user');
		$auth->assign($authUser, $this->getId());
	}*/

}