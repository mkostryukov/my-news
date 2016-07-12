<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\UserNotifications */
/* @var $form ActiveForm */
?>
<div class="notifications">

    <?php $form = ActiveForm::begin(); ?>

		<?= Html::activeHiddenInput($model, 'id') ?>
		<?  $names = $model->getTransportNames(); ?>
		<?= $form->field($model, 'transports')->listBox(
			$names,
			[
				'multiple' => true
			]
			) ?>
		<?= $form->field($model, 'notifications')->listBox(
			$model->NotificationKeys,
			[
				'multiple' => true
			]
			) ?>
    
        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', 'Submit'), ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- notifications -->
