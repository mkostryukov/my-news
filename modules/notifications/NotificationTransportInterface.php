<?php

namespace app\modules\notifications;

use app\modules\notifications\models\Notification;

interface NotificationTransportInterface
{
    public function sendNotification(Notification $notification);
}
