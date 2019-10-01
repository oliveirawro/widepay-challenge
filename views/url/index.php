<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\UrlSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Urls';
$this->params['breadcrumbs'][] = $this->title;
?>
<!-- top bar index -->
<div id="title-bar" class="container" style="">
    <div style="float: left">
        <h1 class="title"><?= Html::encode($this->title);?></h1>
    </div>

    <div id="buttons">
        <?=Html::a("<i class='fa fa-plus'></i> " . "Add",["create"], ["class" => "cla-btn btn-primary"]); ?>
    </div>

    <div class="form-inline well gradient_tb" style="margin-top: 70px">
        <?php echo $this->render('_search', ['model' => $searchModel]); ?>
    </div>

</div>
<!-- end top bar index -->



<div class="url-index">


    <script>

        $(function() {

            window.setInterval(function(){
                $.pjax.reload({container: '#pjax_id', async: false});
            }, 2000); //reloading after 2 seconds...

        });

    </script>



    <?php Pjax::begin(['id'=>'pjax_id', 'timeout' => 500]); ?>



    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'model' => $model,
        'layout' => '{items}{pager}{summary}',
        'columns' => [
            [
                'label' => '#',
                'attribute' => 'Code',
                'value' => 'Code',
                'contentOptions' => ['style' => 'width: 50px;text-align:center'],
                'headerOptions'  => ['style' => 'text-align:center'],
            ],

            [
                'label' => 'Address',
                'attribute' => 'Address',
                'value' => 'Address',
            ],


            [
                'label' => 'StatusCode',
                'attribute' => 'StatusCode',
                'value' => 'StatusCode',
            ],


            [
                'label' => 'DateTimeCreate',
                'attribute' => 'DateTimeCreate',
                'value' => 'DateTimeCreate',
            ],

            [
                'label' => 'DateTimeLastCheck',
                'attribute' => 'DateTimeLastCheck',
                'value' => 'DateTimeLastCheck',
            ],


            //'Response',


            [
                'label' => 'Status',
                'attribute' => 'Status',
                'value' => function ($data) {
                    return ($data['Status'] == 1) ? 'Active' : 'Inactive';
                },
            ],






            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}',
                'contentOptions' => ['style' => 'width: 80px;text-align:center'],
            ],

        ],
    ]); ?>

    <?php Pjax::end(); ?>



</div>
