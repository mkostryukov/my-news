<?php
namespace app\components;

use Yii;
use yii\base\Event;
use yii\base\Component;
use yii\db\ActiveRecord;
use yii\web\NotFoundHttpException;
use app\models\Notification;
use app\models\User;

class Listener extends Component
{
	public function init() {
		Event::on(ActiveRecord::className(), ActiveRecord::EVENT_AFTER_INSERT, ['app\components\Listener', 'notify']);		
	}

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
			default:
				return false;
		}
		$user = self::findModel(Yii::$app->user->identity->getId());
        $transports = $user->transports;
        echo '<pre>';
        print_r($transports);
        echo '</pre>';
        die();
		$to = new \StdClass();
		$to->email = 'mega@dlp.ru';
		Notification::notify(['app\modules\notifications\transports\Mail'], [$to], $key, $event->sender->id);
	}

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param int $id
     *
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected static function findModel($id)
    {
        $user = User::find()
            ->where(['id' => $id])
            ->one();
        if ($user === null) {
            throw new NotFoundHttpException('The requested page does not exist');
        }

        return $user;
    }

}
