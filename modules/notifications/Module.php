<?php
namespace app\modules\notifications;

use app\modules\notifications\transports\NotificationTransportInterface;
use Exception;
use yii\base\Module as BaseModule;
use app\modules\notifications\models\Notification;

class Module extends BaseModule
{
    public $transportCollection = 'notificationTransportCollection';
    /**
     * @array transports The NotificationTransport class array defined by the application
     */
    public $notificationTranspors;
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
     * @param Notification $instance - notification instance
     * @return bool Returns TRUE on success, FALSE on failure
     * @throws Exception
     */
    public static function notify(Notification $instance)
    {
        $results = [];
        /** @var NotificationTransportInterface $transport */
        foreach ($this->notificationTransports as $transport) {
            $results[$transport->getName()] = $transport->sendNotification($instance);
        }
        return $results;
    }
}