<?php

namespace app\modules\notifications\transports;

use app\modules\notifications\models\Notification;

interface NotificationTransportInterface
{
    /**
     * @param string $id transport id.
     */
    public function setId($id);

    /**
     * @return string transport id
     */
    public function getId();

    /**
     * @return string transport name.
     */
    public function getName();

    /**
     * @param string $name transport name.
     */
    public function setName($name);

    /**
     * @param Notification $notification to be sent.
     */
    public function sendNotification(Notification $notification);
}
