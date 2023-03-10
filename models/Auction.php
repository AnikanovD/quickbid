<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "auction".
 *
 * @property int $id
 * @property string $name Name of the auction
 * @property string $photo Lot image
 * @property string $description Description of the auction
 * @property int $start_time Timestamp when the auction starts
 * @property int $end_time Timestamp when the auction ends
 * @property float $bid_step Auction bid step
 * @property float $starting_bid Starting bid for the auction
 * @property float|null $current_bid Current highest bid for the auction
 * @property int $state State of the auction (0 = new, 1 = started, 2 = finished)
 * @property int $created_at Timestamp when the auction was created
 * @property int $updated_at Timestamp when the auction was last updated
 *
 * @property Bid[] $bs
 */
class Auction extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'auction';
    }

    /**
     * {@inheritdoc}
     */
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

    /**
     * {@inheritdoc}
     */
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

    /**
     * Gets query for [[Bs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBs()
    {
        return $this->hasMany(Bid::class, ['auction_id' => 'id']);
    }
}
