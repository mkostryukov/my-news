<?php

namespace app\models;

use Yii;
use yii\base\Model;

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
    public function __construct($config = [])
    {
        $this->setAttributes([
            'user_id' => Yii::$app->user->identity->getId(),
            'notifications' => $this->getUserNotifications(),
            'transports' => $this->getUserTransports(),
        ], false);
        parent::__construct($config);
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
        $n = $this->user->userNotification;
        foreach ($n as $key => $value) {
            $n[$value->key] = $value->key;
            unset($n[$key]);
        }
        return $n;
    }

    public function getUserTransports()
    {
        $n = $this->user->userTransport;
        foreach ($n as $key => $value) {
            $n[$value->transport_id] = $value->transport_id;
            unset($n[$key]);
        }
        return $n;
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
        $collection = Yii::$app->get($this->transportCollection);

		return $collection->getTransports();
    }
	
    /** @inheritdoc */
    public function rules()
    {
        return [
			'useridRequired' => ['user_id', 'required'],
//            'transportStringArray' => ['transports', 'each', 'rule' => ['string']],
//            'notificationsStringArray' => ['notifications', 'each', 'rule' => ['string']],
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
/*				echo '<pre>';
				print_r($this);
				echo '</pre>';
				die();*/
            $user_transports = $this->user->userTransport;
            if ($this->transports == 'none')
                $this->transports = [];
            foreach ($this->transports as $key)
                if (array_key_exists($key, $user_transports)) {
                    // transport already exists, remove it from deletion array
                    unset($user_transports[$key]);
                }
                else {
                    // creating transport
                    $transport = Yii::createObject([
                        'class' => UserTransport::className(),
                        'user_id' => $this->user_id,
                        'transport_id' => $key,
                    ]);
                    $transport->link('user', $this->user);
                }
            // delete unchecked user transports
            foreach ($user_transports as $transport)
                $transport->unlink('user', $this->user, true);

            $user_notifications = $this->user->userNotification;
            if ($this->notifications == 'none')
                $this->notifications = [];
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
            // delete unchecked user transports
            foreach ($user_notifications as $notification)
                $notification->unlink('user', $this->user, true);


            return true;
        }
        return false;
    }

}
