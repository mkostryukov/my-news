<?php
namespace app\modules\notifications\transports;

use Yii;
use app\modules\notifications\models\Notification;

class Mail extends BaseNotificationTransport
{
    /** Separate letter to each recipient. */
    const SEPARATE_LETTERS = 'separate';

    /** One letter for all recipients. */
    const ONE_LETTER_FOR_ALL = 'allinone';

	/** @var string */
    public $viewPath = '@app/modules/notifications/views/mail';

    /** @var string|array Default: `Yii::$app->params['adminEmail']` OR `no-reply@example.com` */
    public $sender;

    /** @var int email sending method */
    public $emailSendMethod = self::SEPARATE_LETTERS;

    /** @var string */
    protected $addressPropertyName = 'email';

    /** @var string */
    protected $subject = null;

    /**
     * @inheritdoc
     */
    protected function defaultName()
    {
        return 'Mail notification';
    }

    /**
     * @return string
     */
    public function getSubject()
    {
        if ($this->subject == null) {
            $this->setSubject(Yii::t('app', '{0} notification', Yii::$app->name));
        }

        return $this->subject;
    }

    /**
     * @param string $subject
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;
    }

    /**
     * Send notification via transport
     *
     * @return bool
     */
    public function sendNotification(Notification $notification, $view = 'default') {

        $addresses = [];
        $results = [];
        foreach ($notification->recipients as $recipient) {
            if (array_key_exists($this->getId(), $recipient->transports)) {
                $address = $recipient->{$this->addressPropertyName};
                if ($this->emailSendMethod == self::SEPARATE_LETTERS)
                    $results = $this->sendMessage([$address], $notification->getTitle(), $view, ['notification' => $notification]);
                else
                    $addresses[] = $address;
            }
        }
        if ($this->emailSendMethod == self::SEPARATE_LETTERS)
            return $results;
        else
            return $this->sendMessage($addresses, $notification->getTitle(), $view, ['notification' => $notification]);
	}

    /**
     * @param string|array $to
     * @param string $subject
     * @param string $view
     * @param array  $params
     *
     * @return bool
     */
    protected function sendMessage($to, $subject, $view, $params = [])
    {
        /** @var \yii\mail\BaseMailer $mailer */
        $mailer = Yii::$app->mailer;
        $mailer->viewPath = $this->viewPath;
        $mailer->getView()->theme = Yii::$app->view->theme;

        if ($this->sender === null) {
            $this->sender = isset(Yii::$app->params['adminEmail']) ? Yii::$app->params['adminEmail'] : 'no-reply@example.com';
        }
        
        return $mailer->compose(['html' => $view, 'text' => 'text/' . $view], $params)
            ->setTo($to)
            ->setFrom($this->sender)
            ->setSubject($subject)
            ->send();
    }

}