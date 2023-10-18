<?php

/** @var yii\web\View $this */

/** @var \yii\data\ActiveDataProvider $provider */

use yii\helpers\Html;
use yii\widgets\ListView;
use yii\widgets\Pjax;

$this->title = 'Apple test';
?>
<div class="site-index">
    <div class="body-content">
        <div id="generator" class="box">
            <?= Html::beginForm() ?>

            <?= Html::dropDownList('num_apples', '', [
                'random' => 'Cлучайное количество',
                1 => 1,
                2 => 2,
                3 => 3,
                5 => 5,
                10 => 10,
                20 => 20
            ]) ?>
            <?= Html::submitButton('Сгенерировать яблоки', ['class' => 'btn btn-success']) ?>

            <?= Html::endForm() ?>
        </div>
        <div>
            <?php Pjax::begin(['id' => 'listPjax']); ?>
            <?= ListView::widget([
                'dataProvider' => $provider,
                'itemView' => 'apple_card',
                'layout' => '{items}',
                'options' => [
                    'class' => 'row',
                ],
                'itemOptions' => [
                    'class' => 'col-md-3 item',
                    'style' => 'border: solid'
                ],
            ]); ?>
            <?php Pjax::end() ?>
        </div>
    </div>
</div>
