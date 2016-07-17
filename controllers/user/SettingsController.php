<?php
namespace app\controllers\user;

use Yii;
use dektrium\user\controllers\SettingsController as BaseSettingsController;
use app\models\NotificationsForm;

class SettingsController extends BaseSettingsController
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

    public function actionNotifications()
    {
        $model = new NotificationsForm();

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			Yii::$app->getSession()->setFlash('success', Yii::t('user', 'Your notifications settings have been updated'));
			return $this->refresh();
		}

		return $this->render('notifications', [
			'model' => $model,
		]);
    }

}