<?php
namespace app\widgets;

use Yii;
use yii\base\InvalidConfigException;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\base\Widget;
use yii\data\Pagination;
/**
 * LinkPageSizer displays a list of hyperlinks that lead to different page sizes of a target.
 *
 * LinkPageSizer works with a [[Pagination]] object which specifies the total number
 * of pages and the current page number.
 *
 * Note that LinkPageSizer only generates the necessary HTML markups. In order for it
 * to look like a real pager, you should provide some CSS styles for it.
 * With the default configuration, LinkPageSizer should look good using Twitter Bootstrap CSS framework.
 */

 class PageSizer extends Widget
{
    /**
     * @var Pagination the pagination object that this pager is associated with.
     * You must set this property in order to make LinkPageSizer work.
     */
    public $pagination;
    /**
     * @var label
     */
    public $label = ' items per page';
    /**
     * @var array HTML attributes for the pager container tag.
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $availableSizes = [10 => '10', 20 => '20', 50 => '50'];
    /**
     * @var array HTML attributes for the pager container tag.
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $options = ['class' => 'pagination'];
    /**
     * @var array HTML attributes for the link in a pager container tag.
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $linkOptions = [];
    /**
     * @var string the CSS class for the active (currently selected) page size button.
     */
    public $activePageSizeCssClass = 'active';
    /**
     * Initializes the pager.
     */
    public function init()
    {
        if ($this->pagination === null) {
            throw new InvalidConfigException('The "pagination" property must be set.');
        }
    }
    /**
     * Executes the widget.
     * This overrides the parent implementation by displaying the generated page size buttons.
     */
    public function run()
    {
//        echo $this->renderPageSizeButtons();
        echo $this->renderPageSizeDropDown();
    }
    /**
     * Renders the page buttons.
     * @return string the rendering result
     */
    protected function renderPageSizeButtons()
    {
        if (count($this->availableSizes) === 0) {
            return '';
        }
        $buttons = [];
        $currentPageSize = $this->pagination->getPageSize();
        foreach ($this->availableSizes as $size => $label) {
            $buttons[]=$this->renderPageSizeButton($label, $size, null, $size==$currentPageSize);
        }
        return Html::tag('ul', implode("\n", $buttons), $this->options);
    }
    /**
     * Renders a page size button.
     * You may override this method to customize the generation of page size buttons.
     * @param string $label the text label for the button
     * @param integer $pageSize the page size
     * @param string $class the CSS class for the page button.
     * @param boolean $active whether this page button is active
     * @return string the rendering result
     */
    protected function renderPageSizeButton($label, $pageSize, $class, $active)
    {
        $options = ['class' => $class === '' ? null : $class];
        if ($active) {
            Html::addCssClass($options, $this->activePageSizeCssClass);
        }
        $linkOptions = $this->linkOptions;
        $linkOptions['data-page-size'] = $pageSize;
        return Html::tag('li', Html::a($label, PageSize::createSizeUrl($this->pagination, $pageSize), $linkOptions), $options);
    }
	
	protected function renderPageSizeDropDown()
	{
        if (count($this->availableSizes) === 0) {
            return '';
        }
		$options = [];
        $currentPageSize = $this->pagination->getPageSize();
		die($currentPageSize);
        foreach ($this->availableSizes as $size => $label) {
			$index = $this->renderOption($size);
            $options[$index] = $label;
			if ($size == $currentPageSize) $default = $options[$index];
        }
        $tag = ArrayHelper::remove($this->options, 'tag', 'div');
        return Html::tag($tag, Html::beginForm('', 'get') . Html::dropDownList($this->label, '', $options, ['onChange' => 'document.location=this.options[this.selectedIndex].value']) . Html::endForm(), $this->options); 
		
	}
	
	protected function renderOption($pageSize)
	{
		return PageSize::createSizeUrl($this->pagination, $pageSize);
	}
}