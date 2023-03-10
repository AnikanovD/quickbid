<?php

namespace app\commands;

use Yii;
use yii\console\Controller;
use yii\console\ExitCode;
use yii\helpers\Console;
use app\models\Auction;

class AuctionWorkerController extends Controller
{
    public function actionIndex()
    {
        while (true) {
            $auctions = Auction::find()->all();
            foreach ($auctions as $auction) {
                if ($auction->state == Auction::STATE_PENDING && $auction->start_time < time()) {
                    $auction->state = Auction::STATE_STARTED;
                    $auction->save();
                    $this->stdout("Auction '{$auction->name}' started.\n", Console::FG_GREEN);
                } elseif ($auction->state == Auction::STATE_STARTED && $auction->end_time < time()) {
                    $auction->state = Auction::STATE_FINISHED;
                    $auction->save();
                    $this->stdout("Auction '{$auction->name}' finished.\n", Console::FG_RED);
                }
            }
            sleep(1);
        }
        return ExitCode::OK;
    }
}
