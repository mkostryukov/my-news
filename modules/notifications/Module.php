<?php
namespace app\modules\notifications;

use app\modules\notifications\transports\NotificationTransportInterface;
use Yii;
use Exception;
use yii\base\Module as BaseModule;
use app\modules\notifications\models\Notification;

class Module extends BaseModule
{
    /**
     * @var string name of the transport collection application component.
     * This component will be used to fetch services value if it is not set.
     */
    public $transportCollectionName = 'notificationTransportCollection';

    /**
     * @var string The controllers namespace
     */
    public $controllerNamespace = 'app\modules\notifications\controllers';

    /**
     * @var callable|integer The current user id
     */
    public $userId;

    /**
     * @var Notification The notification class defined by the application
     */
    public $notificationClass;

    /**
     * @array _transports The NotificationTransportInterface class array defined by the application
     */
    private $_transports;

    public function getTransports()
    {
        return $this->_transports;
    }
	
	public function getTransport($id)
	{
		if (isset($this->_transports[$id]))
			return false;
		return $this->_transports[$id];
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
     * @return array
     * @throws Exception
     */
    public function notify(Notification $instance)
    {
        $results = [];
        /** @var NotificationTransportInterface $transport */
        foreach ($this->_transports as $transport) {
            $results[$transport->getId()] = $transport->sendNotification($instance);
        }
        return $results;
    }
}