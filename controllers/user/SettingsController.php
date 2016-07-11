<?php
namespace app\controllers\user;

use dektrium\user\controllers\AdminController as BaseAdminController;

class SettingsController extends BaseSettingsController
{
    public function actionNotifications()
    {
        /** @var SettingsForm $model */
        $model = Yii::createObject(NotificationsForm::className());
        $event = $this->getFormEvent($model);

        $this->performAjaxValidation($model);

        $this->trigger(self::EVENT_BEFORE_NOTIFICATIONS_UPDATE, $event);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', Yii::t('user', 'Your notifications details have been updated'));
            $this->trigger(self::EVENT_AFTER_NOTIFICATIONS_UPDATE, $event);
            return $this->refresh();
        }

        return $this->render('notifications', [
            'model' => $model,
        ]);        
    }
}