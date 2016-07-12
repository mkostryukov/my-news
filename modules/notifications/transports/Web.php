<?php
namespace app\modules\notifications\transports;

use Yii;
use yii\db\ActiveRecord;
use app\modules\notifications\models\Notification;

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
class Web extends BaseNotificationTransport
{		
    public function sendNotification(Notification $notification) {
        
    }

    /**
     * @inheritdoc
     */
    protected function defaultName()
    {
        return 'Web notifications';
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
            [['type', 'user_id', 'key', 'created_at'], 'required'],
            [['id', 'key_id', 'created_at'], 'safe'],
            [['key_id', 'user_id'], 'integer'],
        ];
    }
}