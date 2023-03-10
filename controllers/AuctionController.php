<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Auction;
use app\models\BidForm;

class AuctionController extends Controller
{
    // Отображает список всех аукционов
    public function actionIndex()
    {
        $auctions = Auction::find()->all();
        return $this->render('index', ['auctions' => $auctions]);
    }

    // Отображает конкретный аукцион и форму для сделки ставки
    public function actionView($id)
    {
        $auction = Auction::findOne($id);

        if (!$auction) {
            throw new \yii\web\NotFoundHttpException('Аукцион не найден.');
        }

        $bidForm = new BidForm();

        if ($bidForm->load(Yii::$app->request->post()) && $bidForm->validate()) {
            // Проверяем, что текущая ставка больше минимальной ставки аукциона
            if ($bidForm->amount > $auction->min_bid) {
                $bid = new Bid();
                $bid->auction_id = $auction->id;
                $bid->user_id = Yii::$app->user->id;
                $bid->amount = $bidForm->amount;
                $bid->save();

                Yii::$app->session->setFlash('success', 'Ставка успешно сделана.');
                return $this->refresh();
            } else {
                $bidForm->addError('amount', 'Ваша ставка должна быть больше минимальной ставки аукциона.');
            }
        }

        return $this->render('view', ['auction' => $auction, 'bidForm' => $bidForm]);
    }
}
