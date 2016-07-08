<?php
namespace app\modules\notifications\models;

use Yii;
use yii\db\ActiveRecord;
use app\modules\notifications\NotificationTrait;
use app\modules\notifications\NotificationInterface;
use app\modules\notifications\NotificationsModule;

/**
 * This is the model class for table "notification".
 *
 * @property integer $id
 * @property integer $key_id
 * @property string $key
 * @property string $type
 * @property boolean $seen
 * @property string $created_at
 * @property integer $user_id
 */
abstract class Notification extends ActiveRecord implements NotificationInterface
{
	use NotificationTrait;
    
	public function poll()
	{
		return $this->save();
	}
	/**
     * Gets the notification title
     *
     * @return string
     */
    abstract public function getTitle();
    /**
     * Gets the notification description
     *
     * @return string
     */
    abstract public function getDescription();
    /**
     * Gets the notification route
     *
     * @return string
     */
    abstract public function getRoute();
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
            [['type', 'user_id', 'key', 'created_at'], 'required'],
            [['id', 'key_id', 'created_at'], 'safe'],
            [['key_id', 'user_id'], 'integer'],
        ];
    }
}