<?php

namespace app\modules\notifications\models;

use Yii;
use yii\db\ActiveRecord;
use app\models\User;

/**
 * This is the model class for table "{{%browsernotification}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $type
 * @property string $key
 * @property string $key_id
 * @property integer $seen
 * @property integer $created_at
 *
 * @property User $user
 */
class Browsernotification extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%browsernotification}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'type', 'key', 'key_id', 'seen', 'created_at'], 'required'],
            [['user_id', 'seen', 'created_at', 'key_id'], 'integer'],
            [['type', 'key'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'type' => Yii::t('app', 'Type'),
            'key' => Yii::t('app', 'Key'),
            'key_id' => Yii::t('app', 'Key ID'),
            'seen' => Yii::t('app', 'Seen'),
            'created_at' => Yii::t('app', 'Created At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
