<?php
namespace app\traits;

use app\events\ArticleEvent;
use app\events\UserEvent;
use app\models\Article;
use app\models\User;
use yii\base\Model;

trait EventTrait
{
    /**
     * @param  Article      $article
     * @return ArticleEvent
     * @throws \yii\base\InvalidConfigException
     */
    protected function getArticleEvent(Article $article)
    {
        return \Yii::createObject(['class' => ArticleEvent::className(), 'article' => $article]);
    }

    /**
     * @param  User      $user
     * @return UserEvent
     * @throws \yii\base\InvalidConfigException
     */
    protected function getUserEvent(User $user)
    {
        return \Yii::createObject(['class' => UserEvent::className(), 'user' => $user]);
    }

}