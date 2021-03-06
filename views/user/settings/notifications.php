<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/*
 * @var $this  yii\web\View
 * @var $form  yii\widgets\ActiveForm
 * @var $model dektrium\user\models\SettingsForm
 */

$this->title = Yii::t('user', 'Notifications settings');
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('/_alert', ['module' => Yii::$app->getModule('user')]) ?>

<div class="row">
	<div class="col-md-3">
		<?= $this->render('_menu') ?>
	</div>
	<div class="col-md-9">
		<div class="panel panel-default">
			<div class="panel-heading">
				<?= Html::encode($this->title) ?>
			</div>
			<div class="panel-body">

			<?php $form = ActiveForm::begin([
				'id'          => 'notifications-form',
				'options'     => ['class' => 'form-horizontal'],
				'fieldConfig' => [
					'template'     => "{label}\n<div class=\"col-lg-9\">{input}</div>\n<div class=\"col-sm-offset-3 col-lg-9\">{error}\n{hint}</div>",
					'labelOptions' => ['class' => 'col-lg-3 control-label'],
				],
				'enableAjaxValidation'   => false,
				'enableClientValidation' => false,
			]); ?>

				<?= Html::activeHiddenInput($model, 'user_id') ?>
				<?= $form->field($model, 'transports', [
                    ])->checkboxList($model->transportNames, [
                        'tag' => "div style=\"padding-top: 7px;\"",
                        'separator' => '<br />',
                ]) ?>
				<?= $form->field($model, 'notifications')->checkboxList($model->NotificationKeys, [
                        'tag' => "div style=\"padding-top: 7px;\"",
                        'separator' => '<br />',
                    ]
					) ?>

				<div class="form-group">
					<div class="col-lg-offset-3 col-lg-9">
						<?= Html::submitButton(Yii::t('user', 'Save'), ['class' => 'btn btn-block btn-success']) ?><br>
					</div>
				</div>
			<?php ActiveForm::end(); ?>

			</div>
		</div>
	</div>
</div>
