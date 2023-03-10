<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "bid".
 *
 * @property int $id
 * @property int $auction_id
 * @property int $user_id
 * @property float $amount
 * @property int $created_at
 *
 * @property Auction $auction
 * @property User $user
 */
class Bid extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bid';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['auction_id', 'user_id', 'amount', 'created_at'], 'required'],
            [['auction_id', 'user_id', 'created_at'], 'integer'],
            [['amount'], 'number'],
            [['auction_id'], 'exist', 'skipOnError' => true, 'targetClass' => Auction::class, 'targetAttribute' => ['auction_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'auction_id' => 'Auction ID',
            'user_id' => 'User ID',
            'amount' => 'Amount',
            'created_at' => 'Created At',
        ];
    }

    /**
     * Gets query for [[Auction]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAuction()
    {
        return $this->hasOne(Auction::class, ['id' => 'auction_id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}
