<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%notify_transport}}".
 *
 * @property integer $id
 * @property integer $notify_user_id
 * @property string $transport_id
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property NotifyUser $notifyUser
 */
class NotifyTransport extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%notify_transport}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['notify_user_id', 'created_at', 'updated_at'], 'required'],
            [['notify_user_id', 'created_at', 'updated_at'], 'integer'],
            [['transport_id'], 'string', 'max' => 255],
            [['notify_user_id'], 'exist', 'skipOnError' => true, 'targetClass' => NotifyUser::className(), 'targetAttribute' => ['notify_user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'notify_user_id' => Yii::t('app', 'Notify User ID'),
            'transport_id' => Yii::t('app', 'Transport ID'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNotifyUser()
    {
        return $this->hasOne(NotifyUser::className(), ['id' => 'notify_user_id']);
    }
}
