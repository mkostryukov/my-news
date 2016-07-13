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
	
	public $_user_id;

    /** @return current user id */
    public function getUser_id()
    {
        if ($this->_user_id == null) {
            $this->_user_id = Yii::$app->user->identity->getId();
        }

        return $this->_user_id;
    }
/*	
	public function setUser_id($id)
	{
		$this->user_id = $id;
	}
*/
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
        /* @var $collection app\modules\notifications\NotificationTransportInterface */
        $collection = Yii::$app->get($this->transportCollection);

		return $collection->getTransports();
    }
	
    /** @inheritdoc */
    public function rules()
    {
        return [
			'useridRequired' => ['user_id', 'required'],
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
        }

        return false;
    }

}
