<?
namespace app\models;

use Yii;
use yii\helpers\Url;
use app\models\Article;
use app\models\User;
use app\modules\notifications\models\Notification as BaseNotification;

class Notification extends BaseNotification
{
    /**
     * A new message notification
     */
    const KEY_NEW_USER = 'new_user';
    /**
     * A meeting reminder notification
     */
    const KEY_NEW_ARTICLE = 'new_article';
    /**
     * No disk space left !
     */
    const KEY_MESSAGE = 'message';

    /**
     * @var array Holds all usable notifications
     */
    public static $keys = [
        self::KEY_NEW_USER,
        self::KEY_NEW_ARTICLE,
        self::KEY_MESSAGE,
    ];
	
    /**
     * @inheritdoc
     */
    public function getTitle()
    {
        switch ($this->key) {
            case self::KEY_NEW_USER:
                return Yii::t('app', 'New user created');

            case self::KEY_NEW_ARTICLE:
                return Yii::t('app', 'New article created');

/*            case self::KEY_MESSAGE:
                $message = Message::findOne($this->key_id);
                return Yii::t('app', 'Message: {title}'. [
                        'title' => $message->title
                    ]);*/
        }
    }

    /**
     * @inheritdoc
     */
    public function getDescription()
    {
        switch ($this->key) {
            case self::KEY_NEW_USER:
                $user = User::findOne($this->key_id);
                return Yii::t('app', 'New user ID is {userID}', [
                    'userID' => $user->id
                ]);

            case self::KEY_NEW_ARTICLE:
                $article = Article::findOne($this->key_id);
                return Yii::t('app', 'New article title "{title}"', [
                    'title' => $article->title
                ]);

/*            case self::KEY_MESSAGE:
                $message = Message::findOne($this->key_id);
                return Yii::t('app', 'Message: {body}'. [
                        'body' => $message->body
                    ]);*/
        }
    }

    /**
     * @inheritdoc
     */
    public function getRoute()
    {
        switch ($this->key) {
            case self::KEY_NEW_USER:
				$route = 'user/admin/update';
				break;

            case self::KEY_NEW_ARTICLE:
                $route = 'site/view';
				break;

 /*           case self::KEY_MESSAGE:
                return ['message/view', 'id' => $this->key_id];*/
        };
		return Url::to([$route, 'id' => $this->key_id], true);
    }


}