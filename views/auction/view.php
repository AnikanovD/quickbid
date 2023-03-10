<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Auction */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Auctions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auction-view">
    <h1><?= Html::encode($this->title) ?></h1>
    <div class="row">
        <div class="col-md-6">
            <img src="<?= $model->getPhotoUrl() ?>" alt="<?= Html::encode($model->name) ?>" class="img-responsive" style="max-width: 100%;">
        </div>
        <div class="col-md-6">
            <h2>Description:</h2>
            <p><?= Html::encode($model->description) ?></p>
            <p>Starting Bid: <?= Yii::$app->formatter->asCurrency($model->starting_bid) ?></p>
            <p>Bid Step: <?= Yii::$app->formatter->asCurrency($model->bid_step) ?></p>
            <?php if ($model->state === \app\models\Auction::STATE_STARTED): ?>
                <p>Current Bid: <?= Yii::$app->formatter->asCurrency($model->current_bid) ?></p>
            <?php endif; ?>
            <p>Start Time: <?= Yii::$app->formatter->asDatetime($model->start_time) ?></p>
            <p>End Time: <?= Yii::$app->formatter->asDatetime($model->end_time) ?></p>
            <?php if ($model->state === \app\models\Auction::STATE_NEW): ?>
                <?= Html::a('Start Auction', ['start', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?php elseif ($model->state === \app\models\Auction::STATE_STARTED): ?>
                <?php if (!$model->isFinished()): ?>
                    <?= Html::a('Make Bid', ['bid', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
                <?php endif; ?>
                <?= Html::a('Finish Auction', ['finish', 'id' => $model->id], ['class' => 'btn btn-danger']) ?>
            <?php endif; ?>
        </div>
    </div>

    <?php if (!empty($bids)): ?>
        <h2>Bid History:</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>User</th>
                    <th>Amount</th>
                    <th>Date/Time</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($bids as $bid): ?>
                    <tr>
                        <td><?= Html::encode($bid->user->username) ?></td>
                        <td><?= Yii::$app->formatter->asCurrency($bid->amount) ?></td>
                        <td><?= Yii::$app->formatter->asDatetime($bid->created_at) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>
