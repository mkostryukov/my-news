<?php
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
?>
<div class="article">
    <h2><?= HtmlPurifier::process($model->title) ?></h2>

    <div class="article-intro"><i><?= HtmlPurifier::process($model->intro) ?></i></div>

    <p></p>

    <div class="article-body"><?= HtmlPurifier::process($model->body) ?></div>
</div>