<?php
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
?>
<div class="post">
<? if (\Yii::$app->user->can('manageArticles') || \Yii::$app->user->can('viewArticle')) : ?>
    <h2><?= Html::a(Html::encode($model->title), ['article/view', 'id' => $model->id]) ?></h2>
<? else : ?>
    <h2><?= Html::encode($model->title) ?></h2>
<? endif; ?>

    <?= HtmlPurifier::process($model->intro) ?>    
</div>