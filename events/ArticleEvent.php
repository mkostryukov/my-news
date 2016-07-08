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
     * @var Article
     */
    private $_article;

    /**
     * @return Article
     */
    public function getArticle()
    {
        return $this->_article;
    }
	
	public function setArticle(Article $form)
	{
        $this->_article = $form;
	}
}