<?php
namespace app\modules\notifications\models;

use Yii;
use yii\base\Model;
use app\models\User;
use app\modules\notifications\NotificationsModule;
use app\modules\notifications\transports\NotificationTransport;
use yii\db\ActiveQuery;

abstract class Notification extends Model
{
    /**
     * Default notification
     */
    const TYPE_DEFAULT = 'default';

    /**
     * Error notification
     */
    const TYPE_ERROR   = 'error';

    /**
     * Warning notification
     */
    const TYPE_WARNING = 'warning';

    /**
     * Success notification type
     */
    const TYPE_SUCCESS = 'success';

    /**
     * @var array List of all enabled notification types
     */
    public static $types = [
        self::TYPE_WARNING,
        self::TYPE_DEFAULT,
        self::TYPE_ERROR,
        self::TYPE_SUCCESS,
    ];

    /**
     * @var array List of notification recipients
     */
    public $recipients;

    public $type;

    public $key;
    
    public $key_id;

    abstract public function getTitle();

    abstract public function getDescription();

    abstract public function getRoute();

    /**
     * Creates a notification
     *
     * @param string $transport
     * @param string $key
     * @param integer $user_id The user id that will get the notification
     * @param integer $key_id The foreign instance id
     * @param string $type
     * @return bool Returns TRUE on success, FALSE on failure
     * @throws \Exception
     */
    public static function notify(array $transports, array $recipients, $key, $key_id = null, $type = self::TYPE_DEFAULT)
    {
        $class = self::className();
        return NotificationsModule::notify(new $class(), $transports, $recipients, $key, $key_id, $type);
    }
    /**
     * Creates a warning notification
     *
     * @param string $key
     * @param integer $user_id The user id that will get the notification
     * @param integer $key_id The notification key id
     * @return bool Returns TRUE on success, FALSE on failure
     */
    public static function warning(array $transports, array $recipients, $key, $key_id = null)
    {
        return static::notify($transports, $recipients, $key, $key_id, self::TYPE_WARNING);
    }
    /**
     * Creates an error notification
     *
     * @param string $key
     * @param integer $user_id The user id that will get the notification
     * @param integer $key_id The notification key id
     * @return bool Returns TRUE on success, FALSE on failure
     */
    public static function error(array $transports, array $recipients, $key, $key_id = null)
    {
        return static::notify($transports, $recipients, $key, $key_id, self::TYPE_ERROR);
    }
    /**
     * Creates a success notification
     *
     * @param string $key
     * @param integer $user_id The user id that will get the notification
     * @param integer $key_id The notification key id
     * @return bool Returns TRUE on success, FALSE on failure
     */
    public static function success(array $transports, array $recipients, $key, $key_id = null)
    {
        return static::notify($transports, $recipients, $key, $key_id, self::TYPE_SUCCESS);
    }

}