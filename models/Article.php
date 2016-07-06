<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use \dektrium\user\models\Profile;
use app\behaviors\AuthorBehavior;

/**
 * This is the model class for table "{{%article}}".
 *
 * @property integer $id
 * @property string $title
 * @property string $intro
 * @property string $body
 * @property integer $status
 * @property integer $author
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property User $author0
 */
class Article extends \yii\db\ActiveRecord
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
        return '{{%article}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['intro', 'body'], 'string'],
            [['status', 'author', 'created_at', 'updated_at'], 'integer'],
            [['title'], 'string', 'max' => 255],
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
            'title' => Yii::t('app', 'Title'),
            'intro' => Yii::t('app', 'Intro'),
            'body' => Yii::t('app', 'Body'),
            'status' => Yii::t('app', 'Status'),
            'author' => Yii::t('app', 'Author'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor()
    {
        return $this->hasOne(User::className(), ['id' => 'author']);
    }

    public function getUserProfile()
    {
        return $this->hasOne(Profile::className(), ['user_id' => 'author']);
    }

    /**
     * @inheritdoc
     * @return ArticleQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ArticleQuery(get_called_class());
    }
}
