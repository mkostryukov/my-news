<?php
namespace app\components;

use Yii;
use yii\base\Event;
use yii\base\Component;
use yii\db\ActiveRecord;
use app\models\Notification;
use app\models\User;

class Listener extends Component
{
	/**
	 * Set up event listener
	 */
	public function init() {
		Event::on(ActiveRecord::className(), ActiveRecord::EVENT_AFTER_INSERT, ['app\components\Listener', 'notify']);		
	}

	/**
	 * Sends notification based on event sender class
	 *
	 * @param $event
	 * @return bool
	 */
	public static function notify($event)
	{
		$senderClass = $event->sender->className($event->sender);
		switch ($senderClass) {
			case 'app\models\Article':
				$key = Notification::KEY_NEW_ARTICLE;
				break;
			case 'app\models\User':
				$key = Notification::KEY_NEW_USER;
				break;
			case 'app\models\Message':
				$key = Notification::KEY_MESSAGE;
				break;
			default:
				return false;
		}
		Notification::notify(self::getRecipients($key), $key, $event->sender->id);
	}

    /**
     * Finds the User models based on notification key.
     *
     * @param string $key
     *
     * @return array User the loaded model
     */
    protected static function getRecipients($key)
    {
        return User::find()
			->joinWith('transports')
			->joinWith('notifications')
			->where(['{{%user_notification}}.key' => $key])
			->all();
    }

    /**
     * Finds the User models based on role.
     *
     * @param string $key
     *
     * @return array User the loaded model
     */
    public static function findByRole($role)
    {
        return User::find()
            ->join('LEFT JOIN','auth_assignment','auth_assignment.user_id = id')
            ->where(['auth_assignment.item_name' => $role->name])
            ->all();
    }

}
