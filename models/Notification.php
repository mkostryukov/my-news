<?
namespace app\models;

use Yii;
use yii\helpers\Url;
use app\modules\notifications\models\Notification as BaseNotification;

class Notification extends BaseNotification
{
    /**
     * A new user notification
     */
    const KEY_NEW_USER = 'new_user';
    /**
     * A new article notification
     */
    const KEY_NEW_ARTICLE = 'new_article';
    /**
     * Message notification
     */
    const KEY_MESSAGE = 'message';

    /**
     * @var array Holds all usable notifications
     */
    public static $keys = [
        self::KEY_NEW_USER => 'New user created',
        self::KEY_NEW_ARTICLE => 'New article created',
        self::KEY_MESSAGE => 'Message received',
    ];

    /**
     * @inheritdoc
     */
    public function getTitle()
    {
        if (array_key_exists($this->key, self::$keys))
            return self::$keys[$this->key];
        
/*        switch ($this->key) {
            case self::KEY_NEW_USER:
                return Yii::t('app', 'New user created');

            case self::KEY_NEW_ARTICLE:
                return Yii::t('app', 'New article created');

            case self::KEY_MESSAGE:
                $message = Message::findOne($this->key_id);
                return Yii::t('app', 'Message: {title}'. [
                        'title' => $message->title
                    ]);
        }*/

        return "Unknown key: $this->key";
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

        return "Unknown key: $this->key";
    }

    /**
     * @inheritdoc
     */
    public function getRoute()
    {
        switch ($this->key) {
            case self::KEY_NEW_USER:
				$route = '/user/admin/update';
				break;

            case self::KEY_NEW_ARTICLE:
                $route = '/site/view';
				break;

 /*           case self::KEY_MESSAGE:
                return ['message/view', 'id' => $this->key_id];*/

            default:
                $route = '';
        };
		return Url::to([$route, 'id' => $this->key_id], true);
    }


}