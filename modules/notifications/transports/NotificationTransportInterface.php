<?php

namespace app\modules\notifications\transports;

use app\modules\notifications\models\Notification;

interface NotificationTransportInterface
{
    public function sendNotification(Notification $notification);
}
