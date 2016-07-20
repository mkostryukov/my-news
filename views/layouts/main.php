<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use app\modules\notifications\widgets\BrowserNotificationWidget;

AppAsset::register($this);

BrowserNotificationWidget::widget([
    'theme' => BrowserNotificationWidget::THEME_TOASTR,
    'clientOptions' => [
        'location' => 'ru',
    ],
    'counters' => [
        '.notifications-header-count',
        '.notifications-icon-count'
    ],
    'listSelector' => '#notifications',
]);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => 'My Company',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
	$menuItems[] = ['label' => 'Home', 'url' => ['/site/index']];
	$menuItems[] = ['label' => 'About', 'url' => ['/site/about']];
	if (Yii::$app->user->isGuest) {
		$menuItems[] = ['label' => 'Login', 'url' => ['/user/security/login']];
		$menuItems[] = ['label' => 'Signup', 'url' => ['/user/registration/register']];
	}
	else {
        $nestedmenuItems[] = ['label' => 'Profile', 'url' => ['/user/settings/profile']];
        $nestedmenuItems[] = ['label' => 'Logout',  'url' => ['/user/security/logout'], 'linkOptions' => ['data-method' => 'post']];
		if (Yii::$app->user->can('manageArticles'))
            $nestedmenuItems[] = ['label' => 'Manage articles', 'url' => ['/article/index']];
		if (Yii::$app->user->can('adminPermission'))
            $nestedmenuItems[] = ['label' => 'Manage users', 'url' => ['/user/admin/index']];
		$menuItems[] = [
			'label' => 'User (' . Yii::$app->user->identity->username . ')',
			'items' => $nestedmenuItems,
		];
        $notificationItems[] = [
            'label' => '<i class="fa fa-bell-o"></i>&nbsp;<span class="notification-label label-warning notifications-icon-count">0</span>',
            'options' => ['class' => 'notifications-menu'],
            'items' => [
                ['label' => '<div id="notifications"></div>', 'encode' => false],
            ],
            'encode' => false,
        ];
        echo Nav::widget([
            'options' => ['class' => 'navbar-nav navbar-right'],
            'dropDownCaret' => '',
            'items' => $notificationItems,
        ]);
	}
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; My Company <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
