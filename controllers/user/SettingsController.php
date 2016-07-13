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

		if ($model->load(Yii::$app->request->post())) {
				echo '<pre>';
				print_r(Yii::$app->request->post());
				echo '</pre>';
				die();
			if ($model->validate()) {
				// form inputs are valid, do something here
				$this->refresh();
			}
		}

		return $this->render('notifications', [
			'model' => $model,
		]);
    }

}