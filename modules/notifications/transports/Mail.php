<?php
namespace app\modules\notifications\transports;

use Yii;
use app\modules\notifications\models\Notification;

class Mail extends BaseNotificationTransport
{
	
	/** @var string */
    public $viewPath = '@app/modules/notifications/views/mail';

    /** @var string|array Default: `Yii::$app->params['adminEmail']` OR `no-reply@example.com` */
    public $sender;

    /** @var string */
    protected $subject = null;

    /** @var Notification */
    protected $notification;

    public function setNotification(Notification $notification) {
        $this->notification = $notification;
    }
    
    public function getNotification() {
        return $this->notification;
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
    public function sendNotification(Notification $notification) {
        $addresses = [];
        foreach ($notification->recipients as $recipient)
            $addresses = $recipient->email;
        return $this->sendMessage($addresses,
            $notification->getTitle(),
            'default',
            ['notification' => $notification]
        );
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