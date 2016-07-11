<?php
namespace app\modules\notifications;

use Exception;
use yii\base\Module;
use app\modules\notifications\models\Notification;

class NotificationsModule extends Module
{
    /**
     * @var string The controllers namespace
     */
    public $controllerNamespace = 'app\modules\notifications\controllers';
    /**
     * @array transports The NotificationTransport class array defined by the application
     */
    public $notificationTransport = [];
    /**
     * @var callable|integer The current user id
     */
    public $userId;
    /**
     * @inheritdoc
     */
    public function init() {
        if (is_callable($this->userId)) {
            $this->userId = call_user_func($this->userId);
        }
        parent::init();
    }
    /**
     * Creates a notification
     *
     * @param Notification $notification The Notification class
     * @param string $key The notification key
     * @param integer $user_id The user id that will get the notification
     * @param integer $key_id The key unique id
     * @param string $type The notification type
     * @return bool Returns TRUE on success, FALSE on failure
     * @throws Exception
     */
    public static function notify($notificationClass, $transports, $recipients, $key, $key_id = null, $type = Notification::TYPE_DEFAULT)
    {
        if (!in_array($key, $notificationClass::$keys)) {
            throw new Exception("Not a registered notification key: $key");
        }
        if (!in_array($type, Notification::$types)) {
            throw new Exception("Unknown notification type: $type");
        }
        if (!is_array($transports)) {
            throw new Exception("You must provide an array of transport classes");
        }
        /** @var Notification $instance */
        $instance = new $notificationClass([
            'recipients'    =>  $recipients,
            'type'          =>  $type,
            'key'           =>  $key,
            'key_id'        =>  $key_id,
        ]);
        $results = [];
        foreach ($transports as $transportClass) {
            if (class_exists($transportClass)) {
                /** @var NotificationTransportInterface $transport */
                $transport = new $transportClass();
                $results[] = $transport->sendNotification($instance);
            }
            else
                throw new Exception("Transport class not declared: $transportClass");
        }
        return true;
    }
}