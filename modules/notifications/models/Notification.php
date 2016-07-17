<?php
namespace app\modules\notifications\models;

use Yii;
use Exception;
use yii\base\Model;
use app\modules\notifications\Module;

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
     * @param array $recipients
     * @param integer $key notification key
     * @param integer $key_id The foreign instance id
     * @param string $type
     * @return bool Returns TRUE on success, FALSE on failure
     * @throws \Exception
     */
    public static function notify(array $recipients, $key, $key_id = null, $type = self::TYPE_DEFAULT)
    {
        $class = self::className();

        if (!array_key_exists($key, $class::$keys)) {
            throw new Exception("Not a registered notification key: $key");
        }
        if (!in_array($type, self::$types)) {
            throw new Exception("Unknown notification type: $type");
        }

        $instance = new $class([
            'recipients'    =>  $recipients,
            'key'           =>  $key,
            'key_id'        =>  $key_id,
            'type'          =>  $type,
        ]);

        return Module::notify($instance);
    }
    /**
     * Creates a warning notification
     *
     * @param array $recipients
     * @param integer $key notification key
     * @param integer $key_id The foreign instance id
     * @return bool Returns TRUE on success, FALSE on failure
     */
    public static function warning(array $recipients, $key, $key_id = null)
    {
        return static::notify($recipients, $key, $key_id, self::TYPE_WARNING);
    }
    /**
     * Creates an error notification
     *
     * @param array $recipients
     * @param integer $key notification key
     * @param integer $key_id The foreign instance id
     * @return bool Returns TRUE on success, FALSE on failure
     */
    public static function error(array $recipients, $key, $key_id = null)
    {
        return static::notify($recipients, $key, $key_id, self::TYPE_ERROR);
    }
    /**
     * Creates a success notification
     *
     * @param array $recipients
     * @param integer $key notification key
     * @param integer $key_id The foreign instance id
     * @return bool Returns TRUE on success, FALSE on failure
     */
    public static function success(array $recipients, $key, $key_id = null)
    {
        return static::notify($recipients, $key, $key_id, self::TYPE_SUCCESS);
    }

}