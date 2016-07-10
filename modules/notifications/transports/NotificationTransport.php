<?php
namespace app\modules\notifications\transports;

use app\modules\notifications\models\Notification;

abstract class NotificationTransport implements NotificationTransportInterface
{
    /**
     * Delivers notificatiation
     *
     * @param Notification $notification Notification to send
     * @return bool Returns TRUE on success, FALSE on failure
     */
    abstract public function sendNotification(Notification $notification);
}