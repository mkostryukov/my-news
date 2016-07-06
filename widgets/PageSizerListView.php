<?php

namespace app\widgets;

use Yii;
use yii\helpers\Html;
use yii\widgets\ListView;

class PageSizerListView extends ListView
{
    /**
     * @var string GET attribute
     */
    public $sizerAttribute = 'size';
 
    /**
     * @var array items per page sizes variants
     */
    public $sizerVariants = array(10, 20, 30);
 
    /**
     * @var string CSS class of sorter element
     */
    public $sizerCssClass = 'sizer';
 
    /**
     * @var string the text shown before sizer links. Defaults to empty.
     */
    public $sizerHeader = 'Show by: ';
 
    /**
     * @var string the text shown after sizer links. Defaults to empty.
     */
    public $sizerFooter = '';
	
    public function renderSection($name)
	{
        switch ($name) {
            case '{sizer}':
                return $this->renderSizer();
		}
		return parent::renderSection($name);
	}
 
    public function renderSizer()
    {
        $pagination = $this->dataProvider->getPagination();
        if ($pagination === false || $this->dataProvider->getCount() <= 0) {
            return '';
        }

        $pageVar = $pagination->getPage();    
        $pageSize = $pagination->getpageSize();    
 
//        $links = array();
 //       foreach ($this->sizerVariants as $count)
 //       {
//            $params = array_replace($_GET, array($this->sizerAttribute => $count));
 
//            if (isset($params[$pageVar]))
//                unset($params[$pageVar]);
 
//            if ($count == $pageSize)
//                $links[] = $count;
//            else {
				$route = Yii::$app->controller->route;
//				$params = array_merge([$route], $params);
//				$url = Yii::$app->urlManager->createUrl($params);                
//				$links[] = Html::a($count, $params);
//			}
//        }
        echo Html::beginForm([$route], 'get', ['class' => 'formHorizontal']);
        echo Html::dropDownList('per-page', $pageSize, array_combine($this->sizerVariants, $this->sizerVariants), ['onChange' => 'this.form.submit()']);
        echo Html::endForm();
//        echo Html::tag('div', $this->sizerHeader . implode(', ', $links), ['class' => $this->sizerCssClass]);
//        echo $this->sizerFooter;
    }
}