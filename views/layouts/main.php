<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
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
        'brandLabel' => 'Library',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);

    if (Yii::$app->user->isGuest) {
        $items[] = ['label' => 'Login', 'url' => Yii::$app->user->loginUrl];
    } else {
        if (Yii::$app->user->identity->can('Director')) {
            $items[] = ['label' => 'Admins', 'url' => ['/area/admin']];
        }
        if (Yii::$app->user->identity->can('Administrator')) {
            $items[] = ['label' => 'Books', 'url' => ['/area/book']];
            $items[] = ['label' => 'Clients', 'url' => ['/area/client']];
            $items[] = ['label' => 'Journal', 'url' => ['/area/journal']];
        }
        if (Yii::$app->user->identity->can('Reader')) {
            $items[] = ['label' => 'Personal Area', 'url' => ['/area/personal-area']];
        }

        $items[] = '<li>'
            . Html::beginForm(['site/logout'], 'post')
            . Html::submitButton(
                'Logout (' . Yii::$app->user->identity->username . ')',
                ['class' => 'btn btn-link logout']
            )
            . Html::endForm()
            . '</li>';
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $items
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

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
