<?php

namespace app\modules\notifications;

interface NotificationInterface
{
    public function poll();

    public static static|null findOne ($condition);

}
