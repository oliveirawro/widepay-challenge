<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\icons\Icon;
use kartik\switchinput\SwitchInput;

/* @var $this yii\web\View */
/* @var $model app\models\Url */
/* @var $form yii\widgets\ActiveForm */
?>





<div class="url-form form-gray">

    <?php $form = ActiveForm::begin(); ?>


    <div class="" style="height: 250px">





        <?= Html::label('Status', '', ['class' => 'col-sm-2 subtitle']);?>

        <div class="col-sm-10">
            <?php
            if (!isset($model->Status)) { //se for um novo registro padrão é true
                $model->Status = true;
            }
            echo $form->field($model, 'Status')->widget(SwitchInput::classname(), [
                'pluginOptions'=>[
                    //'size' => 'mini',
                    'handleWidth'=>50,
                    'onText'=>Yii::t('app', 'Active'),
                    'offText'=>Yii::t('app', 'Inactive'),
                    'onColor' => 'success',
                    'offColor' => 'danger',
                ]
            ])->label(false);





            ?>
        </div>



        <?= Html::label('Address', '', ['class' => 'col-sm-2 subtitle']);?>

        <div class="col-sm-10">
            <?= $form->field($model, 'Address')->textInput(['maxlength' => true, 'style' => 'width:350px;', 'min' => 4])->label(false) ?>
        </div>


    </div>


    <div class="form-group" style="float: right">
        <?=Html::button(Yii::t('app', 'Cancel'), ['class' => 'cla-btn btn-danger', 'onclick' => 'window.history.back();return false;']) ?>
        <?=Html::submitButton(Yii::t('app', '{icon} Save', ['icon' => Icon::show('check')]), ['id' => 'submitBtn', 'class' => 'cla-btn btn-success', 'onclick' => 'ValidURL();return false;']);?>
    </div>

    <?php ActiveForm::end(); ?>

</div>




