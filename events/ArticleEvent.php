<?php
namespace app\events;

use app\models\Article;
use yii\base\Event;

/**
 * @property Article $model
 */
class ArticleEvent extends Event
{
    /**
     * @var User
     */
    private $_article;

    /**
     * @return User
     */
    public function getArticle()
    {
        return $this->_article;
    }
}