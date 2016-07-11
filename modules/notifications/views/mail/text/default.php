<?php

use yii\helpers\Url;

/**
 * @var app\modules\notifications\models\Notification  $notification
 */
?>
    <?= Yii::t('app', 'Hello') ?>,
    <?= Yii::t('app', 'This is notification message from {0}', Yii::$app->name) ?>.
    <?= $notification->getTitle() ?>.
    <?= $notification->getDescription() ?>
    <?= $notification->getRoute() ?>
