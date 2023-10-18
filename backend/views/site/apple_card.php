<?php

use common\models\Apple;
use yii\helpers\Html;
use yii\web\View;

/* @var $this  View */
/* @var $model Apple */
/* @var $index */
?>
<div class="h5"><?= ucfirst($model->color) ?> apple <?= $model->status->name ?> size: <?= $model->size ?></div>
<div class="row">
    <div class="col-md-6">
        <?= Html::a('Упасть', null, [
            'style' => 'cursor:pointer',
            'class' => 'btn btn-success',
            'data-id' => $model->id,
        ]);
        ?>
    </div>
    <div class="col-md-6">
        <?= Html::a('Удалить', null, [
            'style' => 'cursor:pointer',
            'class' => 'btn btn-warning',
            'data-id' => $model->id,
        ]);
        ?>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <?= Html::input('number', 'eat_percent', '', ['min' => 1, 'max' => 100, 'style' => 'width: 60%']) ?>
        <?= Html::a('Съесть', null, [
            'style' => 'cursor:pointer',
            'class' => 'btn btn-info',
            'data-id' => $model->id,
        ]);
        ?>
    </div>
</div>

