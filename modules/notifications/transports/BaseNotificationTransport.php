<?
namespace app\modules\notifications\transports;

use yii\helpers\Inflector;
use yii\helpers\StringHelper;
use app\modules\notifications\models\Notification;

abstract class BaseNotificationTransport implements NotificationTransportInterface
{
    /**
     * @var string transport id.
     * This value mainly used as HTTP request parameter.
     */
	private $_id;

    /**
     * @var string transport name.
     * This value may be used in database records, CSS files and so on.
     */
	private $_name;

    /** @var Notification */
    protected $notification;

    /**
     * @param string $id transport id.
     */
    public function setId($id)
    {
        $this->_id = $id;
    }

    /**
     * @return string transport id
     */
    public function getId()
    {
        if (empty($this->_id)) {
            $this->_id = $this->getName();
        }

        return $this->_id;
    }

    /**
     * @param string $name transport name.
     */
    public function setName($name)
    {
        $this->_name = $name;
    }

    /**
     * @return string transport name.
     */
    public function getName()
    {
        if ($this->_name === null) {
            $this->_name = $this->defaultName();
        }

        return $this->_name;
    }

    /**
     * Generates service name.
     * @return string service name.
     */
    protected function defaultName()
    {
        return Inflector::camel2id(StringHelper::basename(get_class($this)));
    }

    /**
     * Sets transport notification object
     * @param Notification $notification
     */
    public function setNotification(Notification $notification) {
        $this->notification = $notification;
    }

    /**
     * @return Notification
     */
    public function getNotification() {
        return $this->notification;
    }

    /**
     * @param Notification $notification to be sent.
     * @return bool true if successful
     */
    public function sendNotification(Notification $notification)
	{
		return false;
	}
	
}