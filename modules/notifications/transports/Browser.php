<?php
namespace app\modules\notifications\transports;

use Yii;
use yii\db\Expression;
use app\modules\notifications\models\Notification;
use app\modules\notifications\models\Browsernotification;

class Browser extends BaseNotificationTransport
{
    /** @var string */
    protected $addressPropertyName = 'id';

    public function sendNotification(Notification $notification)
    {
        foreach ($notification->recipients as $recipient) {
            if (array_key_exists($this->getId(), $recipient->transports)) {
                $address = $recipient->{$this->addressPropertyName};
                $model = new Browsernotification([
                    'user_id' => $address,
                    'key' => $notification->key,
                    'key_id' => $notification->key_id,
                    'type' => $notification->type,
                    'seen' => 0,
                    'created_at' => time(),
                ]);
                return $model->save();
            }
        }
        return true;
    }

    /**
     * @inheritdoc
     */
    protected function defaultName()
    {
        return 'Web notifications';
    }

}