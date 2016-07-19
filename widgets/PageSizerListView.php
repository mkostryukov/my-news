<?php

namespace app\widgets;

use Yii;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ListView;

class PageSizerListView extends ListView
{
    /**
     * @var string GET attribute
     */
    public $pagesizerAttribute = 'per-page';
 
    /**
     * @var array items per page sizes variants
     */
    public $pagesizerVariants = array(10, 20, 30);
 
    /**
     * @var array the HTML attributes for the pagesizer of the list view.
     * The "tag" element specifies the tag name of the pagesizer element and defaults to "div".
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $pagesizerOptions = ['class' => 'pagesizer'];
 
    /**
     * @var string the sizer labeltext.
     */
    public $pagesizerLabel = 'Show by: ';
 	

    public function renderSection($name)
	{
        switch ($name) {
            case '{pagesizer}':
                return $this->renderPagesizer();
		}
		return parent::renderSection($name);
	}
 
    public function renderPagesizer()
    {
        $pagination = $this->dataProvider->getPagination();
        if ($pagination === false || $this->dataProvider->getCount() <= 0) {
            return '';
        }

        $pageSize = $pagination->getPageSize();
		$params = $_GET;
 
		if (isset($params[$pagination->pageParam]))
			unset($params[$pagination->pageParam]);
 
		if (isset($params[$this->pagesizerAttribute]))
			unset($params[$this->pagesizerAttribute]);
		
		$out  = Html::beginForm(Yii::$app->urlManager->createUrl(array_merge([Yii::$app->controller->route], $params)), 'get', ['class' => 'form-Horizontal']);
		$out .= Html::tag('label', $this->pagesizerLabel);
		$out .= Html::dropDownList($this->pagesizerAttribute, $pageSize, array_combine($this->pagesizerVariants, $this->pagesizerVariants), ['onChange' => 'this.form.submit()', 'class' => 'form-control']);
		$out .= Html::endForm();
        
		$options = $this->pagesizerOptions;
        $tag = ArrayHelper::remove($options, 'tag', 'div');
		return Html::tag($tag, $out, $options);
    }
}