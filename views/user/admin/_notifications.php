<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/*
 * @var $this  yii\web\View
 * @var $form  yii\bootstrap\ActiveForm
 * @var $model app\models\NofificationsForm
 */
?>

<?php $this->beginContent('@dektrium/user/views/admin/update.php', ['user' => $user]) ?>

<?php $form = ActiveForm::begin([
    'layout' => 'horizontal',
    'enableAjaxValidation' => true,
    'enableClientValidation' => false,
    'fieldConfig' => [
        'horizontalCssClasses' => [
            'wrapper' => 'col-sm-9',
        ],
    ],
]); ?>

<?= Html::activeHiddenInput($model, 'user_id') ?>
<?= $form->field($model, 'transports')->checkboxList($model->transportNames) ?>
<?= $form->field($model, 'notifications')->checkboxList($model->NotificationKeys) ?>
<div class="form-group">
    <div class="col-lg-offset-3 col-lg-9">
        <?= Html::submitButton(Yii::t('user', 'Update'), ['class' => 'btn btn-block btn-success']) ?>
    </div>
</div>

<?php ActiveForm::end(); ?>

<?php $this->endContent() ?>
