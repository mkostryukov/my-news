<?php
namespace app\controllers\user;

use app\models\UserTransport;
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
 /*       				echo '<pre>';
                        print_r($model);
                        echo '</pre>';
                        die();*/

		if ($model->load(Yii::$app->request->post())) {
			if ($model->validate()) {
				// form inputs are valid, do something here
				$model->save();
				$this->refresh();
			}
		}

		return $this->render('notifications', [
			'model' => $model,
		]);
    }

}