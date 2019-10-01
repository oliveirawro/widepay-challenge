<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'Home';
$this->params['breadcrumbs'][] = $this->title;
?>



<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <p class='subtitle'>Welcome to Interwebs Corp. URL Check Tool!</p>
    <p class='texto' style="margin-top:30px">Please use our menu or <?=Html::a("CLICK HERE" ,["url/index"]); ?> to check all our urls.</p>

</div>
