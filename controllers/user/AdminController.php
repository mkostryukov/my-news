<?php
namespace app\controllers\user;

use Yii;
use yii\helpers\Url;
use dektrium\user\controllers\AdminController as BaseAdminController;
use app\models\NotificationsForm;

class AdminController extends BaseAdminController
{
    public function behaviors()
    {
        $ret = parent::behaviors();
        $ret['access']['rules'][] = [
            'allow'   => true,
            'actions' => ['notifications'],
            'roles'   => ['@'],
        ];
        return $ret;
    }

    public function actionUpdateNotifications($id)
    {
        Url::remember('', 'actions-redirect');
        $user    = $this->findModel($id);
        $model = new NotificationsForm($user);

        $this->performAjaxValidation($model);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->getSession()->setFlash('success', Yii::t('user', 'Notifications settings have been updated'));
            return $this->refresh();
        }

        return $this->render('_notifications', [
            'model' => $model,
            'user' => $user,
        ]);
    }

}