<?php

use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'Аукционы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auction-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'name',
            'min_bid',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
