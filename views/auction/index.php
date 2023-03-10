<?php

use yii\helpers\Html;

$this->title = 'Auctions';

?>

<div class="row">
    <?php foreach ($auctions as $auction): ?>
        <div class="col-md-4">
            
            <?= Html::a(Html::img($auction->photo, ['class' => 'card-img-top']), ['auction/view', 'id' => $auction->id]) ?>

            <h5 class="card-title"><?= Html::a(Html::encode($auction->name), ['auction/view', 'id' => $auction->id]) ?></h5>

            <p class="card-text"><?= Html::encode($auction->description) ?></p>

            <p class="card-text"><?= Yii::t('app', 'Starts at {time}', ['time' => Yii::$app->formatter->asDatetime($auction->start_time)]) ?></p>

            <?php if ($auction->isStarted()): ?>
                <?php if ($auction->isFinished()): ?>
                    <p class="card-text"><?= Yii::t('app', 'Finished at {time}', ['time' => Yii::$app->formatter->asDatetime($auction->end_time)]) ?></p>
                <?php else: ?>
                    <p class="card-text"><?= Yii::t('app', 'Current bid: {bid}', ['bid' => Yii::$app->formatter->asCurrency($auction->current_bid)]) ?></p>
                <?php endif ?>
            <?php else: ?>
                <p class="card-text"><?= Yii::t('app', 'Not started yet') ?></p>
            <?php endif ?>

        </div>
    <?php endforeach ?>
</div>
