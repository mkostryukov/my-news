<?php
namespace app\modules\notifications\models;

use Yii;
use yii\db\ActiveRecord;
use app\modules\notifications\NotificationTrait;
use app\models\User;
use app\models\Article;

class MailNotification extends Component implements NotificationInterface
{
	use NotificationTrait;

    public function poll() {
		
	}
	/**
     * Gets the notification title
     *
     * @return string
     */
    public function getTitle();
    /**
     * Gets the notification description
     *
     * @return string
     */
    public function getDescription();
    /**
     * Gets the notification route
     *
     * @return string
     */
    public function getRoute();
    /**
     * @inheritdoc
     */
	 
	    /**
     * @param string $to
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