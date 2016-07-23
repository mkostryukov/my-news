<?php
namespace app\models;

use app\modules\notifications\Module;
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
	
	public function getNotifications()
	{
		return $this->hasMany(UserNotification::className(), ['user_id' => 'id'])->indexBy('key');
	}
	
	public function getTransports()
	{
		return $this->hasMany(UserTransport::className(), ['user_id' => 'id'])->indexBy('transport_id');
	}

    /** @inheritdoc */
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        // Enable new_article notification and all transports by default on user creation
        if ($insert) {
            $notification = Yii::createObject([
                'class' => UserNotification::className(),
                'key' => Notification::KEY_NEW_ARTICLE,
            ]);
            $notification->link('user', $this);
            /** @var Module $module */
            $module = \Yii::$app->getModule('notifications');
            $transports = $module->getTransports();
            foreach ($transports as $key => $value) {
                $transport = Yii::createObject([
                    'class' => UserTransport::className(),
                    'transport_id' => $key,
                ]);
                $transport->link('user', $this);
            }
        }
    }

}