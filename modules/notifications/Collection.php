<?php
namespace app\modules\notification;

use yii\base\Component;
use yii\base\InvalidParamException;
use Yii;

/**
 * Collection is a storage for all notification transports in the application.
 *
 * Example application configuration:
 *
 * ```php
 * 'components' => [
 *     'notificationTransportCollection' => [
 *         'class' => 'app\modules\notifications\Collection',
 *         'transports' => [
 *             'mail' => [
 *                 'class' => 'app\modules\notifications\transports\Mail'
 *             ],
 *             'web' => [
 *                 'class' => 'app\modules\notifications\transports\Web',
 *             ],
 *         ],
 *     ]
 *     ...
 * ]
 * ```
 *
 * @property NotificationTransportInterface[] $transports List of notification transports. This property is read-only.
 *
 */
class Collection extends Component
{
    /**
     * @var array list of Notification transports with their configuration in format: 'transportId' => [...]
     */
    private $_transports = [];


    /**
     * @param array $transports list of notification transports
     */
    public function setTransports(array $transports)
    {
        $this->_transports = $transports;
    }

    /**
     * @return NotificationTransportInterface[] list of notification transports.
     */
    public function getTransports()
    {
        $transports = [];
        foreach ($this->_transports as $id => $transports) {
            $transports[$id] = $this->getTransport($id);
        }

        return $transports;
    }

    /**
     * @param string $id service id.
     * @return transportInterface notification transport instance.
     * @throws InvalidParamException on non existing transport request.
     */
    public function getTransport($id)
    {
        if (!array_key_exists($id, $this->_transports)) {
            throw new InvalidParamException("Unknown notification transport '{$id}'.");
        }
        if (!is_object($this->_transports[$id])) {
            $this->_transports[$id] = $this->createTransport($id, $this->_transports[$id]);
        }

        return $this->_transports[$id];
    }

    /**
     * Checks if transport exists in the hub.
     * @param string $id transport id.
     * @return boolean whether transport exist.
     */
    public function hasTransport($id)
    {
        return array_key_exists($id, $this->_transports);
    }

    /**
     * Creates notification transport instance from its array configuration.
     * @param string $id notification transport id.
     * @param array $config notification transport instance configuration.
     * @return transportInterface notification transport instance.
     */
    protected function createTransport($id, $config)
    {
        $config['id'] = $id;

        return Yii::createObject($config);
    }
}
