<?php
use app\models\Comment;
use app\widgets\Avatar;
use yii\helpers\Html;
use \yii\helpers\HtmlPurifier;
use yii\helpers\Markdown;

/* @var $model Comment */
?>
<div class="row">
    <div class="col-xs-2 info">
    <p class="author">
    <?= Html::a(Avatar::widget(['user' => $model->user, 'size' => 48]), ['user/view', 'id' => $model->user->id]) ?>
    </p>
    <p class="twitter-handle">
    <?= Html::a('@' . Html::encode($model->user->username), ['user/view', 'id' => $model->user->id]) ?>
    </p>
    </div>
    <div class="col-xs-5 text well">
        <?= HtmlPurifier::process(Markdown::process($model->text, 'gfm-comment'), [
            'HTML.SafeIframe' => true,
            'URI.SafeIframeRegexp' => '%^(https?:)?//(www\.youtube(?:-nocookie)?\.com/embed/|player\.vimeo\.com/video/)%',
        ]) ?>
    </div>
    <div class="col-xs-2">
        <?= Html::a(Yii::t('comments', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('comments', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </div>
    <div class="col-xs-3 well">
        <a href="#c<?= $model->id ?>">#<?= $model->id ?></a>
        <span class="date"><?=Yii::$app->formatter->format($model->created_at, 'datetime')?></span>

        → <?= Html::a(Html::encode($model->news->title), ['/news/view', 'id' => $model->news->id])?>
    </div>
</div>
