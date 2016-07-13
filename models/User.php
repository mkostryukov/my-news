<?php
namespace app\models;

use Yii;
use dektrium\user\models\User as BaseUser;

class User extends BaseUser
{
    public $transportCollection = 'notificationTransportCollection';

	private $_notifications = [];

	private $_transports;
	
	public function getNotifications()
	{
		return $this->_notifications;
	}
	
	public function setNotifications($notifications)
	{
		$this->_notifications = $notifications;
	}
	
	public function getTransports()
	{
       if ($this->_transports === null) {
            $this->_transports = $this->defaultTransports();
        }
		return $this->_transports;
	}
	
	public function getTransportNames()
	{
       if ($this->_transports === null) {
            $this->_transports = $this->defaultTransports();
        }
		$names = [];
		foreach ($this->_transports as $transport)
			$names[$transport->getId()] = $transport->getName();
		return $names;
	}
	
	public function setTransports($transports)
	{
		return $this->_transports;
	}
	
    public function getNotificationKeys()
	{
        return Notification::$key_titles;
	}
	
	protected function defaultTransports()
    {
        /* @var $collection app\modules\notifications\NotificationTransportInterface */
        $collection = Yii::$app->get($this->transportCollection);

		return $collection->getTransports();
    }
	
	public function formName()
	{
		return 'form-notifications';
	}

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

	public function getUserNotification()
	{
		return $this->hasMany(UserNotification::className(), ['user_id' => 'id']);
	}
	
	public function getUserTransport()
	{
		return $this->hasMany(UserTransport::className(), ['user_id' => 'id']);
	}
	
}