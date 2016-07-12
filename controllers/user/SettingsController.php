<?php
namespace app\controllers\user;

use Yii;
use dektrium\user\controllers\SettingsController as BaseSettingsController;
use app\models\UserNotifications;

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
        $model = $this->finder->findUserById(Yii::$app->user->identity->getId());

		if ($model->load(Yii::$app->request->post())) {
			if ($model->validate()) {
				// form inputs are valid, do something here
				return;
			}
		}

		return $this->render('notifications', [
			'model' => $model,
		]);
    }

}