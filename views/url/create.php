<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Url */

$this->title = 'Create Url';
$this->params['breadcrumbs'][] = ['label' => 'Urls', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<!-- top bar create  -->
<div id="title-bar" class="container">
    <div style="float: left">
        <h2 class="title" style="margin:0px 0px 40px 0px"><?= Html::encode($this->title) ?></h2>
    </div>

    <div id="buttons">
        <?=Html::a("<i class='fa fa-caret-left'></i> " . "Back" ,["index"], ["class" => "cla-btn btn-primary"]); ?>
    </div>
</div>
<!-- end top bar create -->


<div class="url-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
