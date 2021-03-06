<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\modules\notifications\Module;

/**
 * NotificationsForm gets user's notifications and transports and changes them.
 *
 * @property User $user
 *
 */
class NotificationsForm extends Model
{
    public $transportCollection = 'notificationTransportCollection';

	private $_transportNames; 
	
	public $notifications;

	public $transports;
	
	public $user_id;

    /** @var User */
    private $_user;

    /** @inheritdoc */
    public function __construct(User $user = null, $config = [])
    {
        if ($user) {
            $this->setUser($user);
            $this->setAttributes([
                'user_id' => $this->getUser()->getId(),
                'notifications' => $this->getUserNotifications(),
                'transports' => $this->getUserTransports(),
            ], false);
        }
        else {
            $this->setAttributes([
                'user_id' => Yii::$app->user->identity->getId(),
                'notifications' => $this->getUserNotifications(),
                'transports' => $this->getUserTransports(),
            ], false);
        }
        parent::__construct($config);
    }

    public function setUser($user)
    {
        $this->_user = $user;
    }

    /** @return User */
    public function getUser()
    {
        if ($this->_user == null) {
            $this->_user = Yii::$app->user->identity;
        }

        return $this->_user;
    }

    public function getUserNotifications()
    {
        return array_keys($this->user->notifications);
    }

    public function getUserTransports()
    {
        return array_keys($this->user->transports);
    }

    /** @return array of available notification keys with titles */
    public function getNotificationKeys()
	{
        return Notification::$keys;
	}
	
	/** @return array of available transports with names */
	public function getTransportNames()
	{
       if ($this->_transportNames === null) {
            $transports = $this->defaultTransports();
			foreach ($transports as $transport)
				$this->_transportNames[$transport->getId()] = $transport->getName();
        }
		return $this->_transportNames;
	}
	
	protected function defaultTransports()
    {
        /** @var Module $module */
        $module = \Yii::$app->getModule('notifications');
		return $module->getTransports();
    }
	
    /** @inheritdoc */
    public function rules()
    {
        $transportKeys = array_keys($this->getTransportNames());
        $notificationsKeys = array_keys($this->getNotificationKeys());
        return [
			'useridRequired' => ['user_id', 'required'],
            ['transports', 'default', 'value' => []],
            'transportExists' => ['transports', 'in', 'range' => $transportKeys, 'allowArray' => true],
            ['notifications', 'default', 'value' => []],
            'notificationExists' => ['notifications', 'in', 'range' => $notificationsKeys, 'allowArray' => true],
        ];
    }

    /** @inheritdoc */
    public function scenarios()
    {
        return [
            'default' => ['user_id', 'transports', 'notifications'],
        ];
    }

    /** @inheritdoc */
    public function formName()
    {
        return 'notifications-form';
    }

    /**
     * Saves user notifications and transports.
     *
     * @return bool
     */
    public function save()
    {
        if ($this->validate()) {
            /** @var array UserTransport $user_transports */
            $user_transports = $this->user->transports;
            foreach ($this->transports as $key)
                if (array_key_exists($key, $user_transports)) {
                    // transport already exists, remove it from deletion array
                    unset($user_transports[$key]);
                } else {
                    // creating transport
                    $transport = Yii::createObject([
                        'class' => UserTransport::className(),
                        'user_id' => $this->user_id,
                        'transport_id' => $key,
                    ]);
                    $transport->link('user', $this->user);
                }
            // delete unchecked user transports
            /** @var UserTransport $transport */
            foreach ($user_transports as $transport)
                $transport->unlink('user', $this->user, true);

            /** @var array UserNotification $user_notifications */
            $user_notifications = $this->user->notifications;
            foreach ($this->notifications as $key)
                if (array_key_exists($key, $user_transports)) {
                    // transport already exists, remove it from deletion array
                    unset($user_notifications[$key]);
                }
                else {
                    // creating transport
                    $notification = Yii::createObject([
                        'class' => UserNotification::className(),
                        'user_id' => $this->user_id,
                        'key' => $key,
                    ]);
                    $notification->link('user', $this->user);
                }
            // delete unchecked user notifications
            /** @var UserNotification $notification */
            foreach ($user_notifications as $notification)
                $notification->unlink('user', $this->user, true);


            return true;
        }
        return false;
    }

}
