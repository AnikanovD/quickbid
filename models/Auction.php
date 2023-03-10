<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

class Auction extends ActiveRecord
{
    const STATE_PENDING = 0;
    const STATE_STARTED = 1;
    const STATE_FINISHED = 2;

    public static function tableName()
    {
        return 'auction';
    }

    public function rules()
    {
        return [
            [['name', 'photo', 'description', 'start_time', 'end_time', 'bid_step', 'starting_bid', 'created_at', 'updated_at'], 'required'],
            [['description'], 'string'],
            [['start_time', 'end_time', 'state', 'created_at', 'updated_at'], 'integer'],
            [['bid_step', 'starting_bid', 'current_bid'], 'number'],
            [['name', 'photo'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name of the auction',
            'photo' => 'Lot image',
            'description' => 'Description of the auction',
            'start_time' => 'Timestamp when the auction starts',
            'end_time' => 'Timestamp when the auction ends',
            'bid_step' => 'Auction bid step',
            'starting_bid' => 'Starting bid for the auction',
            'current_bid' => 'Current highest bid for the auction',
            'state' => 'State of the auction (0 = new, 1 = started, 2 = finished)',
            'created_at' => 'Timestamp when the auction was created',
            'updated_at' => 'Timestamp when the auction was last updated',
        ];
    }

    public function validateStartEndTime($attribute, $params)
    {
        $start = strtotime($this->start_time);
        $end = strtotime($this->end_time);
        if ($start >= $end) {
            $this->addError($attribute, 'End time must be greater than start time.');
        }
    }

    public function getCurrentBid()
    {
        return $this->hasOne(Bid::class, ['auction_id' => 'id'])->orderBy(['amount' => SORT_DESC]);
    }

    public function getBids()
    {
        return $this->hasMany(Bid::class, ['auction_id' => 'id'])->orderBy(['amount' => SORT_DESC]);
    }

    public function getMinBidAmount()
    {
        $currentBid = $this->currentBid;
        return $currentBid ? $currentBid->amount + $this->bid_step : $this->starting_bid;
    }

    public function getStateLabel()
    {
        $states = [
            self::STATE_PENDING => 'Pending',
            self::STATE_ACTIVE => 'Active',
            self::STATE_FINISHED => 'Finished',
        ];
        return ArrayHelper::getValue($states, $this->state);
    }

    public function isPending()
    {
        return $this->state === self::STATE_PENDING;
    }

    public function isStarted()
    {
        return $this->state === self::STATE_STARTED;
    }

    public function isFinished()
    {
        return $this->state === self::STATE_FINISHED;
    }
    
    public function updateStatus()
    {
        $now = time();

        if ($now < $this->start_time) {
            $this->state = self::STATE_PENDING;
        } elseif ($now >= $this->start_time && $now <= $this->end_time) {
            $this->state = self::STATE_STARTED;
        } elseif ($now > $this->end_time) {
            $this->state = self::STATE_FINISHED;
        }

        $this->save(false, ['state']);
    }
}