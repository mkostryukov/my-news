<?php

use yii\helpers\Html;
use app\widgets\PageSizerListView;

$this->title = Yii::t('app', 'Articles');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-index">

    <h1><?= Html::encode($this->title) ?></h1>

<?= PageSizerListView::widget([
        'dataProvider' => $dataProvider,
		'itemView' => '_article',
		'layout' => "{sizer}{summary}{items}{pager}",
		'sizerVariants' => array(10, 20, 30),
		'sizerAttribute' => 'size',
	]); 
?>
</div>
