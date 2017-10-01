<?php

use app\widgets\Avatar;
use yii\helpers\Markdown;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;

/**
 * @var app\models\Comment[] $comments
 * @var yii\widgets\ActiveForm $form
 * @var app\models\Comment $commentForm
 */

\app\assets\MarkdownEditorAsset::register($this);
?>
<div class="row">
<div class="col-md-offset-2 col-md-7 col-xs-12">

<h1 style="font-weight:bold;font-size:19px;margin-bottom:30px;">Comments (<?= count($comments) ?>)</h1>

<ol class="comments">
    <?php foreach ($comments as $comment): ?>
        <li id="c<?= $comment->id ?>" class="row">
            <div class="col-md-3 col-xs-6 author">
                <?= Html::a(Avatar::widget(['user' => $comment->user]) . ' <span class="user-handle">@' . Html::encode($comment->user->username) . '</span>', ['user/view', 'id' => $comment->user->id]) ?>
            </div>
            
            <div class="col-md-9 col-xs-6">
                <span class="date"><?= Yii::$app->formatter->asDate($comment->created_at) ?></span>
            </div>
            <div class="col-xs-12 text">
                <?= HtmlPurifier::process(Markdown::process($comment->text, 'gfm-comment'), [
                    'HTML.SafeIframe' => true,
                    'URI.SafeIframeRegexp' => '%^(https?:)?//(www\.youtube(?:-nocookie)?\.com/embed/|player\.vimeo\.com/video/)%',
                ]) ?>
            </div>
        </li>
    <?php endforeach ?>
</ol>

<?php if (!Yii::$app->user->isGuest): ?>

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($commentForm, 'text')->label('Add new comment')->textarea() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('news', 'Comment'), ['class' => 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>
<?php else: ?>
    <p>Signup in order to comment.</p>
<?php endif ?>

</div>
</div>