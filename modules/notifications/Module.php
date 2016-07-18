<?php
namespace app\modules\notifications;

use app\modules\notifications\transports\NotificationTransportInterface;
use Yii;
use Exception;
use yii\base\Module as BaseModule;
use app\modules\notifications\models\Notification;

class Module extends BaseModule
{
    public $transportCollectionName = 'notificationTransportCollection';
    /**
     * @var callable|integer The current user id
     */
    public $userId;
    /**
     * @array transports The NotificationTransport class array defined by the application
     */
    private $_transports;
    

    public function getTransports()
    {
        return $this->_transports;
    }
    
    /**
     * @inheritdoc
     */
    public function init() {
        if (is_callable($this->userId)) {
            $this->userId = call_user_func($this->userId);
        }
        $collection = Yii::$app->get($this->transportCollectionName);
        $this->_transports = $collection->getTransports();
        parent::init();
    }
    
    /**
     * Creates a notification
     *
     * @param Notification $instance - notification instance
     * @return bool Returns TRUE on success, FALSE on failure
     * @throws Exception
     */
    public function notify(Notification $instance)
    {
        $results = [];
        /** @var NotificationTransportInterface $transport */
        foreach ($this->_transports as $transport) {
            $results[$transport->getName()] = $transport->sendNotification($instance);
        }
        return $results;
    }
}