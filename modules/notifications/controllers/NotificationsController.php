<?php
namespace app\modules\notifications\controllers;

use Yii;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\HttpException;
use yii\web\Response;
use app\modules\notifications\models\Notification;
use app\modules\notifications\models\Browsernotification;

class NotificationsController extends Controller
{
    /**
     * @var integer The current user id
     */
    private $user_id;
    /**
     * @var string The notification class
     */
    private $notificationClass;
    /**
     * @inheritdoc
     */
    public function init()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $this->user_id = $this->module->userId;
        $this->notificationClass = $this->module->notificationClass;
        parent::init();
    }
    /**
     * Poll action
     *
     * @param int $seen Whether to show already seen notifications
     * @return array
     */
    public function actionPoll($seen = 0)
    {
        /** @var Notification $class */
        $models = Browsernotification::find()->where([
            'user_id' => $this->user_id,
            'seen' => $seen
        ])->all();
        $results = [];
        foreach ($models as $model) {
            /** @var Notification $notification */
            $notification = new $this->notificationClass([
                    'key' => $model->key,
                    'key_id' => $model->key_id,
            ]);
            /** @var Notification $model */
            $results[] = [
                'id' => $model->id,
                'type' => $model->type,
                'title' => $notification->getTitle(),
                'description' => $notification->getDescription(),
                'url' => Url::to(['notifications/rnr', 'id' => $model->id]),
                'key' => $model->key,
                'date' => date('Y-m-d H:i:s', $model->created_at),
            ];
        }
        return $results;
    }
    /**
     * Marks a notification as read and redirects the user to the final route
     *
     * @param int $id The notification id
     * @return Response
     * @throws HttpException Throws an exception if the notification is not
     *         found, or if it don't belongs to the logged in user
     */
    public function actionRnr($id)
    {
        $model = $this->actionRead($id);
        /** @var Notification $notification */
        $notification = new $this->notificationClass([
            'key' => $model->key,
            'key_id' => $model->key_id,
        ]);
        return $this->redirect(Url::to($notification->getRoute()));
    }
    /**
     * Marks a notification as read
     *
     * @param int $id The notification id
     * @return Notification The updated notification record
     * @throws HttpException Throws an exception if the notification is not
     *         found, or if it don't belongs to the logged in user
     */
    public function actionRead($id)
    {
        $model = $this->getNotification($id);
        $model->seen = 1;
        $model->save();
        return $model;
    }
    /**
     * Deletes a notification
     *
     * @param int $id The notification id
     * @return int|false Returns 1 if the notification was deleted, FALSE otherwise
     * @throws HttpException Throws an exception if the notification is not
     *         found, or if it don't belongs to the logged in user
     */
    public function actionDelete($id)
    {
        $model = $this->getNotification($id);
        return $model->delete();
    }
    /**
     * Gets a notification by id
     *
     * @param int $id The notification id
     * @return Browsernotification
     * @throws HttpException Throws an exception if the notification is not
     *         found, or if it don't belongs to the logged in user
     */
    private function getNotification($id)
    {
        /** @var Notification $notification */
        $model = Browsernotification::findOne($id);
        if (!$model) {
            throw new HttpException(404, "Unknown notification");
        }
        if ($model->user_id != $this->user_id) {
            throw new HttpException(500, "Not your notification");
        }
        return $model;
    }
}