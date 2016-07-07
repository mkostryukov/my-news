<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%notification}}".
 *
 * @property integer $id
 * @property string $type
 * @property string $title
 * @property string $message
 * @property string $location
 * @property integer $recipient
 * @property integer $author
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property User $recipient0
 * @property User $author0
 */
class Notification extends \yii\db\ActiveRecord
{
    /** @inheritdoc */
    public function behaviors()
    {
        return [
            AuthorBehavior::className(),
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%notification}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'location', 'created_at', 'updated_at'], 'required'],
            [['message'], 'string'],
            [['recipient', 'author', 'created_at', 'updated_at'], 'integer'],
            [['type', 'title', 'location'], 'string', 'max' => 255],
            [['recipient'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['recipient' => 'id']],
            [['author'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['author' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'type' => Yii::t('app', 'Type'),
            'title' => Yii::t('app', 'Title'),
            'message' => Yii::t('app', 'Message'),
            'location' => Yii::t('app', 'Location'),
            'recipient' => Yii::t('app', 'Recipient'),
            'author' => Yii::t('app', 'Author'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRecipient()
    {
        return $this->hasOne(User::className(), ['id' => 'recipient']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRecipientProfile()
    {
        return $this->hasOne(Profile::className(), ['user_id' => 'recipient']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor()
    {
        return $this->hasOne(User::className(), ['id' => 'author']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthorProfile()
    {
        return $this->hasOne(Profile::className(), ['user_id' => 'author']);
    }

    /**
     * @inheritdoc
     * @return NotificationQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new NotificationQuery(get_called_class());
    }
}
