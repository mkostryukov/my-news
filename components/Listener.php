<?php
namespace app\components;

use Yii;
use yii\base\Event;
use yii\base\Component;
use yii\db\ActiveRecord;
use app\models\Notification;

class Listener extends Component
{
	public function init() {
		Event::on(ActiveRecord::className(), ActiveRecord::EVENT_AFTER_INSERT, ['app\components\Listener', 'notify']);		
	}
	
	public function notify ($event)
	{
		$senderClass = $event->sender->className($event->sender);
		switch ($senderClass) {
			case 'app\models\Article':
				$key = Notification::KEY_NEW_ARTICLE;
				break;
			case 'app\models\User':
				$key = Notification::KEY_NEW_USER;
				break;
			default:
				return false;
		}
		$to = new \StdClass();
		$to->email = 'mega@dlp.ru';
		Notification::notify(['app\modules\notifications\transports\Mail'], [$to], $key, $event->sender->id);
	}
}
